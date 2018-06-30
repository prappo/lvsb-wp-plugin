<?php
/**
 *
 * Plugin Name:       Lvsb
 * Plugin URI:        http://prappo.github.io
 * Description:       Made for data migration
 * Version:           1.0
 * Author:            Prappo Prince
 * Author URI:        http://prappo.github.io
 * License:           © Copyright 2017 All Rights Reserved.
 * License URI:       http://www.site.com/terms
 */

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
*/

$app = require __DIR__.'/bootstrap/app.php';
error_reporting((env('APP_DEBUG') ? E_ALL : 0));
//dd(\App\Helpers\LumenHelper::plugin('App')->config());