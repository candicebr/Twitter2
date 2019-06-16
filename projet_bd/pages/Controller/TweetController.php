<?php


namespace Controller;
use Controller\ControllerBase;
use App\Src\App;
use Model\Gateway\TweetGateway;
use App\Src\Request\Request;


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

        if(!$result) {
            $this->app->getService('render')('tweeter', ['tweet' => $tweet, 'error' => true]);
        }

        $this->redirect('/profilTweet');
    }



    //Supprimer un tweet
    public function deleteTweetDBHandler(Request $request, $tweet_id)
    {
        $result = new TweetGateway($this->app);
        $result->delete($tweet_id);

        $this->redirect('/profilTweet');

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