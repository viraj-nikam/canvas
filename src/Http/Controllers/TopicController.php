<?php

namespace Canvas\Http\Controllers;

use Canvas\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TopicController extends Controller
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
            Topic::latest()
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
        return response()->json(Topic::make([
            'id' => Uuid::uuid4()->toString(),
        ]), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function store(Request $request, $id): JsonResponse
    {
        $topic = Topic::find($id);

        if (! $topic) {
            if ($topic = Topic::onlyTrashed()->firstWhere('slug', $request->input('slug'))) {
                $topic->restore();

                return response()->json($topic->refresh(), 201);
            } else {
                $topic = new Topic(['id' => $id]);
            }
        }

        $data = [
            'id' => $topic->id,
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'user_id' => $request->user()->id,
        ];

        $rules = [
            'name' => 'required',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('canvas_topics')->where(function ($query) use ($data) {
                    return $query->where('slug', $data['slug'])->where('user_id', $data['user_id']);
                })->ignore($id)->whereNull('deleted_at'),
            ],
        ];

        $messages = [
            'required' => trans('canvas::app.validation_required', [], optional($topic->userMeta)->locale),
            'unique' => trans('canvas::app.validation_unique', [], optional($topic->userMeta)->locale),
        ];

        validator($data, $rules, $messages)->validate();

        $topic->fill($data);

        $topic->save();

        return response()->json($topic->refresh(), 201);
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
        $topic = Topic::find($id);

        return $topic ? response()->json($topic, 200) : response()->json(null, 404);
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
        $topic = Topic::with('posts')->find($id);

        return $topic ? response()->json($topic->posts()->withCount('views')->paginate(), 200) : response()->json(null, 200);
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
        $topic = Topic::findOrFail($id);

        $topic->delete();

        return response()->json(null, 204);
    }
}
