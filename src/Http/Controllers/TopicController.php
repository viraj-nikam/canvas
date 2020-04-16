<?php

namespace Canvas\Http\Controllers;

use Canvas\Topic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Topic::forCurrentUser()
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
        if ($this->isNewTopic($id)) {
            return response()->json(Topic::make([
                'id' => Uuid::uuid4(),
            ]), 200);
        } else {
            $topic = Topic::forCurrentUser()->find($id);

            return $topic ? response()->json($topic, 200) : response()->json(null, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function store(string $id): JsonResponse
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
                Rule::unique('canvas_topics')->where(function ($query) use ($data) {
                    return $query->where('slug', $data['slug'])->where('user_id', $data['user_id']);
                })->ignore($this->isNewTopic($id) ? null : $id)->whereNull('deleted_at'),
            ],
        ], $messages)->validate();

        if ($this->isNewTopic($id)) {
            if ($topic = Topic::forCurrentUser()->onlyTrashed()->where('slug', request('slug'))->first()) {
                $topic->restore();
            } else {
                $topic = new Topic(['id' => request('id')]);
            }
        } else {
            $topic = Topic::forCurrentUser()->find($id);
        }

        $topic->fill($data);
        $topic->save();

        return response()->json($topic->refresh(), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        $topic = Topic::forCurrentUser()->find($id);

        if ($topic) {
            $topic->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * Return true if the given ID is for a new topic.
     *
     * @param string $id
     * @return bool
     */
    private function isNewTopic(string $id): bool
    {
        return $id === 'create';
    }
}
