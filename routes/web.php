<?php
use App\Models\WpPost;

$router->post('/lol', 'HomeController@index');
$router->post('/insert/post', 'HomeController@insertPost');
$router->post('/insert/category', 'HomeController@insertCategory');

$router->post('/insert/page', 'HomeController@insertPage');
$router->get('/insert/tag', 'HomeController@insertTag');
$router->get('/test', 'HomeController@test');
$router->post('/insert/object', 'HomeController@migrateObjects');
$router->get('/key-generate', function () {
    return str_random(32);
});
