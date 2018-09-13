<?php
use App\Models\WpPost;

$router->get('/lol', 'HomeController@index');
$router->post('/insert/post', 'HomeController@insertPost');
$router->post('/insert/category', 'HomeController@insertCategory');

$router->post('/insert/page', 'HomeController@insertPage');
$router->get('/insert/tag', 'HomeController@insertTag');
$router->get('/test', 'HomeController@test');


$router->post('/insert/object', 'HomeController@migrateObjects');
$router->post('/insert/random/object', 'HomeController@migrateRandomObject');
$router->post('/insert/random/object/in/object', 'HomeController@migrateRandomObjectsInObjects');
$router->post('/migrate/objects/to/short/code', 'HomeController@migrateObjectsToShortCode');
$router->get('/lvsb/rest', 'HomeController@reset');
$router->post('/lvsb/fire', 'HomeController@fire');
$router->get('/lvsb/set','HomeController@set');
$router->get('/key-generate', function () {
    return str_random(32);
});
