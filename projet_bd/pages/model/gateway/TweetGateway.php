<?php


namespace model\gateway;
use app\src\App;

class TweetGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $tweet_id;

    /**
     * @return mixed
     */
    public function getTweetId()
    {
        return $this->tweet_id;
    }

    private $tweet_content;

    private $tweet_date;

    private $tweet_user_id;

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    /**
     * @return mixed
     */
    public function getTweetContent()
    {
        return $this->tweet_content;
    }

    /**
     * @param mixed $tweet_content
     */
    public function setTweetContent($tweet_content): void
    {
        $this->tweet_content = $tweet_content;
    }

    /**
     * @return mixed
     */
    public function getTweetDate()
    {
        return $this->tweet_date;
    }

    /**
     * @param mixed $tweet_date
     */
    public function setTweetDate($tweet_date): void
    {
        $this->tweet_date = $tweet_date;
    }

    /**
     * @return mixed
     */
    public function getTweetUserId()
    {
        return $this->tweet_user_id;
    }

    /**
     * @param mixed $tweet_user_id
     */
    public function setTweetUserId($tweet_user_id): void
    {
        $this->tweet_user_id = $tweet_user_id;
    }



    public function insert() : void
    {
        $query = $this->conn->prepare('INSERT INTO tweet (tweet_content, tweet_date, tweet_user_id) VALUES (:tweet_content, now(), :tweet_user_id)');
        $executed = $query->execute([
            ':tweet_content' => $this->tweet_content,
            //':tweet_date' => $this->now(),
            ':tweet_user_id' => $this->tweet_user_id,
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->tweet_id = $this->conn->lastInsertId();
    }

    public function hydrate($element)
    {
        $this->tweet_id = $element['tweet_id'];
        $this->tweet_content = $element['tweet_content'];
        $this->tweet_date = $element['tweet_date'];
        $this->tweet_user_id = $element['tweet_user_id'];

    }

    public function nbTweet($id) : int{
        $query = $this->conn->prepare('SELECT COUNT(*) FROM tweet.COLUMNS WHERE t.id = :id');
        $query->execute([':id' => $id]);
        $element = $query->fetch(\PDO::FETCH_ASSOC);
        return $element;
    }

    public function delete($tweet_id) : void
    {
        if(!$tweet_id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM tweet WHERE tweet_id = :tweet_id');
        $executed = $query->execute([
            ':tweet_id' => $tweet_id
        ]);

        if(!$executed) throw new \Error('Delete failed');
    }


}