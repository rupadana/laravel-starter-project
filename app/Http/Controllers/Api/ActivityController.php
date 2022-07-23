<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activity = Activity::all()->last();
    }
}
