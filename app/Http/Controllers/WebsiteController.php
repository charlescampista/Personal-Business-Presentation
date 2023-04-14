<?php

namespace App\Http\Controllers;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $data = Website::all();

        $response = [
            'message' => 'Website successfully retrieved',
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

        Website::create($fields);

        $response = [
            'message' => 'A website was registered'
        ];

        return response($response, 201);
    }


    public function show($id)
    {
        try {

            $website = Website::findOrFail($id);
            return response()->json($website, 200);
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
            Website::findOrFail($id)->update($fields);

            $response = [
                'message' => 'Website updated',
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
            // City::findOrFail($id)->delete();
            Website::findOrFail($id)->delete();

            $response = [
                'message' => 'Website deleted',
            ];

            return response($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }
}
