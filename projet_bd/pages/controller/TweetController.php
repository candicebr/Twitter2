<?php


namespace controller;
use Controller\ControllerBase;
use app\src\App;
use model\gateway\TweetGateway;
use app\src\Request\Request;


class TweetController extends ControllerBase
{
    public function __construct(App $app) {
        parent::__construct($app);
    }

    //Créer un tweet
    public function createTweetHandler(Request $request) {
        return $this->app->getService('render')('tweeter');
    }

    public function createTweetDBHandler(Request $request) {

        $result = new TweetGateway($this->app);

        $tweet = [

            $result->setTweetContent($request->getParameters('tweet_content')),
            $result->setTweetUserId($_SESSION['id']),

        ];

        $result->insert();

        //$_SESSION['nombre_tweet'] = $result->nbTweet($_SESSION['id']);

        if(!$result) {
            $this->app->getService('render')('tweeter', ['tweet' => $tweet, 'error' => true]);
        }


        $this->redirect('/projet_bd/pages/profilTweet');

    }



    //Supprimer un tweet
    public function deleteTweetDBHandler(Request $request, $tweet_id)
    {
        $result = new TweetGateway($this->app);
        $result->delete($tweet_id);

        $this->redirect('/projet_bd/pages/profilTweet');

    }

    //File d'actualité
    public function AccueilHandler(Request $request)
    {
        $tweets = $this->app->getService('TweetFinder')->findActu();
        $nb_tweets = $this->app->getService('TweetFinder')->findNbTweet($_SESSION['id']);
        $nb_abonnement=$this->app->getService('FollowFinder')->findNbAbonnement($_SESSION['id']);
        $nb_abonne=$this->app->getService('FollowFinder')->findNbAbonne($_SESSION['id']);

        return $this->app->getService('render')('tl', ['tweets' => $tweets, 'nb_tweets' => $nb_tweets, 'nb_abonnement' => $nb_abonnement, 'nb_abonne' => $nb_abonne]);
    }


}