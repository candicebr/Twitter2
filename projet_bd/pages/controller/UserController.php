<?php


namespace controller;
use Controller\ControllerBase;
use app\src\App;
use model\gateway\TweetGateway;
use model\gateway\UserGateway;
use app\src\Request\Request;


class UserController extends ControllerBase
{
    public function __construct(App $app) {
        parent::__construct($app);
    }

   //Inscription
    public function createHandler(Request $request) {
        return $this->app->getService('render')('inscription');
    }

    public function createDBHandler(Request $request) {

        $result = new UserGateway($this->app);
        if ($_POST['user_name'] != null) //Si le nom d'utilisateur est fournis
        {
            $user_name = $this->app->getService('UserFinder')->findNameByName($request->getParameters('user_name'));
            if ($user_name == null) //Si le nom d'utilisateur n'existe pas dans la table
            {
                $result->setUserName($request->getParameters('user_name'));
            } else {
                $flashInscription = "Ce nom d'utilisateur existe déjà";
                $_SESSION['flashInscription'] = $flashInscription;
                $this->redirect('/projet_bd/pages/inscription');
            }
        }
        else {
            $flashInscription= "Veuillez entrer un utilisateur";
            $_SESSION['flashInscription'] =$flashInscription;
            $this->redirect('/projet_bd/pages/inscription');
        }

        if ($_POST['password'] != null) //Si le mot de passe est fournis
        {
            $result->setPassword($request->getParameters('password'));
        }
        else{
            $flashInscription= "Veuillez entrer un mot de passe";
            $_SESSION['flashInscription'] =$flashInscription;
            $this->redirect('/projet_bd/pages/inscription');
        }

        $user = [

            $result->getUserName(),
            $result->setPseudo($request->getParameters('pseudo')),
            $result->getPassword(),
            $result->setBirth($request->getParameters('birth'))
        ];

        $result->insert();

        //Initialisation de la session de l'utilsateur connecté
        $_SESSION['id'] = $result->getId();
        $_SESSION['user_name'] = $result->getUserName();
        $_SESSION['pseudo'] = $result->getPseudo();
        $_SESSION['birth'] = $result->getBirth();
        $_SESSION['info_perso'] = $result->getInfoPerso();
        //$_SESSION['nombre_tweet'] = $tweetResult->nbTweet($_SESSION['id']);

        if(!$result) {
            $this->app->getService('render')('inscription', ['user' => $user, 'error' => true]);
        }

        $this->redirect('/projet_bd/pages/tl');
    }

    //Connection
    public function connectionHandler(Request $request) {
        return $this->app->getService('render')('index1');
    }

    public function connectionDBHandler(Request $request) {

        $user_name = $this->app->getService('UserFinder')->findNameByName($request->getParameters('user_name'));
        $user_password = $this->app->getService('UserFinder')->findPasswordByName($request->getParameters('user_name'));

        $flash= "Nom d'utilisateur inconnu";
        $flash2="Mot de passe éronné";

        if(isset($_POST['user_name']) && $request->getParameters('user_name')==$user_name["user_name"]) //Si le nom d'utilisateur est saisis et qu'il existe dans la table
        {
            if(isset($_POST['password']) && password_verify($request->getParameters('password'),$user_password["password"]))//Si le mot de passe est saisis et qu'il correspond au mot de passe de l'utilisateur saisis
            {
                $user = $this->app->getService('UserFinder')->findUserByLogin(htmlspecialchars($_POST['user_name']));

                //Initialisation de la session de l'utilisateur connecté
                $_SESSION['id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['birth'] = $user['birth'];
                $_SESSION['info_perso'] = $user['info_perso'];
                //$_SESSION['nombre_tweet'] = $tweetResult->nbTweet();

                $this->redirect('/projet_bd/pages/tl');
            }
            else{
                $_SESSION['flash'] =$flash2;
                $this->redirect('/projet_bd/pages/index1');
            }
        }
        else{
            $_SESSION['flash'] =$flash;
            $this->redirect('/projet_bd/pages/index1');
        }
    }

    //Deconnection
    public function deconnectionHandler(Request $request)
    {
        session_destroy();
        $this->redirect('/projet_bd/pages/index1');
    }


    //Recherche
    public function rechercheHandler(Request $request) {
        return $this->app->getService('render')('recherche');

    }

    public function rechercheDBHandler(Request $request) {

        //$result = new UserGateway($this->app);
        $users = $this->app->getService('UserFinder')->findUserByName(htmlspecialchars($_POST['recherche']));
        return $this->app->getService('render')('recherche', ['users' => $users]);

    }

    //Editer le profil
    public function changeProfilHandler(Request $request)
    {
        return $this->app->getService('render')('changeProfil');
    }

    public function changeProfilDBHandler(Request $request)
    {
        $result = new UserGateway($this->app);

        if ($_POST['pseudo'] != null) //Si on modifie son pseudo
        {
            $result->setPseudo($request->getParameters('pseudo'));
        }
        else{
            $result->setPseudo($_SESSION['pseudo']);
        }

        if ($_POST['info_perso'] != null) //Si on modifie sa bio
        {
            $result->setInfoPerso($request->getParameters('info_perso'));
        }
        else{
            $result->setInfoPerso($_SESSION['info_perso']);
        }

        if ($_POST['birth'] != null) //Si on modifie sa date de naissance
        {
            $result->setBirth($request->getParameters('birth'));
        }
        else{
            $result->setBirth($_SESSION['birth']);
        }

        $result->update();

        $user = [
            $result->getPseudo(),
            $result->getBirth(),
            $result->getInfoPerso()
        ];

        //Mise à jour de la session de l'utilisateur
        $_SESSION['pseudo'] = $result->getPseudo();
        $_SESSION['birth'] = $result->getBirth();
        $_SESSION['info_perso'] = $result->getInfoPerso();


        if(!$result) {
            $this->app->getService('render')('changeProfil', ['user' => $user, 'error' => true]);
        }

        $this->redirect('/projet_bd/pages/profilTweet');

    }

    //Liste des abonnements
    public function UserFollowedHandler(Request $request)
    {
        $user = $_SESSION;
        $users = $this->app->getService('UserFinder')->findUserFollowed();
        return $this->app->getService('render')('profilAbonnement', ['users' => $users, 'user' => $user]);
    }

    //Liste des abonnés
    public function UserFollowerHandler(Request $request)
    {
        $user = $_SESSION;
        $users = $this->app->getService('UserFinder')->findUserFollower();
        return $this->app->getService('render')('profilAbonnés', ['users' => $users, 'user' => $user]);
    }

    //Liste des tweets aimés
    public function UserLikesHandler(Request $request)
    {
        $user = $_SESSION;
        $tweets = $this->app->getService('TweetFinder')->findLikes();
        return $this->app->getService('render')('profilLike', ['tweets' => $tweets, 'user' => $user]);
    }

    //Profil de l'utilisateur avec ses tweets et retweets
    public function profilHandler(Request $request)
    {
        $user = $_SESSION;
        $tweets = $this->app->getService('TweetFinder')->findActuPerso($_SESSION['id']);
        return $this->app->getService('render')('profilTweet', ['user' => $user, 'tweets' => $tweets]);
    }

    //Profil des utilisateurs suivis
    public function UserFollowedProfilHandler(Request $request, $id)
    {
        $user = $this->app->getService('UserFinder')->findUserById($id);
        $tweets = $this->app->getService('TweetFinder')->findActuPerso($id);
        return $this->app->getService('render')('profilOtherPeopleAbonnement', ['user' => $user, 'tweets' => $tweets]);
    }





}