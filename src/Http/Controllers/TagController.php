<?php

namespace Canvas\Http\Controllers;

use Canvas\Tag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TagController extends Controller
{
    /**
     * Show the tags index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Grab all of the tags
        $tags = Tag::orderByDesc('created_at')
            ->withCount('posts')
            ->get();

        return view('canvas::tags.index', compact('tags'));
    }

    /**
     * Show the page to create a new tag.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Generate a new tag ID
        $tag_id = Str::uuid();

        return view('canvas::tags.create', compact('tag_id'));
    }

    /**
     * Show the page to edit a given tag.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Lookup a tag given an ID
        $tag = Tag::findOrFail($id);

        return view('canvas::tags.edit', compact('tag'));
    }

    /**
     * Save a new tag.
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
            'slug' => 'required|'.Rule::unique('canvas_tags', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        // Create a new tag
        $tag = new Tag(['id' => request('id')]);
        $tag->fill($data);
        $tag->save();

        return redirect(route('canvas.tag.edit', $tag->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Save a given tag.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id)
    {
        // Lookup a tag given an ID
        $tag = Tag::findOrFail($id);

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
            'slug' => 'required|'.Rule::unique('canvas_tags', 'slug')->ignore(request('id')).'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i',
        ], $messages)->validate();

        // Update the tag
        $tag->fill($data);
        $tag->save();

        return redirect(route('canvas.tag.edit', $tag->id))->with('notify', __('canvas::nav.notify.success'));
    }

    /**
     * Delete a given tag.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Lookup a tag given an ID
        $tag = Tag::findOrFail($id);

        // Delete the tag
        $tag->delete();

        return redirect(route('canvas.tag.index'));
    }
}
