<?php


namespace controller;
use Controller\ControllerBase;
use app\src\App;
use model\gateway\FollowGateway;
use app\src\Request\Request;


class FollowController extends ControllerBase
{
    public function __construct(App $app) {
        parent::__construct($app);
    }

    public function abonnementDBHandler(Request $request, $id)
    {

        $followed = $this->app->getService('FollowFinder')->findFollowedById($id);

        $result = new FollowGateway($this->app);

        $result->setUserFollowerId($_SESSION['id']);
        $result->setUserFollowedId($id);

        if($followed == null) //si il ne fait pas partie des abonnements
        {
            $result->insert();

            $this->redirect('/projet_bd/pages/profilTweet.php');

        }
        else{

            $result->delete();

            $this->redirect('/projet_bd/pages/profilTweet.php');

        }

    }
}