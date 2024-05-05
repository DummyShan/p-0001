<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFacultyRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Rooms;
use App\Models\Schedule;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('super_access'), 403);
        $lists = Faculty::where('name', 'LIKE', "%" . $request->search . "%")->orderBy("created_at", "desc")->get();
        $users = User::where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.user_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Instructor')
            ->get();
        return view('faculties.index', compact('lists', 'users'));
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
    public function store(CreateFacultyRequest $request)
    {
        if ($request->validated()) {
            $user = User::where('id', $request->user_id)->first();
            $room = new Faculty();
            $room->name = $user->name;
            $room->idNo = $request->idNo;
            $room->email = $request->email;
            $room->contact = $request->contact;
            $room->user_id = $request->user_id;
            $room->save();

            return redirect(route("faculty.index"))->with('success', 'Created Successfully');
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

    public function schedule(Request $request)
    {
        // dd($request->search);
        abort_unless(Gate::allows('super_access'), 403);
        $lists = Faculty::where('name', 'LIKE', "%" . $request->search . "%")->orderBy("created_at", "desc")->get();
        $events = [];
        $appointments = [];
        if ($request->search) {
            $appointments = Appointment::with(['user'])
                ->join('courses', 'appointments.course_id', '=', 'courses.id')
                ->where('appointments.user_id', 'LIKE', "%" . $request->search . "%")->get();
            // dd($appointments);
        }
        for ($day = 1; $day <= 31; $day++) {

            foreach ($appointments as $appointment) {
                // Extract start date and time from the appointment
                $startDateTime = $appointment->month_start .'-'.$day. ' ' . $appointment->time_start . ':00';
                // dd(date('l', strtotime($startDateTime)));
                // Extract end date and time from the appointment
                $endDateTime = $appointment->month_end .'-'.$day. ' ' . $appointment->time_end . ':00';

                // Check if the appointment falls on a Monday
                if (date('l', strtotime($startDateTime)) == $appointment->day) {
                    // Add the event to the events array
                    $events[] = [
                        'title' => $appointment->user_id,
                        'start' => $startDateTime,
                        'end' => $endDateTime,
                        'description' => 'html: <b>' . $appointment->description . '</b>',
                    ];
                }
            }
        }
        // foreach ($appointments as $appointment) {
        //     $events[] = [
        //         'title' => $appointment->user_id,
        //         'start' => $appointment->month_start .'-05'.' '.$appointment->time_start.':00',
        //         'end' => $appointment->month_end  .'-05'.' '.$appointment->time_end.':00',
        //         'description' => 'html: <b>' . $appointment->description . '</b>',
        //     ];
        // }
        $users = User::where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Instructor')
            ->get();
        $rooms = Rooms::all();
        $courses = Course::get();
        return view('faculties.schedule.index', compact('lists', 'events', 'users', 'rooms', 'courses'));
    }

    public function studentSchedule(Request $request)
    {
        // dd($request->search);
        abort_unless(Gate::allows('super_access'), 403);
        // $lists = Faculty::where('name', 'LIKE', "%" . $request->search . "%")->orderBy("created_at", "desc")->get();
        $events = [];
        $appointments = Appointment::with(['user'])->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->join('rooms', 'appointments.room_id', '=', 'rooms.id')
            ->get();
        $schedules = [];
        if ($request->search) {
            $schedules = Schedule::join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
                ->join('users', 'schedules.user_id', '=', 'users.id')
                ->where('schedules.user_id', 'LIKE', "%" . $request->search . "%")
                ->orderBy("appointments.created_at", "desc")
                ->get();
        }
        foreach ($schedules as $schedule) {
            $events[] = [
                'title' => $schedule->name . ' (' . $schedule->course_id . ')',
                'start' => $schedule->start_time,
                'end' => $schedule->finish_time,
                'description' => $schedule->comments,
            ];
        }
        $users = User::where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Student')
            ->get();
        return view('student.schedule.index', compact('events', 'users', 'appointments'));
    }

    public function viewSchedule()
    {
        $events = [];
        $schedules = Schedule::select('schedules.user_id as studentID', 'appointments.start_time as start', 'appointments.finish_time as finish', 'courses.subjectCode as code', 'courses.year as year', 'rooms.name as roomName', 'rooms.description as roomType', 'users.name as instructorName')
            ->where('schedules.user_id', Auth::user()->id)
            ->join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->join('rooms', 'appointments.room_id', '=', 'rooms.id')
            ->join('courses', 'appointments.course_id', 'courses.id')
            ->get();
        // dd($schedules);
        foreach ($schedules as $schedule) {
            $events[] = [
                'title' => $schedule->code . ' (' . $schedule->roomName . ' ' . $schedule->roomType . ')',
                'start' => $schedule->start,
                'end' => $schedule->finish,
                'description' => 'html: <b>' . $schedule->instructorName . '</b>',
            ];
        }

        return view('student.view.index', compact('events', 'schedules'));
    }
}
