<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Http\Requests;
use App\Services\RssFeed;
use App\Jobs\BlogIndexData;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $data = $this->dispatch(new BlogIndexData($tag));
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        return view($layout, $data);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag = $request->get('tag');
        $title = $post->title;
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }
        return view($post->layout, compact('post', 'tag', 'slug', 'title'));
    }

    /**
     * Return the rss feed.
     *
     * @return \Illuminate\Http\Response
     */
    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();
        return response($rss)->header('Content-type', 'application/rss+xml');
    }
}
