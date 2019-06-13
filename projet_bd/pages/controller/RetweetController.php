<?php


namespace controller;
use Controller\ControllerBase;
use app\src\App;
use model\gateway\RetweetGateway;
use app\src\Request\Request;


class RetweetController extends ControllerBase
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function retweetDBHandler(Request $request, $id)
    {

        $like = $this->app->getService('RetweetFinder')->findRetweetById($id);

        $result = new RetweetGateway($this->app);

        $result->setRetweetUserId($_SESSION['id']);
        $result->setRetweetTweetId($id);

        if ($like == null) //si il ne fait pas partie des retweet
        {

            $result->insert();

            $this->redirect('/projet_bd/pages/profilTweet.php');

        } else {

            $result->delete();

            $this->redirect('/projet_bd/pages/profilTweet.php');
        }
    }
}