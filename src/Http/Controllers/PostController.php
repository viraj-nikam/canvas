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
            $this->postInterface->create($request->all());

            return redirect(route('canvas.posts.index'))->with('success', 'Post has been created');
        } catch (Exception $e) {
            return back()->with('error', 'Post has not been created');
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
        $data = [
            'post' => $this->postInterface->find($id),
            'tags' => $this->tagInterface->all(),
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

            return back()->with('success', 'Post has been updated');
        } catch (Exception $e) {
            return back()->with('error', 'Post has not been updated');
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

            return redirect(route('canvas.posts.index'))->with('success', 'Post has been deleted');
        } catch (Exception $e) {
            return redirect(route('canvas.posts.index'))->with('error', 'Post has not been deleted');
        }
    }
}
