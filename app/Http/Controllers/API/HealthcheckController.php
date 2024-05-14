<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class HealthcheckController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['healthy' => true]);
    }
}
