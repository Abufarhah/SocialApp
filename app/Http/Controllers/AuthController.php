<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class AuthController
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 202);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $responseArray = [];
        $responseArray ['token'] = $user->createToken('MyApp')->accessToken;
        $responseArray ['name'] = $user->name;
        return response()->json($responseArray, 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $responseArray = [];
            $responseArray['token'] = $user->createToken('MyApp')->accessToken;
            $responseArray['name'] = $user->name;
            return response()->json($responseArray);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function test(Request $request)
    {
        return response()->json(['test' => 'test'], 200);
    }

}
