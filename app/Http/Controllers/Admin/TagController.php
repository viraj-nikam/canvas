<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Requests\TagCreateRequest;

class TagController extends Controller
{
    protected $fields = [
        'tag' => '',
        'title' => '',
        'subtitle' => '',
        'meta_description' => '',
        'layout' => 'blog.layouts.index',
        'reverse_direction' => 0,
    ];

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return view('site.admin.tag.index')->withTags($tags);
    }

    /**
     * Show the form for creating a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('site.admin.tag.create', $data);
    }

    /**
    * Store the newly created tag in the database
    *
    * @param TagCreateRequest $request
    * @return Response
    */
    public function store(TagCreateRequest $request)
    {
    $tag = new Tag();
    foreach (array_keys($this->fields) as $field) {
      $tag->$field = $request->get($field);
    }
    $tag->save();

    return redirect('/admin/tag')->withSuccess("The tag '$tag->tag' was created.");
    }

    /**
    * Show the form for editing a tag
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $data = ['id' => $id];
            foreach (array_keys($this->fields) as $field) {
                $data[$field] = old($field, $tag->$field);
            }

        return view('site.admin.tag.edit', $data);
    }

    /**
    * Update the tag in storage
    *
    * @param TagUpdateRequest $request
    * @param int  $id
    * @return Response
    */
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        foreach (array_keys(array_except($this->fields, ['tag'])) as $field) {
            $tag->$field = $request->get($field);
        }

        $tag->save();

        return redirect("/admin/tag/$id/edit")->withSuccess("Changes saved.");
  }

    /**
    * Delete the tag
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect('/admin/tag')->withSuccess("The '$tag->tag' tag has been deleted.");
  }
}
