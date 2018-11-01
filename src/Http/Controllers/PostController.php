<?php

namespace Canvas\Http\Controllers;

use Exception;
use Canvas\Jobs\PostJob;
use Illuminate\View\View;
use Canvas\Traits\Paginate;
use Illuminate\Routing\Controller;
use Canvas\Interfaces\TagInterface;
use Canvas\Interfaces\PostInterface;
use Canvas\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    use Paginate;

    const ITEMS_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @param PostInterface $postRepository Post Repository
     *
     * @return View
     */
    public function index(PostInterface $postRepository): View
    {
        $user = auth()->user();
        $data = [
            'posts' => $this->paginate(
                $postRepository->getByUserId($user->id)->sortByDesc('created_at'),
                self::ITEMS_PER_PAGE
            ),
        ];

        return view('canvas::canvas.posts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param TagInterface $tagRepository tag Repository
     *
     * @return View
     */
    public function create(TagInterface $tagRepository): View
    {
        $data = [
            'tags' => $tagRepository->all(),
        ];

        return view('canvas::canvas.posts.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostJob     $postJob Post Job
     * @param PostRequest $request Post Request
     *
     * @throws Exception
     *
     * @return RedirectResponse
     */
    public function store(PostJob $postJob, PostRequest $request): RedirectResponse
    {
        try {
            $postJob->dispatch($request->all());

            return redirect(route('canvas.post.index'))
                ->with('success', __('canvas::notifications.success', [
                    'entity' => 'post',
                    'action' => 'created',
                ]));
        } catch (Exception $e) {
            return back()->with('error', __('canvas::notifications.error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param PostInterface $postRepository Post Repository
     * @param string        $slug           Slug
     *
     * @return View
     */
    public function show(PostInterface $postRepository, string $slug): View
    {
        $post = $postRepository->findBySlug($slug);
        $data = [
            'post' => $post,
            'user' => $post->user,
        ];

        return view('canvas::blog.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PostInterface $postRepository Post Repository
     * @param int           $id             Post ID
     *
     * @return View
     */
    public function edit(PostInterface $postRepository, int $id): View
    {
        $post = $postRepository->find($id);
        $data = [
            'post' => $post,
            'tags' => $post->tags,
        ];

        return view('canvas::canvas.posts.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostJob       $postJob        post creation job
     * @param PostInterface $postRepository Post Repository
     * @param PostRequest   $request        Post Request
     * @param int           $id             Post ID
     *
     * @return RedirectResponse
     */
    public function update(
        PostJob $postJob,
        PostInterface $postRepository,
        PostRequest $request,
        int $id
    ): RedirectResponse {
        $post = $postRepository->find($id);

        try {
            $postJob->dispatch($request->all(), $post);

            return back()
                ->with('success', __('canvas::notifications.success', [
                    'entity' => 'post',
                    'action' => 'updated',
                ]));
        } catch (Exception $e) {
            return back()->with('error', __('canvas::notifications.error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PostInterface $postRepository Post Repository
     * @param int           $id             Post ID
     *
     * @return RedirectResponse
     */
    public function destroy(PostInterface $postRepository, $id): RedirectResponse
    {
        $post = $postRepository->find($id);

        try {
            $post->delete();

            return redirect(route('canvas.post.index'))
                ->with('success', __('canvas::notifications.success', [
                    'entity' => 'post',
                    'action' => 'deleted',
                ]));
        } catch (Exception $e) {
            return redirect(route('canvas.post.index'))
                ->with('error', __('canvas::notifications.error'));
        }
    }
}
