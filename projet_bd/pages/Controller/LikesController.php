<?php


namespace Controller;
use Controller\ControllerBase;
use App\Src\App;
use Model\Gateway\LikesGateway;
use App\Src\Request\Request;



class LikesController extends ControllerBase
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function likeDBHandler(Request $request, $id)
    {
        $like = $this->app->getService('LikesFinder')->findLikeById($id);

        $result = new LikesGateway($this->app);
        $result->setLikesUserId($_SESSION['id']);
        $result->setLikesTweetId($id);

        if ($like == null) //si il ne fait pas partie des likes
        {
            $result->insert();
            $this->redirect('/projet_bd/pages/profilTweet');

        } else {

            $result->delete();
            $this->redirect('/projet_bd/pages/profilTweet');
        }
    }
}