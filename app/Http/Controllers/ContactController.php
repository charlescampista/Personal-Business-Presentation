<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $data = Contact::all();

        $response = [
            'message' => 'Contact successfully retrieved',
            'data' => $data
        ];
        return response($response, 200);
    }


    public function store(Request $request)
    {

        //If the validation fails, the proper response is automatically be generated.
        $fields = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required',
        ]);

        Contact::create($fields);

        $response = [
            'message' => 'A contact was registered'
        ];

        return response($response, 201);
    }


    public function show($id)
    {
        try {

            $contact = Contact::findOrFail($id);
            return response()->json($contact, 200);
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
            'content' => 'required'
        ]);
        try {
            Contact::findOrFail($id)->update($fields);

            $response = [
                'message' => 'Contact updated',
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
            Contact::findOrFail($id)->delete();

            $response = [
                'message' => 'Contact deleted',
            ];

            return response($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("", 204);
        } catch (\Throwable $th) {
            return response("Something went wrong in the server", 500);
        }
    }
}
