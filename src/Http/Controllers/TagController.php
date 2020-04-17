<?php

namespace Canvas\Http\Controllers;

use Canvas\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Tag::forCurrentUser()
               ->latest()
               ->withCount('posts')
               ->paginate(), 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function show($id): JsonResponse
    {
        if ($this->isNewTag($id)) {
            return response()->json(Tag::make([
                'id' => Uuid::uuid4(),
            ]), 200);
        } else {
            $tag = Tag::forCurrentUser()->find($id);

            return $tag ? response()->json($tag, 200) : response()->json(null, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function store($id): JsonResponse
    {
        $data = [
            'id' => request('id'),
            'name' => request('name'),
            'slug' => request('slug'),
            'user_id' => request()->user()->id,
        ];

        $messages = [
            'required' => __('canvas::app.validation_required'),
            'unique' => __('canvas::app.validation_unique'),
        ];

        validator($data, [
            'name' => 'required',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('canvas_tags')->where(function ($query) use ($data) {
                    return $query->where('slug', $data['slug'])->where('user_id', $data['user_id']);
                })->ignore($this->isNewTag($id) ? null : $id)->whereNull('deleted_at'),
            ],
        ], $messages)->validate();

        if ($this->isNewTag($id)) {
            if ($tag = Tag::forCurrentUser()->onlyTrashed()->where('slug', $data['slug'])->first()) {
                $tag->restore();
            } else {
                $tag = new Tag(['id' => $data['id']]);
            }
        } else {
            $tag = Tag::forCurrentUser()->find($id);
        }

        $tag->fill($data);
        $tag->save();

        return response()->json($tag->refresh(), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $tag = Tag::forCurrentUser()->find($id);

        if ($tag) {
            $tag->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * Return true if the given ID is for a new tag.
     *
     * @param $id
     * @return bool
     */
    private function isNewTag($id): bool
    {
        return $id === 'create';
    }
}
