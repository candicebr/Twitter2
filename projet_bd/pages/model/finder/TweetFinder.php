<?php


namespace model\finder;

use app\src\App;
use Model\gateway\TweetGateway;


class TweetFinder
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

    public function findTweetByUser($id)
    {
        $query = $this->conn->prepare('SELECT t.tweet_id, t.tweet_content, t.tweet_date, t.tweet_user_id FROM tweet t WHERE t.tweet_user_id = :tweet_user_id ORDER BY t.tweet_date');
        $query->execute([':tweet_user_id' => $id]); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($elements == 0) return null;

        $tweets = [];
        $tweet = null;

        foreach ($elements as $element)
        {
            $tweet = new TweetGateway($this->app);
            $tweet->hydrate($element);

            $tweets[] = $tweet;
        }

        return $tweets;

    }

    public function findActuPerso()
    {
        $query = $this->conn->prepare('SELECT t.tweet_content, t.tweet_date, t.tweet_id, t.tweet_user_id, u.user_name FROM tweet t LEFT OUTER JOIN retweet r ON t.tweet_id = r.retweet_tweet_id INNER JOIN user u ON u.id = t.tweet_user_id WHERE r.retweet_user_id = :tweet_user_id OR t.tweet_user_id = :tweet_user_id ORDER BY t.tweet_date DESC');
        $query->execute([':tweet_user_id' => $_SESSION['id']]); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($elements == 0) return null;

        $tweets = [];
        $tweet = null;

        foreach ($elements as $element)
        {
            $tweet = new TweetGateway($this->app);
            $tweet->hydrate($element);

            $tweets[] = $tweet;
        }

        return $tweets;
    }

    public function findActu()
    {
        $query = $this->conn->prepare('SELECT t.tweet_content, t.tweet_date, t.tweet_id, t.tweet_user_id, u.user_name FROM tweet t INNER JOIN user u ON u.id = t.tweet_user_id INNER JOIN follow f ON t.tweet_user_id = f.user_followed_id WHERE f.user_follower_id = :id OR t.tweet_user_id = :id ORDER BY t.tweet_date DESC');
        $query->execute([':id' => $_SESSION['id']]); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($elements == 0) return null;

        $tweets = [];
        $tweet = null;

        foreach ($elements as $element)
        {
            $tweet = new TweetGateway($this->app);
            $tweet->hydrate($element);

            $tweets[] = $tweet;
        }

        return $tweets;
    }

    public function  findLikes()
    {
        $query = $this->conn->prepare('SELECT t.tweet_content, t.tweet_date, t.tweet_id, t.tweet_user_id, u.user_name FROM tweet t INNER JOIN user u ON u.id = t.tweet_user_id INNER JOIN likes l ON t.tweet_id = l.likes_tweet_id WHERE l.likes_user_id = :id ORDER BY t.tweet_date DESC');
        $query->execute([':id' => $_SESSION['id']]); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($elements == 0) return null;

        $tweets = [];
        $tweet = null;

        foreach ($elements as $element)
        {
            $tweet = new TweetGateway($this->app);
            $tweet->hydrate($element);

            $tweets[] = $tweet;
        }

        return $tweets;
    }
}