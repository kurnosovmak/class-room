<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\LectureFilter;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Http\Resources\Collections\LectureCollection;
use App\Http\Resources\Jsons\LectureFullJson;
use App\Http\Resources\Jsons\LectureJson;
use App\Models\Lecture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    protected Lecture $lectures;

    public function __construct(Lecture $lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(LectureFilter $filter): JsonResponse
    {
        $lectures = $this->lectures->filter($filter)->sort()->get();
        return LectureJson::collection($lectures)->toResponse(null);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLectureRequest $request
     * @return JsonResponse
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        $lecture = $this->lectures->create($request->only(['theme', 'description']));
        return (new LectureFullJson($lecture))->toResponse($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function show(Lecture $lecture): JsonResponse
    {
        return (new LectureFullJson($lecture))->toResponse(null);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLectureRequest $request
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture): JsonResponse
    {
        $lecture->fill($request->only(['theme', 'description']))->save();
        return (new LectureFullJson($lecture))->toResponse(null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        $lecture->delete();
        return response()->json(null, 204);
    }
}
