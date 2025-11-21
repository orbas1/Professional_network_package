<?php

namespace ProNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProNetwork\Services\NewsletterService;

class NewsletterController extends Controller
{
    public function __construct(protected NewsletterService $service)
    {
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        return response()->json($this->service->subscribe($data['email'], optional($request->user())->id));
    }

    public function unsubscribe(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        return response()->json($this->service->unsubscribe($data['email']));
    }
}
