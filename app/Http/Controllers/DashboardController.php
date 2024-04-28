<?php

namespace App\Http\Controllers;

use App\Events\NewPostAdded;
use App\Models\Appointment;
use App\Models\Post;
use App\Models\Station;
use App\Models\StationUser;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_unless(Gate::allows('admin_access'), 403);
        $events = [];

        $appointments = Appointment::with(['user'])->where('user_id', Auth::user()->id)->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->user->name . ' (' . $appointment->comments . ')',
                'start' => $appointment->start_time,
                'end' => $appointment->finish_time,
                'description' => $appointment->comments,
            ];
        }
        $instructorCount = count($appointments);
        $instructorScheds = Appointment::where('user_id', Auth::user()->id)->get();

        return view('dashboard', compact('events', 'instructorCount', 'instructorScheds'));
    }

    public function indexStation(Request $request)
    {
        $blocks = StationUser::with('posts', 'user')->where('user_id', $request->fire_type)->get();
        $latests = Post::with('user', 'fire', 'station', 'vehicle')->where('station_id', $request->fire_type)->get();
        $check = Post::where('station_id', $request->fire_type)->first();

        $latestsender = Post::with('user', 'station', 'fire', 'vehicle')->latest()->first();
        $image = "https://unsplash.it/640/425?image=30";
        $vehicles = Vehicle::all();
        // $histories = VehicleHistory::join('vehicles', 'vehicles.id', '=', 'vehicle_history.id')->get();
        $stations = Station::all();
        $firetypes = [
            'Residential',
            'Warehouse',
            'Rubbish Fire',
            'Electric Post Fire',
            'Structural',
            'Grass Fire',
            'Forest Fire'
        ];
        if ($check !== null) {
            return view('dashboard', compact('latests', 'latestsender', 'image', 'vehicles', 'stations', 'firetypes', 'blocks'));
        } else {
            return redirect()->back()->with('success', 'Station has no reports available');
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $latests = Post::with('user', 'fire', 'station')->where('id', $id)->get();

        $latestsender = Post::where('id', $id)->with('user', 'station', 'fire')->latest()->first();
        $image = "https://unsplash.it/640/425?image=30";
        $vehicles = Vehicle::all();
        $histories = VehicleHistory::join('vehicles', 'vehicles.id', '=', 'vehicle_history.id')->get();
        $stations = Station::all();
        $firetypes = [
            'Residential',
            'Warehouse',
            'Rubbish Fire',
            'Electric Post Fire',
            'Structural',
            'Grass Fire',
            'Forest Fire'
        ];

        return view('dashboard', compact('latests', 'latestsender', 'image', 'vehicles', 'histories', 'stations', 'firetypes'));
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

    public function notifyStations($id)
    {
        //Send Push Notification

        $SERVER_API_KEY = "AAAARQtY8YQ:APA91bHtaTTvc4HeRWKrC_nD_9SQSd5uwXLSFEczWGowG2OpApGYDmC7otLMlG6dnDoNtl8DOJTzT2VIrYjzTxbFe59XmJtQmz6qcxs7Of1SAsdr24n2vkEe8VPquLyMPnN5uGkArb6G";
        $userkeys = StationUser::where('station_id', $id)
            ->join('users', 'users.id', '=', 'station_user.user_id')
            ->where('device_key', '!=', '')
            // ->where('id', '=', Auth::user()->id)
            ->get();
        if (isset($userkeys)) {
            foreach ($userkeys as $value) {
                // if ($value->device_key) {
                $data = [
                    "registration_ids" => [$value->device_key],
                    "notification" => [
                        "title" => "New alerts",
                        "body" => "Update",
                    ]
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                curl_exec($ch);


                return redirect()->back()->with('success', 'Station Alarmed!');
                // } else {
                //     return redirect()->back()->with('success', 'Station is not active');
                // }
                // return redirect()->back()->with('success', 'Station is not active');
            }
            return redirect()->back()->with('error', 'Station is not active');
        }
    }

    public function test()
    {
        return response()->json('test', 200);
    }
}
