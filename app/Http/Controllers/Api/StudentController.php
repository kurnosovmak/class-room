<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\StudentFilter;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Jsons\StudentFullJson;
use App\Http\Resources\Jsons\StudentJson;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected Student $students;

    public function __construct(Student $students)
    {
        $this->students = $students;
    }

    /**
     * Display a listing of the resource.
     *
     * @param StudentFilter $filter
     * @return JsonResponse
     */
    public function index(StudentFilter $filter): JsonResponse
    {
        $students = $this->students->filter($filter)->sort()->get();
        return StudentJson::collection($students)->toResponse(null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudentRequest $request
     * @return JsonResponse
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = $this->students->create($request->only(['name', 'email', 'classroom_id']));
        return (new StudentFullJson($student))->toResponse($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function show(Student $student): JsonResponse
    {
        return (new StudentFullJson($student))->toResponse(null);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $student->fill($request->only(['name', 'email', 'classroom_id']))->save();
        return (new StudentFullJson($student))->toResponse($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function destroy(Student $student): JsonResponse
    {
        $student->delete();
        return response()->json(null, 204);
    }
}
