<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

// 'name',
// 'email',
// 'password',
// 'lastname',
// 'company',
// 'description',
// 'oficial_website',
// 'qrcode_base64',
// 'avatar'

class UserController extends Controller
{

    public function index() {
        try {
            $users = User::all();
            $response = ['data' => $users];
            return response($users,200);

        } catch(\Throwable $th) {
            $response = [
                'message' => 'Something went wrong',
                'err' => $th
            ];
            return response($response,500);
        }
        return response(500);
    }

    public function edit(Request $request, $id) {

        $fields = [];

        if(isset($request['name'])) $request->validate(['name' => 'string']);
        if(isset($request['lastname'])) $request->validate(['lastname' => 'string']);
        if(isset($request['company'])) $request->validate(['company' => 'string']);
        if(isset($request['description'])) $request->validate(['description' => 'string']);
        if(isset($request['oficial_website']))$request->validate(['oficial_website' => 'string']);

        if(isset($request['name'])) $fields['name'] = $request['name'];
        if(isset($request['lastname'])) $fields['lastname'] = $request['lastname'];
        if(isset($request['company'])) $fields['company'] = $request['company'];
        if(isset($request['description'])) $fields['description'] = $request['description'];
        if(isset($request['oficial_website'])) $fields['oficial_website'] = $request['oficial_website'];

        try {
            User::findOrFail($id)->update($fields);
            $response = [
                'message' => 'The user has been updated'
            ];
            return response($response,200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Something went wrong',
                'error' => $th
            ];
            return response($response,200);
        }

        return response(500);
    }
}

