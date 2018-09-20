<?php namespace App\Http\Controllers;

class EmotionController extends Controller
{

    public function store(Request $request)
    {
        $response = ControllerResponses::notFoundResp();
        if ($authHome = JWTAuth::parseToken()->authenticate()) {
            $emotions = $request->input('emotions');
            if(is_array($emotions)){
                for($i = 0; $i < count($emotions); $i++){

                }
            }
        }
    }
}