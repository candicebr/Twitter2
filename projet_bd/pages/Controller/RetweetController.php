<?php


namespace Controller;
use Controller\ControllerBase;
use App\src\App;
use Model\Gateway\RetweetGateway;
use App\Src\Request\Request;


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
            $this->redirect('/profilTweet');

        } else {

            $result->delete();
            $this->redirect('/profilTweet');
        }
    }
}