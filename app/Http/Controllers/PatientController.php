<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Jobs\PatientHanding;
use App\Models\Patient;
use Illuminate\Support\Facades\Cache;

class PatientController extends Controller
{
    public function index()
    {
        if (Cache::has('list')) {
            return Cache::get('list');
        }

        $list = Patient::get();
        $list = PatientResource::collection($list);
        Cache::put('list', $list, 5);

        return response()->json($list);
    }

    public function create(PatientRequest $request)
    {
        $patient = Patient::create($request->all());

        Cache::put('model', $patient, 5);

        $job = new PatientHanding($patient);
        $job->onQueue('patient');
        dispatch($job);
    }
}
