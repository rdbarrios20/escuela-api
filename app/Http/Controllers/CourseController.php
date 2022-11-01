<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coures = Course::all();
        return response()->json([
            'courses' => $coures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'hourly_intensity' => 'required|numeric'
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->hourly_intensity = $request->hourly_intensity;
        $course->save();

        return response()->json([
            'course' => $course
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        return response()->json([
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //code...
            $this->validate($request, [
                'name' => 'required|max:255',
                'hourly_intensity'=> 'required|numeric'
            ]);

            DB::table('courses')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'hourly_intensity' => $request->hourly_intensity,
                ]);

            return response()->json([
                'message' => "Curso modificado"
            ]);
        } catch (\Throwable $e) {
            report($e);
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //code...
            DB::transaction(function () use ($id) {
                DB::table('user_courses')->where('course_id', $id)->delete();
                DB::table('courses')->where('id', $id)->delete();
            });
            return response()->json([
                'message' => "Curso eliminado"
            ]);
        } catch (\Throwable $e) {
            report($e);
            $error = $e->getMessage();
            return $error;
        }
    }
}
