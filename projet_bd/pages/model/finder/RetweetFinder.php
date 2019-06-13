<?php


namespace model\finder;


use app\src\App;
use model\gateway\RetweetGateway;

class RetweetFinder
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

    public function findRetweetById($id)
    {
        $query = $this->conn->prepare('SELECT r.retweet_tweet_id FROM retweet r WHERE r.retweet_tweet_id = :retweet_tweet_id');
        $query->execute([':retweet_tweet_id' => $id] ); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element == 0) return null;

        return $element;
    }

    public function findRetweetByUser($user_id)
    {
        $query = $this->conn->prepare('SELECT r.retweet_tweet_id FROM retweet r WHERE r.retweet_user_id = :retweet_user_id');
        $query->execute([':retweet_user_id' => $user_id]); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($elements == 0) return null;

        $retweets = [];
        $retweet = null;

        foreach ($elements as $element)
        {
            $retweet = new RetweetGateway($this->app);
            //$retweet->hydrate($element);

            $retweets[] = $retweet;
        }

        return $retweets;
    }
}