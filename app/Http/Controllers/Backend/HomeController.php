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
        $api = file_get_contents('https://packagist.org/p/austintoddj/canvas.json');
        $stream = json_decode($api, true);
        $packages = end($stream);
        $project = end($packages);
        $release = end($project);

        $data = [
            'posts' => Post::all(),
            'recentPosts' => Post::orderBy('created_at', 'desc')->take(4)->get(),
            'tags' => Tag::all(),
            'disqus' => Settings::disqus(),
            'analytics' => Settings::gaId(),
            'status' => App::isDownForMaintenance() ? 0 : 1,
            'canvasVersion' => Settings::canvasVersion(),
            'latestRelease' => $release['version'],
        ];

        return view('backend.home.index', compact('data'));
    }
}
