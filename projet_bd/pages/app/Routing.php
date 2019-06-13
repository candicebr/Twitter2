<?php
namespace app;
use app\src\App;
use controller\FollowController;
use controller\LikesController;
use controller\RetweetController;
use controller\UserController;
use controller\TweetController;
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
        //cities
        /*$city = new CityController($this->app);
        $this->app->get('/', [$city, 'citiesHandler']);
        $this->app->get('/city/(\d+)', [$city, 'cityHandler']);
        $this->app->get('/recherche.php/(\w*)', [$city, 'searchHandler']);
        $this->app->get('/recherche.php', [$city, 'searchHandlerV']);
        $this->app->get('/create.php', [$city, 'createHandler']);
        $this->app->post('/handleCreate.php', [$city, 'createDBHandler']);
        // $this->app->post('/deleteCities.php', [$city, 'deleteDBHandlerCities']);
        */

        $this->app->get('/', function() {
        return $this->app->getService('render')('index1');
        });

        $user = new UserController($this->app);
        $tweet = new TweetController($this->app);
        $follow = new FollowController($this->app);
        $like = new LikesController($this->app);
        $retweet = new RetweetController($this->app);

        //Inscription
        $this->app->get('/inscription.php', [$user, 'createHandler']);
        $this->app->post('/traitement.php', [$user, 'createDBHandler']);


        //Connection
        $this->app->get('/index1.php', [$user, 'connectionHandler']);
        $this->app->post('/traitementConnection.php', [$user, 'connectionDBHandler']);

        //Accueil
        $this->app->get('/tl.php', [$tweet, 'ActualiteHandler']);

        //Profil
        $this->app->get('/profilTweet.php', [$user, 'profilHandler']);

        //Recherche
        $this->app->get('/recherche.php', [$user, 'rechercheHandler']);
        $this->app->post('/traitementRecherche.php', [$user, 'rechercheDBHandler']);

        //Tweeter
        $this->app->get('/tweeter.php', [$tweet, 'createTweetHandler']);
        $this->app->post('/traitementTweet.php', [$tweet, 'createTweetDBHandler']);

        //EditerProfil
        $this->app->get('/changeProfil.php', [$user, 'changeProfilHandler']);
        $this->app->post('/traitementChangeProfil.php', [$user, 'changeProfilDBHandler']);

        //Suivre Abonnement et Abonnés
        $this->app->get('/traitementSuivre.php/(\d+)', [$follow, 'abonnementDBHandler']);
        $this->app->get('/profilAbonnement.php', [$user, 'UserFollowedHandler']);
        $this->app->get('/profilAbonnés.php', [$user, 'UserFollowerHandler']);

        //Profil Abonnement
        $this->app->get('profilOtherPeopleAbonnement.php/(\d+)', [$user, 'UserFollowedProfilHandler']);

        //Likes et liker
        $this->app->get('/traitementLike.php/(\d+)', [$like, 'likeDBHandler']);
        $this->app->get('/profilLike.php',[$user, 'UserLikesHandler']);
        

        //Retweet
        $this->app->get('/traitementRetweet.php/(\d+)', [$retweet, 'retweetDBHandler']);

        //SupprimerTweet
        $this->app->get('/traitementSuppTweet.php/(\d+)', [$tweet, 'deleteTweetDBHandler']);
    }
}