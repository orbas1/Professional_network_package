<?php

namespace ProNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProNetwork\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    public function __construct(protected AnalyticsService $service)
    {
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event' => 'required|string',
            'properties' => 'array',
        ]);
        $record = $this->service->track($data['event'], $data['properties'] ?? [], $request->user());
        return response()->json($record, 201);
    }
}
