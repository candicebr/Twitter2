<?php


namespace model\finder;

use app\src\App;
use Model\gateway\FollowGateway;

class FollowFinder
{
    /**
     * @var \PDO
     */
    private $conn;

    /**
     * @var App
     */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->conn = $this->app->getService('database')->getConnection();
    }


    public function findFollowedById($id)
    {
        $query = $this->conn->prepare('SELECT f.user_followed_id FROM follow f WHERE f.user_followed_id = :user_followed_id');
        $query->execute([':user_followed_id' => $id] ); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element == 0) return null;

        return $element;
    }

    public function findNbAbonnement($id)
    {
        $query = $this->conn->prepare('SELECT COUNT(*) FROM follow f INNER JOIN user u ON u.id = f.user_follower_id WHERE u.id = :id');
        $query->execute([':id' => $id]);
        $element = $query->fetch(\PDO::FETCH_ASSOC);
        return $element;
    }

    public function findNbAbonne($id)
    {
        $query = $this->conn->prepare('SELECT COUNT(*) FROM follow f INNER JOIN user u ON u.id = f.user_followed_id WHERE u.id = :id');
        $query->execute([':id' => $id]);
        $element = $query->fetch(\PDO::FETCH_ASSOC);
        return $element;
    }

}