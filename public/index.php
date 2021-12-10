<?php

session_start();

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(SITE['root']);

$router->namespace('Source\Controller');

/*
 * WEB
 */

$router->group(null);
$router->get('/', 'Web:home', 'web.home');
$router->get('/home', 'Web:home', 'web.home');
$router->get('/usuarios', 'Web:users', 'web.users');

$router->get('/relatorio', 'Web:report', 'web.report');
$router->get('/relatorio/{date}', 'Web:report', 'web.report.date');
$router->get('/relatorio/{user}', 'Web:report', 'web.report.user');
$router->get('/relatorio/{user}/{date}', 'Web:report', 'web.report.user.date');

$router->get('/login', 'Web:login', 'web.login');
$router->get('/registrar', 'Web:register', 'web.register');

/*
 * APP
 */

$router->group(null);
$router->get('/toclockin', 'App:toClockIn', 'app.toClockIn');
$router->post('/toclockin', 'App:toClockIn', 'app.toClockIn');
$router->get('/logout', 'App:logout', 'app.logout');

/*
 * AUTH
 */

$router->group(null);
$router->post('/login', 'Auth:login', 'auth.login');
$router->post('/registrar', 'Auth:register', 'auth.register');

/*
 * ERROR
 */

$router->group(null);
$router->get('/erro/{errcode}', 'Web:error', 'web.error');

$router->dispatch();

if ($router->error()) {

    $router->redirect("web.error", ['errcode' => $router->error()]);
}