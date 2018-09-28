<?php namespace App\Http\Controllers;

use App\Helpers\LumenHelper;
use App\Models\Cat;
use App\Models\Page;
use App\Models\Tblarticle;
use App\Models\Tblarticle_categorie;
use App\Models\Tblarticle_linktocategorie;
use App\Models\Tblarticle_linktotag;
use App\Models\Tblarticle_tag;
use App\Models\Tblobject;
use App\Models\Tcat;
use App\Models\Tobject;
use App\Models\Tpage;
use App\Models\Tpost;
use App\Models\WpPost;
use App\Models\WpTerm;
use App\Models\WpUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\CountValidator\Exception;


require_once('wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');

class HomeController extends Controller
{

    public function dashboard()
    {
        return view('welcome-panel');
    }

    public function test()
    {

//        $str = "This is some text
//<p>##IDOBJECT=784##</p> and another some text
//<p>##IDOBJECT=1509##</p>
//<p>##LATESTARTICLESHOME=321##</p>
//<p align=\"center\">##IDOBJECT=321##</p>";
//        echo preg_replace_callback('/##(.*?)##/', function ($match) {
//            return strtolower('[object ' . $match[1] . ']');
//        }, $str);

//        $data = WpPost::take(10)->where('post_content', 'LIKE', '%' . '##' . '%')->get();
//        $success = 0;
//        $error = 0;
//        foreach ($data as $d) {
//            try {
//                $old_data = $d->post_content;
//                $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
//                    return strtolower('[object ' . $match[1] . ']');
//                }, $old_data);
//
//                WpPost::where('ID', $d->ID)->update([
//                    'post_content' => $new_data
//                ]);
//
//
//                $success++;
//            } catch (\Exception $exception) {
//                $error++;
//            }
//            echo "[" . $d->ID . "]" . " " . $d->post_content . "<br>";
//            echo "========================== <br>";
//
//        }

//        try {
//            $old_content = WpPost::where('ID', 144)->value('post_content');
//            $new_content = preg_replace_callback('/##(.*?)##/', function ($match) {
//                return strtolower('[object ' . $match[1] . ']');
//            }, $old_content);
//
//            echo $old_content . "<br>======================<be>" . $new_content;
//            WpPost::where('ID', 144)->update([
//                'post_content' => $new_content
//            ]);
//            $latest_content = WpPost::where('ID', 144)->value('post_content');
//            echo "<br>==========================<br>";
//            echo "<div style='color:green'>{$latest_content}</div>";
//
//        } catch (\Exception $exception) {
//            return $exception->getMessage();
//        }

        //##RANDOMOBJECT=3023,3023,3181##

//        $content = "RANDOMOBJECT=3023,3023,3181";
//        $data = str_replace("RANDOMOBJECT=", "", $content);
//        $results = explode(",", $data);
//
//        foreach ($results as $result => $object) {
//            echo "[object idobject=" . $object . "]";
//        }

//        print_r($results);


//        global $wpdb;
//        if (!version_compare(mb_substr($wpdb->get_results('SELECT version() as version')[0]->version, 0, 6), '5.7.7') >= 0) {
//            Schema::defaultStringLength(191);
//        }
//
//        if (!Schema::hasTable('test_table')) {
//            Schema::create('test_table', function (Blueprint $table) {
//                $table->string('id')->unique();
//                $table->unsignedInteger('user_id')->nullable();
//                $table->string('ip_address', 45)->nullable();
//                $table->text('user_agent')->nullable();
//                $table->text('payload');
//                $table->integer('last_activity');
//            });
//        }
//
//
//        return "done";

//        $categories = Tblarticle_categorie::all();
//        foreach ($categories as $category) {
//            try {
//                $cat_defaults = array(
//
//                    'cat_name' => $category->CATEGORY_TITLE,
//                    'category_description' => $category->CATEGORY_TITLEEN,
//                    'category_nicename' => '',
//                    'category_parent' => '',
//                    'taxonomy' => 'category'
//                );
//                $newId = wp_insert_category($cat_defaults);
//                $oldId = $category->CATEGORY_ID;
//
//                $cat = new Tcat();
//                $cat->new_id = $newId;
//                $cat->old_id = $oldId;
//                $cat->save();
//
//                return response()->json([
//                    "status" => "ok"
//                ]);
//
//            } catch (\Exception $exception) {
//                echo $exception->getMessage();
//            }
//
//
//        }


//        $data = Tblobject::take(100)->where('DESCRIPTION', 'LIKE', '%' . '##RANDOMOBJECT=' . '%')->get();
//
//        foreach ($data as $d) {
//            try {
//                $old_data = $d->DESCRIPTION;
//                $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
//                    $content = $match[1];
//                    $data = str_replace("RANDOMOBJECT=", "", $content);
//                    $results = explode(",", $data);
//                    $object = "";
//                    foreach ($results as $result => $data) {
//                        $object .= strtolower('[object idobject=' . $data . ']');
//                    }
//                    return $object;
//                }, $old_data);
//
//                DB::table('tblobjects')->where('IDOBJECT', $d->IDOBJECT)->update([
//                    'DESCRIPTION' => $new_data
//                ]);
//
//            } catch (\Exception $exception) {
//                echo $exception->getMessage();
//            }
//
//        }
//
//        return "ok";

        //2488

//        $tags = get_the_tags(2488);
//        $myPost = get_post_meta(2488, 'lvsb_option');
//        print_r($myPost[0]);

        try {
            Tcat::truncate();
            echo "Tcat table truncated <br>";
//            Tobject::where('id', '1337')->update([
//                'last' => 0
//            ]);
            echo "Tobject table reset done <br>";
            Tpage::where('id', 1337)->update([
                'last' => 0
            ]);
            echo "Tpage table reset done <br>";
            Tpost::where('id', '1337')->update([
                'last' => 0
            ]);
            echo "Tpost table rest done<br>";

            WpPost::truncate();
            echo "All Wp Post removed";

            return "Operation done";


        } catch (\Exception $exception) {
            return $exception->getMessage();
        }


        exit;


    }

    public function index(Request $request)
    {
        Tblarticle::take(700)->delete();
        exit;
    }

    public function insertPost()
    {
        $limit = 1000;
        if (Tblarticle::all()->count() == 0) {
            return "done";
        }


        $posts = Tblarticle::take($limit)->get();

        $c = 0;

        foreach ($posts as $post) {

            try {
                // Create post object
                $oldCatId = Tblarticle_linktocategorie::where('ARTICLE_ID', $post->ARTICLE_ID)->value('CATEGORY_ID');
                $catId = self::getCat($oldCatId);

                if ($catId == "") {
                    $catId = 1;
                }

                $my_post = array(
                    'post_title' => $post->ARTICLE_TITLE,
                    'post_content' => $post->ARTICLE_CONTENT,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => sanitize_title_with_dashes($post->ARTICLE_TITLE, '', 'save') . "_A" . $post->ARTICLE_ID,
                    'post_category' => array($catId)
                );


                $id = wp_insert_post($my_post); // wp post id

                foreach (Tblarticle_linktotag::where('ARTICLE_ID', $post->ARTICLE_ID)->get() as $tag) {
                    wp_set_post_tags($id, self::getTag($tag->CATEGORY_ID), true);
                }


                $c++;


            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }

        Tblarticle::take($limit)->delete();


        return response()->json([
            'status' => 'ok',
            'count' => $c
        ]);


    }

    public static function getTag($tagId)
    {

        return Tblarticle_tag::where('TAG_ID', $tagId)->value('TAG_KEYWORD');
    }

    public function set()
    {

        update_option('lvsb_pages', 0);
        echo "Lvsb pages : " . get_option('lvsb_pages') . "<br>";
        update_option('lvsb_posts', 0);
        echo "Lvsb posts : " . get_option('lvsb_posts') . "<br>";
        update_option('lvsb_categories', 0);
        echo "Lvsb pages : " . get_option('lvsb_categories') . "<br>";
        update_option('lvsb_objects', 0);
        echo "Lvsb objects : " . get_option('lvsb_objects') . "<br>";
        update_option('lvsb_set', 'yes');

        update_option('lvsb_randomObjects', 0);
        echo "Lvsb Random objects " . get_option('lvsb_randomObjects') . "<br>";

        update_option('lvsb_randomObjectsInObjects', 0);
        echo "Lvsb random objects in objects " . get_option('lvsb_randomObjectsInObjects') . "<br>";

        update_option('lvsb_objectToContent', 0);
        echo "Lvsb convert objects to content " . get_option('lvsb_objectToContent');


        exit;
    }

    public function insertCategory()
    {
        $count = 0;
        $categories = Tblarticle_categorie::all();
        foreach ($categories as $category) {
            try {
                $cat_defaults = array(

                    'cat_name' => $category->CATEGORY_TITLE,
                    'category_description' => $category->CATEGORY_TITLEEN,
                    'category_nicename' => '',
                    'category_parent' => '',
                    'taxonomy' => 'category'
                );
                $newId = wp_insert_category($cat_defaults);
                $oldId = $category->CATEGORY_ID;

                $cat = new Tcat();
                $cat->new_id = $newId;
                $cat->old_id = $oldId;
                $cat->save();
                $count++;


            } catch (\Exception $exception) {

            }


        }

        $updateCatCount = get_option('lvsb_categories') + $count;

        update_option('lvsb_categories', $updateCatCount);


        return response()->json([
            "status" => "ok"
        ]);


    }

    public function insertPage()
    {
        $limit = 1000;

        if (Page::all()->count() == 0) {
            return "done";
        }
        $pages = Page::take($limit)->get();
        $totalMigrated = 0;
        foreach ($pages as $page) {

            $new_post = array(
                'post_title' => $page->TITRE,
                'post_content' => $page->DESCRIPTION,
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => sanitize_title_with_dashes($page->TITRE, '', 'save') . "_P" . $page->IDPAGE,
                'post_type' => 'page'
            );
            wp_insert_post($new_post);
            $totalMigrated++;


        }

        Page::take($limit)->delete();

        return response()->json([
            'count' => $totalMigrated,
            'status' => 'success'
        ]);


    }

    public function insertTag()
    {
        $parent_term = term_exists('fruits', 'product'); // array is returned if taxonomy is given
        $parent_term_id = $parent_term['term_id'];         // get numeric term id
        $id = wp_insert_term(
            'Apple',   // the term
            'category', // the taxonomy
            array(
                'description' => 'A yummy apple.',
                'slug' => 'apple',
                'parent' => $parent_term_id,
            )
        );
        print_r($id);
    }

    public function migrateObjects(Request $request)
    {

        $data = WpPost::take(200)->where('post_content', 'LIKE', '%' . '##IDOBJECT=' . '%')->get();

        $count = 0;

        foreach ($data as $d) {
            try {
                $old_data = $d->post_content;
                $new_data = preg_replace_callback('/##IDOBJECT(.*?)##/', function ($match) {
                    return strtolower('[object idobject' . $match[1] . ']');
                }, $old_data);

                WpPost::where('ID', $d->ID)->update([
                    'post_content' => $new_data
                ]);
                $count++;

            } catch (\Exception $exception) {

            }

        }

        $newCount = get_option('lvsb_objects');
        update_option('lvsb_objects', $newCount);

        return "ok";

    }


    public function migrateRandomObject()
    {
//         sample data ##RANDOMOBJECT=3023,3023,3181##
        $data = WpPost::take(200)->where('post_content', 'LIKE', '%' . '##RANDOMOBJECT=' . '%')->get();
        $count = 0;
        foreach ($data as $d) {
            try {
                $old_data = $d->post_content;
                $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
                    $content = $match[1];
                    $data = str_replace("RANDOMOBJECT=", "", $content);
                    $results = explode(",", $data);
                    $object = "";
                    foreach ($results as $result => $data) {
                        $object .= strtolower('[object idobject=' . $data . ']');
                    }
                    return $object;
                }, $old_data);

                WpPost::where('ID', $d->ID)->update([
                    'post_content' => $new_data
                ]);

                $count++;

            } catch (\Exception $exception) {

            }


        }

        $newCount = get_option('lvsb_randomObjects') + $count;
        update_option('lvsb_randomObjects', $newCount);

        return "ok";
    }


    public function migrateRandomObjectsInObjects()
    {
        $count = 0;
        $data = Tblobject::take(200)->where('DESCRIPTION', 'LIKE', '%' . '##RANDOMOBJECT=' . '%')->get();
        try {
            foreach ($data as $d) {

                $old_data = $d->DESCRIPTION;
                $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
                    $content = $match[1];
                    $data = str_replace("RANDOMOBJECT=", "", $content);
                    $results = explode(",", $data);
                    $object = "";
                    foreach ($results as $result => $data) {
                        $object .= Tblobject::where('IDOBJECT', $data)->value('DESCRIPTION') . "<br>";
                    }
                    return $object;
                }, $old_data);

                DB::table('tblobjects')->where('IDOBJECT', $d->IDOBJECT)->update([
                    'DESCRIPTION' => $new_data
                ]);
                $count++;

            }
            $newCount = get_option('lvsb_randomObjectsInObjects') + $count;
            update_option(lvsb_randomObjectsInObjects, $newCount);
            return "ok";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }


    }


    public function migrateObjectsToShortCode()
    {
        $data = Tblobject::take(200)->where('DESCRIPTION', 'LIKE', '%' . '##IDOBJECT=' . '%')->get();
        $count = 0;
        foreach ($data as $d) {
            $old_data = $d->DESCRIPTION;
            $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
                $content = $match[1];
                $data = str_replace("IDOBJECT=", "", $content);
                $results = explode(",", $data);
                $object = "";
                foreach ($results as $result => $data) {
                    $object .= Tblobject::where('IDOBJECT', $data)->value('DESCRIPTION') . "<br>";
                }
                return $object;
            }, $old_data);

            DB::table('tblobjects')->where('IDOBJECT', $d->IDOBJECT)->update([
                'DESCRIPTION' => $new_data
            ]);

            $count++;

        }

        $newCount = get_option('lvsb_objectToContent') + $count;
        update_option('lvsb_objectToContent', $newCount);

        return "ok";
    }


    public static function getCat($oldCat)
    {
        return Tcat::where('old_id', $oldCat)->value('new_id');
    }


    public function reset()
    {
        try {
            Tcat::truncate();
            echo "Tcat table truncated <br>";
            Tobject::where('id', '1337')->update([
                'last' => 0
            ]);
            echo "Tobject table reset done <br>";
            Tpage::where('id', 1337)->update([
                'last' => 0
            ]);
            echo "Tpage table reset done <br>";
            Tpost::where('id', '1337')->update([
                'last' => 0
            ]);
            echo "Tpost table rest done<br>";

            WpPost::truncate();
            echo "All Wp Post removed";

            return "Operation done";


        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function fire()
    {
        if (get_option('lvsb_status')) {
            if (get_option('lvsb_status') == "running") {
                update_option('lvsb_status', 'stop');
                return "success";
            } else {
                update_option('lvsb_status', 'running');
                return "success";
            }
        } else {
            update_option('lvsb_status', 'running');
            return "success";
        }
    }


}