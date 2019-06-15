<?php


namespace Controller;
use Controller\ControllerBase;
use App\Src\App;
use Model\Gateway\FollowGateway;
use App\Src\Request\Request;


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
            $this->redirect('/projet_bd/pages/profilTweet');
            return $this->app->getService('render')('profilTweet', ['followed' => $followed]);

        }
        else{

            $result->delete();
            $this->redirect('/projet_bd/pages/profilTweet');
            return $this->app->getService('render')('profilAbonnés', ['users' => $users, 'user' => $user]);

        }

    }
}