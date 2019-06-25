<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderByDesc('created_at')
            ->withCount('posts')
            ->get();

        return response()->json([$topics]);
    }

    public function create()
    {
        return response()->json([
            'id' => Uuid::uuid4(),
        ]);
    }

    /**
     * Show the page to edit a given topic.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        return response()->json([
            'topic' => Topic::findOrFail($id),
        ]);
    }

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

        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        $topic = new Topic(['id' => request('id')]);
        $topic->fill($data);
        $topic->save();

        return response()->json([$topic]);
    }

    /**
     * Save a given topic.
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

        $messages = [
            'required' => __('canvas::validation.required'),
            'unique'   => __('canvas::validation.unique'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => 'required|'.Rule::unique('canvas_topics', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        $topic->fill($data);
        $topic->save();

        return response()->json([$topic]);
    }

    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return response()->json([$topic]);
    }
}
