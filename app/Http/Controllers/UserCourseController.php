<?php

namespace App\Http\Controllers;

use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $matriculas = DB::table('user_courses AS uc')
            ->select([
                'uc.id',
                'us.name',
                'cou.name AS alumno',
                'uc.created_at AS fecha'
            ])
            ->join('users AS us', 'us.id', 'uc.user_id')
            ->join('courses AS cou', 'cou.id', 'uc.course_id')
            ->get();

        return response()->json([
            'enrollments' => $matriculas
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
        try {
            //code...
            $this->validate($request, [
                'user' => 'required|numeric',
                'course' => 'required|numeric'
            ]);

            $enrollment = new UserCourse();
            $enrollment->user_id = $request->user;
            $enrollment->course_id = $request->course;
            $enrollment->save();

            return response()->json([
                'enrollment' => $enrollment
            ]);
        } catch (\Throwable $e) {
            report($e);
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
            DB::table('user_courses')->where('id', $id)->delete();
            return response()->json([
                'message' => "Inscripcion eliminada"
            ]);
        } catch (\Throwable $e) {
            report($e);
            $error = $e->getMessage();
            return $error;
        }
    }
}
