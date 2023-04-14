<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        //If the validation fails, the proper response is automatically be generated.
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);


        if(isset($request['lastname'])) $request->validate(['lastname' => 'string']);
        if(isset($request['company'])) $request->validate(['company' => 'string']);
        if(isset($request['description'])) $request->validate(['description' => 'string']);
        if(isset($request['oficial_website'])) $request->validate(['oficial_website' => 'string']);
        if(isset($request['avatar'])) $request->validate(['avatar' => 'string']);

        $fields['password'] = bcrypt($request['password']);
        $fields['lastname'] = $request['lastname'];
        $fields['company'] = $request['company'];
        $fields['description'] = $request['description'];
        $fields['oficial_website'] = $request['oficial_website'];
        $fields['avatar'] = $request['avatar'];

        $user = User::create($fields);

        /*Bcrypt is better than SHA-256 because it's less prone to be broken by
        *Brute force approach*/
        // $user = User::create([
        //     'name' => $fields['name'],
        //     'email' => $fields['email'],
        //     'password' => bcrypt($fields['password']),
        //     'lastname' => $fields['lastname'],
        //     'company' => $fields['company'],
        //     'description' => $fields['description'],
        //     'oficial_website' => $fields['oficial_website'],
        //     'avatar' => $fields['avatar']
        // ]);


        // $user = User::create([
        //     'name' => $fields['name'],
        //     'email' => $fields['email'],
        //     'password' => bcrypt($fields['password'])
        // ]);


        /*Plaintext is here to return only the token value to the user,
        * Otherwise it will return the entire object*/
        $token = $user->createToken('buzzveltoken')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        $response = [
            'message' => 'User has been sucessfullycreated',
            'data' => $data
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        //If the validation fails, the proper response is automatically be generated.
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //Email check
        $user = User::where('email', $fields['email'])->first();

        //Password check
        //Hash function does the verification with bcrypt password stored in database
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong Credentials'
            ], 401);
        }

        /*Plaintext is here to return only the token value to the user,
        * Otherwise it will return the entire object*/
        $token = $user->createToken('buzzveltoken')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        $response = [
            'message' => 'Success on login',
            'data' => $data
        ];


        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        $response = [
            'message' => 'Success on logout'
        ];
        return response($response, 200);
    }
}
