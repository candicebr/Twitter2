<?php


namespace Model\Finder;


use App\Src\App;
use Model\Gateway\RetweetGateway;

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
        $this->conn = $this->app->getService('Database')->getConnection();
    }

    /**
     * @param $id
     * @return mixed : si déjà retweeté
     * @return null : si jamais retweeté
     */
    //vérifie si le tweet est déjà aimé ou non
    public function findRetweetById($id)
    {
        $query = $this->conn->prepare('SELECT r.retweet_tweet_id FROM retweet r WHERE r.retweet_tweet_id = :retweet_tweet_id');
        $query->execute([':retweet_tweet_id' => $id] ); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element == 0) return null;

        return $element;
    }

}