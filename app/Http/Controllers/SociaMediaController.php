<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SociaMedia;

class SociaMediaController extends Controller
{
    public function index()
    {
        $data = SociaMedia::all();

        $response = [
            'message' => 'Social Media successfully retrieved',
            'data' => $data
        ];
        return response($response, 200);
    }


    public function store(Request $request)
    {

        //If the validation fails, the proper response is automatically be generated.
        $fields = $request->validate([
            'title' => 'required',
            'link' => 'required',
            'user_id' => 'required',
        ]);

        SociaMedia::create($fields);

        $response = [
            'message' => 'A social media was registered'
        ];

        return response($response, 201);
    }


    public function show($id)
    {
        try {

            $socialMedia = SociaMedia::findOrFail($id);
            return response()->json($socialMedia, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }

    public function edit(Request $request, $id)
    {
        //If the validation fails, the proper response is automatically be generated.
        $fields = $request->validate([
            'title' => 'required',
            'link' => 'required'
        ]);
        try {
            SociaMedia::findOrFail($id)->update($fields);

            $response = [
                'message' => 'Social Media updated',
            ];

            return response($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("The element you are looking for may not exist", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }


    public function destroy($id)
    {
        try {
            SociaMedia::findOrFail($id)->delete();

            $response = [
                'message' => 'Social Media deleted',
            ];

            return response($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }
}
