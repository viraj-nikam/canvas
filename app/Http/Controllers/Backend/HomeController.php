<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Settings;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the application home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP',
                ],
            ],
        ];

        $context = stream_context_create($opts);
        $stream = file_get_contents('https://api.github.com/repos/austintoddj/canvas/releases/latest', false, $context);
        $release = json_decode($stream);

        $data = [
            'posts' => Post::all(),
            'recentPosts' => Post::orderBy('created_at', 'desc')->take(4)->get(),
            'tags' => Tag::all(),
            'disqus' => Settings::disqus(),
            'analytics' => Settings::gaId(),
            'status' => App::isDownForMaintenance() ? 0 : 1,
            'canvasVersion' => Settings::canvasVersion(),
            'latestRelease' => $release->tag_name,
        ];

        return view('backend.home.index', compact('data'));
    }
}
