<?php


namespace model\finder;
use app\src\App;
use Model\gateway\LikesGateway;


class LikesFinder
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

    public function findLikeById($id)
    {
        $query = $this->conn->prepare('SELECT l.likes_tweet_id FROM likes l WHERE l.likes_tweet_id = :likes_tweet_id');
        $query->execute([':likes_tweet_id' => $id] ); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element == 0) return null;

        return $element;
    }

}