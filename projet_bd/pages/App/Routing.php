<?php
namespace App;
use App\src\App;
use Controller\FollowController;
use Controller\LikesController;
use Controller\RetweetController;
use Controller\UserController;
use Controller\TweetController;
class Routing
{
    private $app;
    /**
     *Routing constructor
     *@param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
    }
    public function setup() {


        $this->app->get('/', function() {
        return $this->app->getService('render')('index1');
        });

        $user = new UserController($this->app);
        $tweet = new TweetController($this->app);
        $follow = new FollowController($this->app);
        $like = new LikesController($this->app);
        $retweet = new RetweetController($this->app);

        //Inscription
        $this->app->get('/inscription', [$user, 'createHandler']);
        $this->app->post('/traitement', [$user, 'createDBHandler']);


        //Connection
        $this->app->get('/index1', [$user, 'connectionHandler']);
        $this->app->post('/traitementConnection', [$user, 'connectionDBHandler']);

        //Deconnection
        $this->app->get('/traitementDeconnection', [$user, 'deconnectionHandler']);

        //Accueil
        $this->app->get('/tl', [$tweet, 'AccueilHandler']);

        //Profil
        $this->app->get('/profilTweet', [$user, 'profilHandler']);

        //Recherche
        $this->app->get('/recherche', [$user, 'rechercheHandler']);
        $this->app->post('/traitementRecherche', [$user, 'rechercheDBHandler']);

        //Tweeter
        $this->app->get('/tweeter', [$tweet, 'createTweetHandler']);
        $this->app->post('/traitementTweet', [$tweet, 'createTweetDBHandler']);

        //EditerProfil
        $this->app->get('/changeProfil', [$user, 'changeProfilHandler']);
        $this->app->post('/traitementChangeProfil', [$user, 'changeProfilDBHandler']);

        //Suivre Abonnement et Abonnés
        $this->app->get('/traitementSuivre/(\d+)', [$follow, 'abonnementDBHandler']);
        $this->app->get('/profilAbonnement', [$user, 'UserFollowedHandler']);
        $this->app->get('/profilAbonnes', [$user, 'UserFollowerHandler']);

        //Profil Abonnement
        $this->app->get('/profilOtherPeopleAbonnement/(\d+)', [$user, 'UserFollowedProfilHandler']);

        //Likes et liker
        $this->app->get('/traitementLike/(\d+)', [$like, 'likeDBHandler']);
        $this->app->get('/profilLike',[$user, 'UserLikesHandler']);

        //Retweet
        $this->app->get('/traitementRetweet/(\d+)', [$retweet, 'retweetDBHandler']);

        //SupprimerTweet
        $this->app->get('/traitementSuppTweet/(\d+)', [$tweet, 'deleteTweetDBHandler']);

    }
}