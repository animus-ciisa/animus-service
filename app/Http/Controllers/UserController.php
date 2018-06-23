<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, $id)
    {
        $response = ControllerResponses::createdResp(['request' => $request->all(), 'id' => $id]);
        return response()->json($response, $response->code);
    }
}