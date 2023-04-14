<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class ExternalServicesController extends Controller
{
    public function getQrCode(Request $request, $id)
    {
        // $fields = $request->validate([
        //     'title' => 'required',
        //     'link' => 'required'
        // ]);


        $width = $request->query('width') ? $request->query('width') : 500;
        $height = $request->query('height') ? $request->query('height') : 500;

        try {
            $user = User::findOrFail($id);


            $message = 'The image is encoded as base64';


            if ($user) {
                if(!$user->qrcode_base64) {

                    $client = new \GuzzleHttp\Client();

                    $response = $client->get('https://qr-code-generator-48ad.onrender.com/qrcode', [
                        'query' => [
                            'data' => $user->oficial_website,
                            'width' => $width,
                            'height' => $height,
                        ],
                    ]);

                    $body = $response->getBody();
                    $image = (string) $body;
                    $base64 = base64_encode($image);

                    $user->qrcode_base64 = $base64;
                    $user->save();

                    $data = $user->qrcode_base64;
                    return response()->json(['message' => $message, 'data' => $data]);
                }
                $data = $user->qrcode_base64;
                return response()->json(['message' => $message, 'data' => $data]);
            }
            return response(404);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response("The element you are looking for may not exist", 204);
        } catch (\Throwable $th) {
            return response($th, 500);
            return response("Something went wrong in the server", 500);
        }
    }
}
