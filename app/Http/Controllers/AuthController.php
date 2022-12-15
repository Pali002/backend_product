<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    public function signUp(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "password_confirm" => "required|same:password"
        ]);

        if($validator->fails()){
            return sendError("Error validation", $validator->errors());
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;

        return $this->sendResponse($success, "Sikeres regisztráció");
    }

    public function signIn(Request $request){
        if(Auth::attempt(["email" => $request->email, "password" => $request->password])){

            $authUser = Auth::user();
            $succcess["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
            $success["name"] = $authUser->name;
            
            return $this->sendResponse($success,"Sikeres bejelentketés");
        }else{
            return $this->sendError("Unathorized".["error" => "Hibás adatok!"]);
        }
    }



}
