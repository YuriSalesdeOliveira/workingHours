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

$router->get('/relatorio', 'Web:report', 'web.report');
$router->post('/relatorio', 'Web:report', 'web.report');

$router->get('/relatorio-gerencial', 'Web:managerReport', 'web.managerReport');
$router->post('/relatorio-gerencial', 'Web:managerReport', 'web.managerReport');

$router->get('/login', 'Web:login', 'web.login');

$router->get('/perfil', 'Web:profile', 'web.profile');
$router->get('/usuarios/registrar', 'Web:register', 'web.register');
$router->get('/usuarios/editar/{user}', 'Web:update', 'web.update');
$router->get('/usuarios/mudar-senha/{user}', 'Web:changePassword', 'web.changePassword');

/*
 * APP
 */

$router->group(null);
$router->get('/to-clock-in', 'App:toClockIn', 'app.toClockIn');
$router->post('/to-clock-in', 'App:toClockIn', 'app.toClockIn');

$router->get('/logout', 'App:logout', 'app.logout');

/*
 * AUTH
 */

$router->group(null);
$router->post('/login', 'Auth:login', 'auth.login');

$router->post('/usuarios/registrar', 'Auth:register', 'auth.register');
$router->post('/usuarios/editar', 'Auth:update', 'auth.update');
$router->post('/usuarios/mudar-senha/{user}', 'Auth:changePassword', 'auth.changePassword');
$router->get('/usuarios/alternar-admin/{user}', 'Auth:toggleAdmin', 'auth.toggleAdmin');
$router->get('/usuarios/alternar-ativado/{user}', 'Auth:toggleActive', 'auth.toggleActive');

/*
 * ERROR
 */

$router->group(null);
$router->get('/erro/{errcode}', 'Web:error', 'web.error');

$router->dispatch();

if ($router->error()) {

    $router->redirect("web.error", ['errcode' => $router->error()]);
}
