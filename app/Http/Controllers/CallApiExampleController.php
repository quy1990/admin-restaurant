<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallApiExampleController extends Controller
{
    public function showMonitors(UptimeRobotAPI $uptime_api)
    {
        $monitors = $uptime_api->getMonitors();

        return view('welcomme')->with(compact('monitors'));
    }
}
