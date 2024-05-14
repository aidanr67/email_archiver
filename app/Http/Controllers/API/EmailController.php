<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\AddEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EmailController
 *
 * @package App\Http\Controllers\API
 */
class EmailController extends Controller
{
    /**
     * Handles /email api endpoint.
     *
     * @param EmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'eml_file' => 'required|mimes:eml',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        AddEmail::dispatchSync($request->eml_file);

        return response()->json(['message' => 'File uploaded successfully'], Response::HTTP_CREATED);
    }
}
