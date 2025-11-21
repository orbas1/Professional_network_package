<?php

namespace ProNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProNetwork\Services\AgeVerificationService;

class AgeVerificationController extends Controller
{
    public function __construct(protected AgeVerificationService $service)
    {
    }

    public function request(Request $request)
    {
        return response()->json($this->service->requestVerification($request->user()->id));
    }

    public function status(Request $request)
    {
        return response()->json(['status' => $this->service->status($request->user()->id)]);
    }
}
