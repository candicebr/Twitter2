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

    public function createHandler(Request $request) {
        return $this->app->getService('render')('inscription');
    }

    public function createDBHandler(Request $request) {

        $result = new UserGateway($this->app);
        //$tweetResult = new TweetGateway($this->app);
        if ($_POST['user_name'] != null) {
            $user_name = $this->app->getService('UserFinder')->findNameByName($request->getParameters('user_name'));
            if ($user_name == null) {
                $result->setUserName($request->getParameters('user_name'));
            } else {
                $flashInscription = "Ce nom d'utilisateur existe déjà";
                $_SESSION['flashInscription'] = $flashInscription;
                $this->redirect('/projet_bd/pages/inscription.php');
            }
        }
        else{
            $flashInscription= "Veuillez entrer un utilisateur";
            $_SESSION['flashInscription'] =$flashInscription;
            $this->redirect('/projet_bd/pages/inscription.php');
        }

        if ($_POST['password'] != null)
        {
            $result->setPassword($request->getParameters('password'));
        }
        else{
            $flashInscription= "Veuillez entrer un mot de passe";
            $_SESSION['flashInscription'] =$flashInscription;
            $this->redirect('/projet_bd/pages/inscription.php');
        }

        $user = [

            $result->getUserName(),
            $result->setPseudo($request->getParameters('pseudo')),
            $result->getPassword(),
            $result->setBirth($request->getParameters('birth'))

        ];

        $result->insert();

        $_SESSION['id'] = $result->getId();
        $_SESSION['user_name'] = $result->getUserName();
        $_SESSION['pseudo'] = $result->getPseudo();

        $_SESSION['birth'] = $result->getBirth();
        $_SESSION['info_perso'] = $result->getInfoPerso();
        //$_SESSION['nombre_tweet'] = $tweetResult->nbTweet($_SESSION['id']);

        if(!$result) {
            $this->app->getService('render')('inscription', ['user' => $user, 'error' => true]);
        }

        $this->redirect('/projet_bd/pages/tl.php');

    }

    public function connectionHandler(Request $request) {
        return $this->app->getService('render')('index1');
    }

    public function connectionDBHandler(Request $request) {


        $user_name = $this->app->getService('UserFinder')->findNameByName($request->getParameters('user_name'));
        $user_password = $this->app->getService('UserFinder')->findPasswordByName($request->getParameters('user_name'));


        $flash= "Nom d'utilisateur inconnu";
        $flash2="Mode de passe éronné";

        if(isset($_POST['user_name']) && $request->getParameters('user_name')==$user_name["user_name"])
        {
            if(isset($_POST['password']) && password_verify($request->getParameters('password'),$user_password["password"]))
            {

                $result = new UserGateway($this->app);
                $tweetResult = new TweetGateway($this->app);

                $user = $this->app->getService('UserFinder')->findUserByLogin(htmlspecialchars($_POST['user_name']));

                $_SESSION['id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['birth'] = $user['birth'];
                $_SESSION['info_perso'] = $user['info_perso'];

                //$_SESSION['nombre_tweet'] = $tweetResult->nbTweet();

                $this->redirect('/projet_bd/pages/tl.php');
            }
            else{
                $_SESSION['flash'] =$flash2;
                $this->redirect('/projet_bd/pages/index1.php');
            }
        }
        else{
            $_SESSION['flash'] =$flash;
            $this->redirect('/projet_bd/pages/index1.php');
        }
    }


    //Recherche
    public function rechercheHandler(Request $request) {
        return $this->app->getService('render')('recherche');

    }

    public function rechercheDBHandler(Request $request) {

        $result = new UserGateway($this->app);
        $users = $this->app->getService('UserFinder')->findUserByName(htmlspecialchars($_POST['recherche']));
        return $this->app->getService('render')('recherche', ['users' => $users]);

    }

    public function changeProfilHandler(Request $request)
    {
        return $this->app->getService('render')('changeProfil');
    }

    public function changeProfilDBHandler(Request $request)
    {
        $result = new UserGateway($this->app);

        if ($_POST['pseudo'] != null)
        {
            $result->setPseudo($request->getParameters('pseudo'));
        }
        else{
            $result->setPseudo($_SESSION['pseudo']);
        }

        if ($_POST['info_perso'] != null)
        {
            $result->setInfoPerso($request->getParameters('info_perso'));
        }
        else{
            $result->setInfoPerso($_SESSION['info_perso']);
        }

        if ($_POST['birth'] != null)
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


        $_SESSION['pseudo'] = $result->getPseudo();
        $_SESSION['birth'] = $result->getBirth();
        $_SESSION['info_perso'] = $result->getInfoPerso();


        if(!$result) {
            $this->app->getService('render')('changeProfil', ['user' => $user, 'error' => true]);
        }

        $this->redirect('/projet_bd/pages/profilTweet.php');

    }

    public function UserFollowedHandler(Request $request)
    {
        $user = $_SESSION;
        $users = $this->app->getService('UserFinder')->findUserFollowed();
        return $this->app->getService('render')('profilAbonnement', ['users' => $users, 'user' => $user]);
    }

    public function UserFollowerHandler(Request $request)
    {
        $user = $_SESSION;
        $users = $this->app->getService('UserFinder')->findUserFollower();
        return $this->app->getService('render')('profilAbonnés', ['users' => $users, 'user' => $user]);
    }

    public function UserLikesHandler(Request $request)
    {
        $user = $_SESSION;
        $tweets = $this->app->getService('TweetFinder')->findLikes();
        return $this->app->getService('render')('profilLike', ['tweets' => $tweets, 'user' => $user]);
    }

    public function profilHandler(Request $request)
    {
        $user = $_SESSION;
        $tweets = $this->app->getService('TweetFinder')->findActuPerso();
        return $this->app->getService('render')('profilTweet', ['user' => $user, 'tweets' => $tweets]);
    }

    public function UserFollowedProfilHandler(Request $request, $id)
    {
        $user = $this->app->getService('UserFinder')->findUserById($id);
        $tweets = $this->app->getService('TweetFinder')->findTweetsByUser($id);
        return $this->app->getService('render')('profilOtherPeopleAbonnement', ['user' => $user, 'tweets' => $tweets]);
    }




}