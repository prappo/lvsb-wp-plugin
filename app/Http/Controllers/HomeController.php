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
use App\Models\Tpage;
use App\Models\Tpost;
use App\Models\WpPost;
use App\Models\WpTerm;
use App\Models\WpUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
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


        global $wpdb;
        if(!version_compare(mb_substr($wpdb->get_results( 'SELECT version() as version')[0]->version, 0, 6), '5.7.7') >= 0){
            Schema::defaultStringLength(191);
        }

        if (!Schema::hasTable('test_table')) {
            Schema::create('test_table', function (Blueprint $table) {
                $table->string('id')->unique();
                $table->unsignedInteger('user_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity');
            });
        }



        return "done";

        exit;


    }

    public function index(Request $request)
    {
        return "You said : " . $request->data;
    }

    public function insertPost()
    {
        $last = Tpost::where('id', '1337')->value('last');
        $posts = Tblarticle::take(2000)->where('id', '>', $last)->get();
        $count = $last;

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


                $id = wp_insert_post($my_post);
                wp_set_post_tags($id, self::getTag($post->ARTICLE_ID), true);
                $count++;


            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
        Tpost::where('id', '1337')->update([
            'last' => $count
        ]);

        return response()->json([
            'status' => 'ok'
        ]);


    }

    public function insertCategory()
    {
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

                return response()->json([
                    "status" => "ok"
                ]);
            } catch (\Exception $exception) {

            }


        }


    }

    public function insertPage()
    {

//        $new_post = array(
//            'post_title' => $leadTitle,
//            'post_content' => $leadContent,
//            'post_status' => $postStatus,
//            'post_date' => $timeStamp,
//            'post_author' => $userID,
//            'post_type' => $postType,
//            'post_category' => array($categoryID)
//        );

        $last = Tpage::where('id', '1337')->first()->last;

        $pages = Page::take(100)->where('id', '>', $last)->get();
        $count = $last;
        foreach ($pages as $page) {
            $new_post = array(
                'post_title' => $page->TITRE,
                'post_content' => $page->DESCRIPTION,
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => sanitize_title_with_dashes($page->TITRE, '', 'save') . "_A" . $page->IDPAGE,
                'post_type' => 'page'
            );
            wp_insert_post($new_post);
            $count++;
        }

        $newLast = $last + $count;
        Tpage::where('id', '1337')->update([
            'last' => $count
        ]);

        return response()->json([
            'count' => $newLast
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

        foreach ($data as $d) {
            try {
                $old_data = $d->post_content;
                $new_data = preg_replace_callback('/##(.*?)##/', function ($match) {
                    return strtolower('[object ' . $match[1] . ']');
                }, $old_data);

                WpPost::where('ID', $d->ID)->update([
                    'post_content' => $new_data
                ]);

            } catch (\Exception $exception) {

            }

        }

        return "ok";

    }


    public function migrateRandomObject()
    {
        return "ok";
        // sample data ##RANDOMOBJECT=3023,3023,3181##
        $data = WpPost::take(200)->where('post_content', 'LIKE', '%' . '##RANDOMOBJECT=' . '%')->get();

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

            } catch (\Exception $exception) {

            }

        }

        return "ok";
    }

    public static function getCat($oldCat)
    {
        return Tcat::where('old_id', $oldCat)->value('new_id');
    }

    public static function getTag($oldPostId)
    {
        $tagId = Tblarticle_linktotag::where('ARTICLE_ID', $oldPostId)->value('TAG_ID');
        return Tblarticle_tag::where('TAG_ID', $tagId)->value('TAG_KEYWORD');
    }


}