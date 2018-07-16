<?php

/*
|--------------------------------------------------------------------------
| Bootstrap WP for Artisan
|--------------------------------------------------------------------------
*/

$wpLoad = realpath(__DIR__ . "/../../../../wp-load.php");
if (!class_exists('Laravel\Lumen\Application') && is_file($wpLoad)) {
    require_once($wpLoad);
} else {
    exit('Wp-Lumen: wp-load.php not found.  Check path in bootstrap/app.php (line: 11)');
}

/*
|--------------------------------------------------------------------------
| Require The Composer AutoLoader
|--------------------------------------------------------------------------
| Loaded in mu-plugins or, include here.
*/
require_once __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load Env with Overload Enabled (last plugin loaded will overwrite)
|--------------------------------------------------------------------------
*/
try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->overload();
} catch (Dotenv\Exception\InvalidPathException $e) {
    exit('Wp-Lumen: No Environment Settings (.env) Found.');
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
*/
$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);
$app->withEloquent();

//Facades will not work with multiple WP-Lumen Plugins Running, use the Helper instead.
$app->withFacades(true);

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/
//$app->middleware([]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'start_session' => \Illuminate\Session\Middleware\StartSession::class,
    'share_errors' => \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    'no404s' => App\Http\Middleware\SilenceWp404s::class
]);
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\UtilityServiceProvider::class);


if (!$app->runningInConsole()) {
    if ($app->make('config')->get('session.enabled')) {
        $app->bind(\Illuminate\Session\SessionManager::class, function ($app) {
            return new \Illuminate\Session\SessionManager($app);
        });
        $app->register(\Illuminate\Session\SessionServiceProvider::class);
        $app->middleware([\Illuminate\Session\Middleware\StartSession::class]);
    }


    $app->register(App\Providers\WordpressServiceProvider::class);
    $app->register(App\Providers\DebugbarServiceProvider::class);

    /*
    |--------------------------------------------------------------------------
    | Include WP CleanUp Mods
    |--------------------------------------------------------------------------
    | Here we will register all of the application's WP modifications.
    */
    //$files = $app->make('files');
    //$files->requireOnce(realpath(__DIR__.'/../cleanup/head.php'));
    //$files->requireOnce(realpath(__DIR__.'/../cleanup/rest-api.php'));
    //$files->requireOnce(realpath(__DIR__.'/../cleanup/emojis.php'));
}


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
*/
if (!$app->runningInConsole()) {
    add_action('init', function () use ($app) {
        $request = Illuminate\Http\Request::capture();
        if (!is_admin()) {

            //Boot Router for Front-end Requests
            $app->router->group([
                'namespace' => 'App\Http\Controllers',
            ], function ($router) {
                require __DIR__ . '/../routes/web.php';
            });

            //Handle Request
            $response = $app->handle($request);

            //Send Response by Overwriting WP (eager)
            if ($app->make('config')->get('router.loading') == 'eager') {

                if ($response->content()) {
                    $response->send();
                    exit($response->status());
                }

                //Send Response on 404 (lazy)
            } elseif (is_404()) {

                //Send Response During Template Redirect
                add_action('template_redirect', function () use ($app, $request, $response) {
                    if ($response->content()) {
                        $response->send();
                        exit($response->status());
                    }
                }, 1);
            }
        } else {
            //Handle Request
            $app->handle($request);
        }
    });


//	custom url

    add_action('init', 'witsolution_page_permalink', -1);
    register_activation_hook(__FILE__, 'witsolution_active');
    register_deactivation_hook(__FILE__, 'witsolution_deactive');


    function witsolution_page_permalink()
    {
        global $wp_rewrite;
        if (!strpos($wp_rewrite->get_page_permastruct(), '.html')) {
            $wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
        }
    }

    add_filter('user_trailingslashit', 'witsolution_page_slash', 66, 2);
    function witsolution_page_slash($string, $type)
    {
        global $wp_rewrite;
        if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes == true && $type == 'page') {
            return untrailingslashit($string);
        } else {
            return $string;
        }
    }

    function witsolution_active()
    {
        global $wp_rewrite;
        if (!strpos($wp_rewrite->get_page_permastruct(), '.html')) {
            $wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
        }
        $wp_rewrite->flush_rules();
    }

    function witsolution_deactive()
    {
        global $wp_rewrite;
        $wp_rewrite->page_structure = str_replace(".html", "", $wp_rewrite->page_structure);
        $wp_rewrite->flush_rules();
    }

    // meta data

    function header_metadata()
    {

        // Post object if needed
        // global $post;

        // Page conditional if needed
        // if( is_page() ){}

        $title = get_the_title(get_the_ID());
        $myPageDescription = \App\Models\Page::where('TITRE', $title)->value('myPageDescription');
        $myPageKeywords = \App\Models\Page::where('TITRE', $title)->value('myPageKeywords');


        echo '<meta name="Description" content="' . $myPageDescription . ' " />';
        echo '<meta name="Keywords" content="' . $myPageKeywords . '" />';


    }

    add_action('wp_head', 'header_metadata');

    // short code

//    function test_short_code($attr)
//    {
//        $a = shortcode_atts(array(
//            'idobject' => null,
//            'email' => null,
//        ), $attr);
//
////        return "Your name " . $a['name'] . " and mail is " . $a['email'];
//        return \App\Models\Tblobject::where('IDOBJECT', $a['idobject'])->value('DESCRIPTION');
//    }

    function object_shortCode($attr)
    {
        $a = shortcode_atts(array(
            'idobject' => 73,
            'URL' => null
        ), $attr);
        $objectId = esc_attr($a['idobject']);

        return \App\Models\Tblobject::where('IDOBJECT', $objectId)->value('DESCRIPTION');


    }



//    add_shortcode('test', 'test_short_code');
    add_shortcode('object', 'object_shortCode');
}
return $app;