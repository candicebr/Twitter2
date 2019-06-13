<?php


namespace model\gateway;
use app\src\App;

class RetweetGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $retweet_id;

    /**
     * @return mixed
     */
    public function getRetweetId()
    {
        return $this->retweet_id;
    }

    private $retweet_user_id;

    /**
     * @return mixed
     */
    public function getRetweetUserId()
    {
        return $this->retweet_user_id;
    }

    /**
     * @param mixed $retweet_user_id
     */
    public function setRetweetUserId($retweet_user_id): void
    {
        $this->retweet_user_id = $retweet_user_id;
    }

    /**
     * @return mixed
     */
    public function getRetweetTweetId()
    {
        return $this->retweet_tweet_id;
    }

    /**
     * @param mixed $retweet_tweet_id
     */
    public function setRetweetTweetId($retweet_tweet_id): void
    {
        $this->retweet_tweet_id = $retweet_tweet_id;
    }

    private $retweet_tweet_id;

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    public function insert() : void
    {
        $query = $this->conn->prepare('INSERT INTO retweet (retweet_user_id, retweet_tweet_id) VALUES (:retweet_user_id, :retweet_tweet_id)');
        $executed = $query->execute([
            ':retweet_user_id' => $this->retweet_user_id,
            ':retweet_tweet_id' => $this->retweet_tweet_id
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->retweet_id = $this->conn->lastInsertId();
    }

    public function delete() : void
    {
        if(!$this->getRetweetTweetId() && !$this->getRetweetUserId()) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM retweet WHERE retweet_user_id = :retweet_user_id AND retweet_tweet_id = :retweet_tweet_id');
        $executed = $query->execute([
            ':retweet_user_id' => $this->getRetweetUserId(),
            ':retweet_tweet_id' => $this->getRetweetTweetId()
        ]);

        if(!$executed) throw new \Error('Delete failed');
    }

   /* public function hydrate($element)
    {
        $this->retweet_id = $element['retweet_id'];
        $this->retweet_user_id = $element['retweet_user_id'];
        $this->retweet_tweet_id = $element['retweet_tweet_id'];

    }*/
}