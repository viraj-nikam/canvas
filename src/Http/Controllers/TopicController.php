<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TopicController extends Controller
{
    /**
     * Show a paginated list of topics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'topics' => Topic::orderByDesc('created_at')->withCount('posts')->get(),
        ];

        return view('canvas::topics.index', compact('data'));
    }

    /**
     * Show the form for creating a new topic.
     *
     * @return \Illuminate\View\View
     */
    public function create()
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
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $data = [
            'topic' => Topic::findOrFail($id),
        ];

        return view('canvas::topics.edit', compact('data'));
    }

    /**
     * Store a newly created topic in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id)
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect(route('canvas.topic.index'));
    }
}
