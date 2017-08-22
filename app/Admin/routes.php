<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/game/users', UserController::class);
    $router->resource('/game/question/questions', QuestionController::class);
    $router->resource('/game/question/tests', TestController::class);
    $router->resource('/game/question/answers', AnswerController::class);
    $router->resource('/game/circle/activities', ActivityController::class);
    $router->resource('/game/circle/awards', AwardController::class);
    $router->resource('/game/circle/awards', AwardController::class);
    $router->resource('/game/circle/lotteries', LotteryController::class);
    $router->resource('/game/circle/converts', ConvertController::class);
});
