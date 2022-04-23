<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\ClassroomFilter;
use App\Http\Requests\SetClassroomRequest;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Http\Resources\Jsons\ClassroomFullJson;
use App\Http\Resources\Jsons\ClassroomJson;
use App\Http\Resources\Jsons\LectureJson;
use App\Models\Classroom;
use App\Models\Lecture;
use App\Services\LectureService;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    protected Classroom $classrooms;
    protected LectureService $lectureService;

    public function __construct(Classroom $classrooms, LectureService $lectureService)
    {
        $this->classrooms = $classrooms;
        $this->lectureService = $lectureService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ClassroomFilter $filter
     * @return JsonResponse
     */
    public function index(ClassroomFilter $filter): JsonResponse
    {
        $classrooms = $this->classrooms->filter($filter)->sort()->get();
        return ClassroomJson::collection($classrooms)->toResponse(null);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClassroomRequest $request
     * @return JsonResponse
     */
    public function store(StoreClassroomRequest $request): JsonResponse
    {
        $classrooms = $this->classrooms->create($request->only(['title']));
        return (new ClassroomFullJson($classrooms))->toResponse($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function show(Classroom $classroom): JsonResponse
    {
        return (new ClassroomFullJson($classroom))->toResponse(null);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClassroomRequest $request
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function update(UpdateClassroomRequest $request, Classroom $classroom): JsonResponse
    {
        $classroom->fill($request->only(['title']))->save();
        return (new ClassroomFullJson($classroom))->toResponse(null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        $classroom->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all lectures in order.
     *
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function get(Classroom $classroom): JsonResponse
    {
        $lectures = $this->lectureService->getLecturesByClassroom($classroom);
        return LectureJson::collection($lectures)->toResponse(null);
    }

    /**
     * Set lectures in order.
     *
     * @param SetClassroomRequest $request
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function set(SetClassroomRequest $request, Classroom $classroom): JsonResponse
    {
        $lectures = $this->lectureService->setLecturesByClassroom($classroom, $request->lectures);
        return LectureJson::collection($lectures)->toResponse(null);
    }
}
