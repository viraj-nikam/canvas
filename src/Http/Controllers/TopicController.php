<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TopicController extends Controller
{
    /**
     * Show the topics index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Grab all of the topics
        $topics = Topic::orderByDesc('created_at')
            ->withCount('posts')
            ->get();

        return view('canvas::topics.index', compact('topics'));
    }

    /**
     * Show the page to create a new topic.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Generate a new topic ID
        $topic_id = Str::uuid();

        return view('canvas::topics.create', compact('topic_id'));
    }

    /**
     * Show the page to edit a given topic.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Lookup a topic given an ID
        $topic = Topic::findOrFail($id);

        return view('canvas::topics.edit', compact('topic'));
    }

    /**
     * Save a new topic.
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

        $messages = [
            'required' => __('canvas::validation.required'),
            'unique'   => __('canvas::validation.unique'),
        ];

        // Validate the request
        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        // Save a new topic
        $topic = new Topic(['id' => request('id')]);
        $topic->fill($data);
        $topic->save();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Save a given topic.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id)
    {
        // Lookup a topic given an ID
        $topic = Topic::findOrFail($id);

        $data = [
            'id'   => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
        ];

        $messages = [
            'required' => __('canvas::validation.required'),
            'unique'   => __('canvas::validation.unique'),
        ];

        // Validate the request
        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        // Update the topic
        $topic->fill($data);
        $topic->save();

        return redirect(route('canvas.topic.edit', $topic->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Delete a given topic.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Lookup a topic given an ID
        $topic = Topic::findOrFail($id);

        // Delete the topic
        $topic->delete();

        return redirect(route('canvas.topic.index'));
    }
}
