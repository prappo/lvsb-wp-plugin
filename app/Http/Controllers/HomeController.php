<?php namespace App\Http\Controllers;

use App\Helpers\LumenHelper;
use App\Models\Cat;
use App\Models\Page;
use App\Models\Tblarticle;
use App\Models\Tblarticle_categorie;
use App\Models\Tblarticle_linktocategorie;
use App\Models\Tblarticle_linktotag;
use App\Models\Tblarticle_tag;
use App\Models\Tcat;
use App\Models\Tpage;
use App\Models\Tpost;
use App\Models\WpPost;
use App\Models\WpUser;
use Illuminate\Http\Request;


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
        $new_post = array(
            'post_title' => "My awesome post",
            'post_content' => "Some cool content",
            'post_name' => sanitize_title_with_dashes('My awesome post','','save')."_A123.html",
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
        $id = wp_insert_post($new_post);
        return $id;




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

        $pages = Page::take(2000)->where('id', '>', $last)->get();
        $count = $last;
        foreach ($pages as $page) {
            $new_post = array(
                'post_title' => $page->TITRE,
                'post_content' => $page->DESCRIPTION,
                'post_status' => 'publish',
                'post_author' => 1,
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