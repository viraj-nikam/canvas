<?php

namespace Canvas\Http\Controllers;

use Canvas\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            Tag::latest()
               ->withCount('posts')
               ->paginate(), 200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return response()->json(Tag::make([
            'id' => Uuid::uuid4()->toString(),
        ]), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $id): JsonResponse
    {
        $tag = Tag::find($id);

        if (! $tag) {
            if ($tag = Tag::onlyTrashed()->firstWhere('slug', $request->input('slug'))) {
                $tag->restore();

                return response()->json($tag->refresh(), 201);
            } else {
                $tag = new Tag(['id' => $id]);
            }
        }

        $data = [
            'id' => $tag->id,
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'user_id' => $request->user()->id,
        ];

        $rules = [
            'name' => 'required',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('canvas_tags')->where(function ($query) use ($data) {
                    return $query->where('slug', $data['slug'])->where('user_id', $data['user_id']);
                })->ignore($id)->whereNull('deleted_at'),
            ],
        ];

        $messages = [
            'required' => trans('canvas::app.validation_required', [], optional($tag->userMeta)->locale),
            'unique' => trans('canvas::app.validation_unique', [], optional($tag->userMeta)->locale),
        ];

        validator($data, $rules, $messages)->validate();

        $tag->fill($data);

        $tag->save();

        return response()->json($tag->refresh(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $tag = Tag::find($id);

        return $tag ? response()->json($tag, 200) : response()->json(null, 404);
    }

    /**
     * Display the specified relationship.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function showPosts(Request $request, $id): JsonResponse
    {
        $tag = Tag::with('posts')->find($id);

        return $tag ? response()->json($tag->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return response()->json(null, 204);
    }
}
