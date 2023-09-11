<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(UserLoginRequest $request) {
        $data  = $request->validated();

        $user = User::with("regional")->where("id_card_number",$data["id_card_number"])->first();
        if(!$user || !Hash::check($data["password"],$user["password"])){
            throw new  HttpResponseException(response()->json(["message"=>"ID Card Number or Password incorrect"])->setStatusCode(401));
        }else{
            $user->token = md5($data["id_card_number"]);
            $user->save();
            unset($user->id);
            unset($user->created_at);
            unset($user->updated_at);
            unset($user->regional->created_at);
            unset($user->regional->updated_at);
            return response()->json($user);
        }

    }
    function logout(Request $request){
        $token = $request->header("token");
        $user = User::where("token",$token)->first();
        $user->token = null;
        $user->save();
        return response([
            "message" => "Logout success"
        ]);
    }
}
