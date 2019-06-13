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

    public function createTweetHandler(Request $request) {
        return $this->app->getService('render')('tweeter');
    }

    public function createTweetDBHandler(Request $request) {

        $result = new TweetGateway($this->app);

        $tweet = [

            $result->setTweetContent($request->getParameters('tweet_content')),
            //$result->setTweetDate(date("Y-m-d")),
            $result->setTweetUserId($_SESSION['id']),

        ];

        $result->insert();

        $_SESSION['nombre_tweet'] = $result->nbTweet($_SESSION['id']);


        if(!$result) {
            $this->app->getService('render')('tweeter', ['tweet' => $tweet, 'error' => true]);
        }


        $this->redirect('/projet_bd/pages/profilTweet.php');

    }

    public function deleteTweetDBHandler(Request $request, $tweet_id)
    {
        $result = new TweetGateway($this->app);

        $result->delete($tweet_id);
        $this->redirect('/projet_bd/pages/profilTweet.php');
    }

    public function ActualiteHandler(Request $request)
    {
        $tweets = $this->app->getService('TweetFinder')->findActu();
        return $this->app->getService('render')('tl', ['tweets' => $tweets]);
    }


}