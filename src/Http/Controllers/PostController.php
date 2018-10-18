<?php

namespace Canvas\Http\Controllers;

use Exception;
use Canvas\Paginate;
use Illuminate\View\View;
use Canvas\Interfaces\TagInterface;
use Canvas\Interfaces\PostInterface;
use Canvas\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    use Paginate;

    /**
     * @var PostInterface
     */
    protected $postInterface;

    /**
     * @var TagInterface
     */
    protected $tagInterface;

    /**
     * PostController constructor.
     *
     * @param PostInterface $postInterface
     * @param TagInterface $tagInterface
     */
    public function __construct(PostInterface $postInterface, TagInterface $tagInterface)
    {
        parent::__construct();
        $this->postInterface = $postInterface;
        $this->tagInterface = $tagInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [
            'posts' => $this->paginate($this->postInterface->getByUserId(auth()->user()->id)->sortByDesc('created_at'), 10),
        ];

        return view('canvas::canvas.posts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $data = [
            'tags' => $this->tagInterface->all(),
        ];

        return view('canvas::canvas.posts.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        try {
            $post = $this->postInterface->create($request->all());
            $post->tags()->sync($request->tags);

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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return View
     */
    public function edit($id): View
    {
        $post = $this->postInterface->find($id);

        $data = [
            'post' => $post,
            'tags' => $post->tags,
        ];

        return view('canvas::canvas.posts.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(PostRequest $request, $id): RedirectResponse
    {
        $post = $this->postInterface->find($id);

        try {
            $post->update($request->all());

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
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $post = $this->postInterface->find($id);

        try {
            $post->delete();

            return redirect(route('canvas.post.index'))
                ->with('success', __('canvas::notifications.success', [
                    'entity' => 'post',
                    'action' => 'deleted',
                ]));
        } catch (Exception $e) {
            return redirect(route('canvas.post.index'))->with('error', __('canvas::notifications.error'));
        }
    }
}
