<?php


namespace model\gateway;

use app\src\App;

class FollowGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $follow_id;

    /**
     * @return mixed
     */
    public function getFollowId()
    {
        return $this->follow_id;
    }

    private $user_followed_id;

    private $user_follower_id;

    /**
     * @return mixed
     */
    public function getUserFollowedId()
    {
        return $this->user_followed_id;
    }

    /**
     * @param mixed $user_followed_id
     */
    public function setUserFollowedId($user_followed_id): void
    {
        $this->user_followed_id = $user_followed_id;
    }

    /**
     * @return mixed
     */
    public function getUserFollowerId()
    {
        return $this->user_follower_id;
    }

    /**
     * @param mixed $user_follower_id
     */
    public function setUserFollowerId($user_follower_id): void
    {
        $this->user_follower_id = $user_follower_id;
    }

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    public function insert() : void
    {
        $query = $this->conn->prepare('INSERT INTO follow (user_followed_id, user_follower_id) VALUES (:user_followed_id, :user_follower_id)');
        $executed = $query->execute([
            ':user_followed_id' => $this->user_followed_id,
            ':user_follower_id' => $this->user_follower_id
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->follow_id = $this->conn->lastInsertId();
    }

    public function delete() : void
    {
        if(!$this->getUserFollowedId() && !$this->getUserFollowerId()) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM follow WHERE user_followed_id = :user_followed_id AND user_follower_id = :user_follower_id');
        $executed = $query->execute([
            ':user_followed_id' => $this->getUserFollowedId(),
            ':user_follower_id' => $this->getUserFollowerId()
        ]);

        if(!$executed) throw new \Error('Delete failed');
    }
}