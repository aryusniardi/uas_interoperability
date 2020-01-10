<?php
    namespace App\Http\Controllers;

    use App\Models\Petugas;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller {
        
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request) {
        $acceptHeader = $request->header('Accept');

        // Validasi hanya pplication/json atau application/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            /**
             * Validation Header {
             *  Accept : application/json
             * }
             */
            if ($acceptHeader === 'application/json') {
                $petugas = Petugas::OrderBy("petugas_id", "DESC")->paginate(10)->toArray();

                if (!$petugas) {
                    abort(404);
                }

                $response = [
                    "total_count" => $petugas["total"],
                    "limit" => $petugas["per_page"],
                    "pagination" => [
                        "next_page" => $petugas["next_page_url"],
                        "current_page" => $petugas["current_page"]
                    ],
                    "data" => $petugas["data"],
                 ];
                 
                // Response json
                return response()->json($response, 200);
            } 

            /**
             * Validation Header {
             *  Accept : application/xml
             * }
             */
            else if ($acceptHeader === 'application/xml') {
                $petugas = Petugas::OrderBy("petugas_id", "DESC")->paginate(10);

                if (!$petugas) {
                    abort(404);
                }
                
                $xml = new \SimpleXMLElement('<Petugas/>');
                //dd($petugas);
                foreach ($petugas->items('data') as $item) {
                    $xmlItem = $xml->addChild('Petugas');

                    $xmlItem->addChild('petugas_id', $item->petugas_id);
                    $xmlItem->addChild('email', $item->email);
                    $xmlItem->addChild('password', $item->password);
                    $xmlItem->addChild('role', $item->role);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }

                return $xml->asXML();
            } else {
                return response('Unsupported Media Type', 403);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $acceptHeader = $request->header('Accept');

        // validasi: hanya application/json atau application/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');
            $input = $request->all();

            $validationRules = [
                'email' => 'required|email|unique:petugas',
                'password' => 'required|min:6|confirmed',
                'role' => 'required'
            ];

            $validator = Validator::make($input, $validationRules);
            
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $petugas = Petugas::create($input);

            /**
             * Validation Header {
             *  Accept : application/json
             *  Content-Type : application/json
             * }
             */
            if ($acceptHeader === 'application/json') {
                if ($contentTypeHeader === 'application/json') {
                    return response()->json($petugas, 200);
                } else {
                    return response('Unsupported Media Type', 403);
                }
            } 
            
            /**
             * Validation Header {
             *  Accept : application/xml
             *  Content-Type : application/json
             * }
             */
            else if ($acceptHeader === 'application/xml') {
                if ($contentTypeHeader === 'application/json') {

                    $xml = new \SimpleXMLElement('<Petugas/>');

                    $xml->addChild('petugas_id', $petugas->petugas_id);
                    $xml->addChild('email', $petugas->email);
                    $xml->addChild('password', $petugas->password);
                    $xml->addChild('role', $petugas->role);
                    $xml->addChild('created_at', $petugas->created_at);
                    $xml->addChild('updated_at', $petugas->updated_at);

                    return $xml->asXML();
                } else {
                    return response('Unsupported Media Type', 403);
                }
            } else {
                return response('Unsupported Media Type', 403);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $petugas = Petugas::find($id);

            if (!$petugas) {
                abort(404);
            }
            
            /**
             * Validation Header {
             *  Accept : application/json
             * }
             */
            if ($acceptHeader === 'application/json') {
                return response()->json($petugas, 200);
            } 
            
            /**
             * Validation Header {
             *  Accept : application/xml
             * }
             */
            else if ($acceptHeader === 'application/xml') {
                $xml = new \SimpleXMLElement('<Petugas/>');

                $xml->addChild('petugas_id', $petugas->petugas_id);
                $xml->addChild('email', $petugas->email);
                $xml->addChild('password', $petugas->password);
                $xml->addChild('role', $petugas->role);
                $xml->addChild('created_at', $petugas->created_at);
                $xml->addChild('updated_at', $petugas->updated_at);

                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $acceptHeader = $request->header('Accept');
        $input = $request->all();
        $petugas = Petugas::find($id);

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');

            $validationRules = [
                'email' => 'required|email|unique:petugas',
                'password' => 'required|min:6|confirmed',
                'role' => 'required'
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            if (!$petugas) {
                abort(404);
            }

            $petugas->fill($input);
            $petugas->save();
            
            /**
             * Validation Header {
             *  Accept : application/json
             *  Content-Type : application/json
             * }
             */
            if ($acceptHeader === 'application/json') {
                if ($contentTypeHeader === 'application/json') {
                    return response()->json($petugas, 200);
                } else {
                    return ('Unsupported Media Type');
                }
            } 
            
            /**
             * Validation Header {
             *  Accept : application/xml
             *  Content-Type : application/json
             * }
             */
            else if ($acceptHeader === 'application/xml') {
                if ($contentTypeHeader === 'application/json') {
                   $xml = new \SimpleXMLElement('<Petugas/>');

                    $xml->addChild('petugas_id', $petugas->petugas_id);
                    $xml->addChild('email', $petugas->email);
                    $xml->addChild('password', $petugas->password);
                    $xml->addChild('role', $petugas->role);
                    $xml->addChild('created_at', $petugas->created_at);
                    $xml->addChild('updated_at', $petugas->updated_at);

                    return $xml->asXML();
                } else {
                    return response('Unsupported Media Type', 403);
                }
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        /**
         * Validation Header {
         *  Accept : application/json || application/xml
         * }
         */
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $petugas = Petugas::find($id);
            
            if (!$petugas) {
                abort(404);
            }
            
            $petugas->delete();
            $message = [
                'message' => 'deleted successfully', 
                'post_id' => $id
            ];
            
            return response()->json($message, 200);
        }
    }
}
?>