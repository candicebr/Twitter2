<?php
namespace App;

use App\Src\App;
use App\Src\ServiceContainer\ServiceContainer;
use Database\Database;
use App\Src\Response\Response;
use Model\Finder\FollowFinder;
use Model\Finder\UserFinder;
use Model\Finder\TweetFinder;
use Model\Finder\LikesFinder;
use Model\Finder\RetweetFinder;


$container = new ServiceContainer();

$app = new App($container);


$app->setService('Database', new Database(
    "127.0.0.1",
    "bdd_twitter",
    "root",
    "",
    "3306"
));

$app->setService('UserFinder', new UserFinder($app));
$app->setService('TweetFinder', new TweetFinder($app));
$app->setService('FollowFinder', new FollowFinder($app));
$app->setService('LikesFinder', new LikesFinder($app));
$app->setService('RetweetFinder', new RetweetFinder($app));

$app->setService('render', function (String $template, Array $params = []) {
    ob_start();
    include __DIR__ . '/../View/' . $template . '.php';
    $content = ob_get_contents();
    ob_end_clean(); //Does not send the content of the buffer to the user
    if ($template === '404') {
        $response = new Response($content, 404, ["HTTP/1.0 404 Not Found"]);
        return $response;
    }

    return $content;
});

$routing = new Routing($app);
$routing->setup();


return $app;