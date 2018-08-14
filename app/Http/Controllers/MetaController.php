<?php namespace App\Http\Controllers;

use App\Helpers\LumenHelper;
use App\Models\WpPost;

class MetaController extends Controller
{
    private $helper, $post, $request;

    /**
     * Create a new controller instance.
     * @param array $metabox_attributes (injected automatically)
     */
    public function __construct(LumenHelper $helper, WpPost $post)
    {
        $this->helper = $helper;
        $this->request = $this->helper->request();
        $this->post = $post;
    }

    public function template($post, $metabox_attributes)
    {
        $post = $this->post->with('meta')->find($post->ID);
        $content = $post->post_content;
        $start = strpos($content, '<p>');
        $end = strpos($content, '</p>', $start);
        $paragraph = substr($content, $start, $end-$start+4);
        $metaDescription = html_entity_decode(strip_tags($paragraph));
        return $this->helper->view('metaOption', compact('post', 'metabox_attributes','metaDescription'));
    }

    public function save($post, $post_id, $update)
    {
        if ($this->request->filled('lvsb_option') && $this->request->user()->can('update-post', $post)) {

            $this->post = $this->post->with('meta')->find($post_id);

            if ($this->post->meta()->where('meta_key', 'lvsb_option')->exists()) {
                $this->post->meta()->where('meta_key', 'lvsb_option')->update(array(
                    'meta_value' => $this->request->get('lvsb_option')
                ));
            } else {
                $this->post->meta()->create(array(
                    'meta_key' => 'lvsb_option',
                    'meta_value' => $this->request->get('lvsb_option')
                ));
            }


        }

    }

    public function menuMetaBox()
    {

    }
}