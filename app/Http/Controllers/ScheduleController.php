<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScheduleRequest $request)
    {
        $sched = new Schedule();
        $sched->user_id = $request->user_id;
        $sched->course_year = $request->course_year;
        $sched->semester = $request->semester;
        // $sched->course_id = $request->course_id;
        $sched->appointment_id = $request->appointment_id;
        $sched->save();

        return redirect(route("student.schedule"))->with('success', 'Created Successfully');
    }

    public function addSchedule(Request $request)
    {
        try {
            $check = Schedule::where('appointment_id', $request->id)
                ->where('user_id', Auth::user()->id)->first();
            if ($check != '') {
                redirect(route("subject"))->with('success', 'Subject Already Exist!');
            } else {
                $appointment = Appointment::where('id', $request->id)->first();
                $add = new Schedule();
                $add->user_id = Auth::user()->id;
                $add->year = $request->year;
                $add->semester = $request->semester;
                $add->appointment_id = $appointment->id;
                $add->save();

                redirect(route("subject"))->with('success', 'Created Successfully');
            }

        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function subject(Request $request)
    {
        $subjects = Appointment::select('appointments.id as id', 'courses.subjectCode as code', 'courses.time_start as start', 'courses.time_end as finish', 'courses.description as description', 'courses.type as type')
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->join('rooms', 'courses.room_id', '=', 'rooms.id')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('courses.type', 'LIKE', "%" . $request->type . "%")
            // ->where('courses.year', 'LIKE', "%" . $request->year . "%")
            // ->where('courses.year', 'LIKE', "%" . $request->search . "%")
            ->get();
            // dd($subjects);
        $courses = Course::get();
        if($request->type){
            $courses = Course::where('courses.type', 'LIKE', "%" . $request->type . "%")->get();
        }
        $instructor = null;
        if ($request->search) {
            $instructor = Appointment::select('users.name as name', 'courses.day as day', 'courses.status as status', 'rooms.name as roomName')->join('users', 'appointments.user_id', '=', 'users.id')
                ->join('courses', 'appointments.course_id', 'courses.id')
                ->join('rooms', 'courses.room_id', 'rooms.id')
                ->where('appointments.id', $request->search)
                ->first();
        }
        return view('student.subject.index', compact('subjects', 'courses', 'instructor'));
    }

    public function blockSchedule(Request $request)
    {
        $events = [];
        $appointments = [];
        $appointments = Appointment::with(['user'])
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->where('appointments.user_id', 'LIKE', "%" . $request->search . "%")->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->subject.' '.$appointment->subjectCode,
                'start' => $appointment->month_start . '-05' . ' ' . $appointment->time_start . ':00',
                'end' => $appointment->month_end . '-05' . ' ' . $appointment->time_end . ':00',
                'description' => 'html: <b>' . $appointment->description . '</b>',
            ];
        }
        return view('block.index', compact('events'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }
}
