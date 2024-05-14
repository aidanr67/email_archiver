<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\AddEmail;
use Illuminate\Database\QueryException;
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
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            AddEmail::dispatchSync($request->eml_file);
        } catch (QueryException $e) {
            return response()->json(['errors' => 'Unable to save data, verify .eml file.'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => 'File uploaded successfully'], Response::HTTP_CREATED);
    }
}
