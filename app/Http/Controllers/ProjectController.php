<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $data = Project::all();

        $response = [
            'message' => 'Project successfully retrieved',
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
            'description' => 'required',
            'user_id' => 'required',
        ]);

        Project::create($fields);

        $response = [
            'message' => 'A project was registered'
        ];

        return response($response, 201);
    }


    public function show($id)
    {
        try {

            $project = Project::findOrFail($id);
            return response()->json($project, 200);
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
            'link' => 'required',
            'description' => 'required',
        ]);
        try {
            Project::findOrFail($id)->update($fields);

            $response = [
                'message' => 'Project updated',
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
            Project::findOrFail($id)->delete();

            $response = [
                'message' => 'Project deleted',
            ];

            return response($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }
}
