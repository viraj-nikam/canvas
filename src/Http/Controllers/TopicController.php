<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

class TopicController extends Controller
{
    /**
     * Show a paginated list of topics.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [
            'topics' => Topic::orderByDesc('created_at')->withCount('posts')->get(),
        ];

        return view('canvas::topics.index', compact('data'));
    }

    /**
     * Show the form for creating a new topic.
     *
     * @return View
     */
    public function create(): View
    {
        $data = [
            'id' => Str::uuid(),
        ];

        return view('canvas::topics.create', compact('data'));
    }

    /**
     * Show the form for editing a topic.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $data = [
            'topic' => Topic::findOrFail($id),
        ];

        return view('canvas::topics.edit', compact('data'));
    }

    /**
     * Store a newly created topic in storage.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $data = [
            'id'   => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ])->validate();

        $topic = new Topic(['id' => request('id')]);
        $topic->fill($data);
        $topic->save();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', 'Saved!');
    }

    /**
     * Update a topic in storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function update(string $id): RedirectResponse
    {
        $topic = Topic::findOrFail($id);

        $data = [
            'id'   => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ])->validate();

        $topic->fill($data);
        $topic->save();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', 'Saved!');
    }

    /**
     * Soft delete a topic in storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect(route('canvas.topic.index'));
    }
}
