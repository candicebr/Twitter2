<?php


namespace model\gateway;
use app\src\App;

class LikesGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $likes_id;

    /**
     * @return mixed
     */
    public function getLikesId()
    {
        return $this->likes_id;
    }

    private $likes_user_id;

    /**
     * @return mixed
     */
    public function getLikesUserId()
    {
        return $this->likes_user_id;
    }

    /**
     * @param mixed $likes_user_id
     */
    public function setLikesUserId($likes_user_id): void
    {
        $this->likes_user_id = $likes_user_id;
    }

    /**
     * @return mixed
     */
    public function getLikesTweetId()
    {
        return $this->likes_tweet_id;
    }

    /**
     * @param mixed $likes_tweet_id
     */
    public function setLikesTweetId($likes_tweet_id): void
    {
        $this->likes_tweet_id = $likes_tweet_id;
    }

    private $likes_tweet_id;

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    public function insert() : void
    {
        $query = $this->conn->prepare('INSERT INTO likes (likes_user_id, likes_tweet_id) VALUES (:likes_user_id, :likes_tweet_id)');
        $executed = $query->execute([
            ':likes_user_id' => $this->likes_user_id,
            ':likes_tweet_id' => $this->likes_tweet_id
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->likes_id = $this->conn->lastInsertId();
    }

    public function delete() : void
    {
        if(!$this->getLikesUserId() && !$this->getLikesTweetId()) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM likes WHERE likes_user_id = :likes_user_id AND likes_tweet_id = :likes_tweet_id');
        $executed = $query->execute([
            ':likes_user_id' => $this->getLikesUserId(),
            ':likes_tweet_id' => $this->getLikesTweetId()
        ]);

        if(!$executed) throw new \Error('Delete failed');
    }

}