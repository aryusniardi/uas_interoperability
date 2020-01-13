<?php
    namespace App\Http\Controllers;

    use App\Models\Tanggapan;
    use App\Models\Keluhan;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

class TanggapanController extends Controller {
        
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request) {
         $acceptHeader = $request->header('Accept');
         if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $tanggapan = Tanggapan::OrderBy("tanggapan_id", "DESC")->paginate(10)->toArray();
            
            if (!$tanggapan) {
                abort(404);
            }

            $response = [
                "total_count" => $tanggapan["total"],
                "limit" => $tanggapan["per_page"],
                "pagination" => [
                    "next_page" => $tanggapan["next_page_url"],
                    "current_page" => $tanggapan["current_page"]
                ],
                "data" => [
                    "tanggapan" => $tanggapan["data"]
                ]
            ];

            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($response, 200);
            } 
            
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<Data_Tanggapan/>');

                $xml->addChild('total_count', $tanggapan['total']);
                $xml->addChild('limit', $tanggapan['per_page']);
                $pagination = $xml->addChild('pagination');
                $pagination->addChild('next_page', $tanggapan['next_page_url']);
                $pagination->addChild('current_page', $tanggapan['current_page']);
                $xml->addChild('total_count', $tanggapan['total']);

                foreach ($tanggapan['data'] as $item) {
                    $xmlItem = $xml->addChild('petugas');

                    $xmlItem->addChild('tanggapan_id', $item['tanggapan_id']);
                    $xmlItem->addChild('keluhan_id', $item['keluhan_id']);
                    $xmlItem->addChild('petugas_id', $item['petugas_id']);
                    $tanggapanItem = $xmlItem->addChild('tanggapan');
                    $tanggapanItem->addChild($item['tanggapan']);
                    $xmlItem->addChild('alasan', $item['alasan']);
                    $xmlItem->addChild('created_at', $item['created_at']);
                    $xmlItem->addChild('updated_at', $item['updated_at']);
                }
                
                return $xml->asXML();
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
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ], 403);
        }

        $input = $request->all();
        
        $validationRules = [
            'keluhan_id' => 'required|exists:keluhan',
            'tanggapan' => 'required|in:diterima,ditolak',
            'alasan' => 'required|min:24'
        ];
        
        $validator = Validator::make($input, $validationRules);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $acceptHeader = $request->header('Accept');
        $contentTypeHeader = $request->header('Content-Type');

        $tanggapan = new Tanggapan;
        $tanggapan->petugas_id = Auth::guard('admin')->user()->petugas_id;
        $tanggapan->keluhan_id = $request->input('keluhan_id');
        $tanggapan->tanggapan = $request->input('tanggapan');
        $tanggapan->alasan = $request->input('alasan');

        $keluhan = keluhan::find($request->input('keluhan_id'));

        if ($acceptHeader === 'application/json' || $contentTypeHeader === 'application/xml') {
            if ($contentTypeHeader === 'application/json' || $contentTypeHeader === 'application/xml') {
                // Response Accept : 'application/json'
                if ($acceptHeader === 'application/json' && $contentTypeHeader === 'application/json') {
                    $tanggapan->save();
                    $keluhan->delete();
                    return response()->json($tanggapan, 200);
                }  else if ($acceptHeader === 'appication/xml' && $contentTypeHeader === 'application/xml') {
                    $tanggapan->save();
                    $keluhan->delete();
                    $xml = new \SimpleXMLElement('<Tanggapan/>');

                    $xml->addChild('tanggapan_id', $tanggapan->tanggapan_id);
                    $xml->addChild('keluhan_id', $tanggapan->keluhan_id);
                    $xml->addChild('petugas_id', $tanggapan->petugas_id);
                    $xml->addChild('tanggapan', $tanggapan->tanggapan);
                    $xml->addChild('alasan', $tanggapan->alasan);
                    $xml->addChild('created_at', $tanggapan->created_at);
                    $xml->addChild('updated_at', $tanggapan->updated_at);

                    return $xml->asXML();
                } else {
                    return response('Not Acceptable!', 406);
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
            $tanggapan = Tanggapan::find($id);

            if (!$tanggapan) {
                abort(404);
            }
            
            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($tanggapan, 200);
            } 
            
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<Tanggapan/>');

                $xml->addChild('tanggapan_id', $tanggapan->tanggapan_id);
                $xml->addChild('keluhan_id', $tanggapan->keluhan_id);
                $xml->addChild('petugas_id', $tanggapan->petugas_id);
                $xml->addChild('tanggapan', $tanggapan->tanggapan);
                $xml->addChild('alasan', $tanggapan->alasan);
                $xml->addChild('created_at', $tanggapan->created_at);
                $xml->addChild('updated_at', $tanggapan->updated_at);

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
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ], 403);
        }

        $acceptHeader = $request->header('Accept');
        $contentTypeHeader = $request->header('Content-Type');

        $input = $request->all();

        $validationRules = [
            'keluhan_id' => 'required|exist:keluhan, keluhan_id',
            'petugas_id' => Auth::guard('admin')->user()->petugas_id,
            'tanggapan' => 'required|in:diterima, ditolak',
            'alasan' => 'required|min:24'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $tanggapan = Tanggapan::find($id);

            if (!$tanggapan) {
                abort(404);
            }
            
            $tanggapan->fill($input);
            $tanggapan->save();

            if ($acceptHeader === 'application/json') {
                if ($contentTypeHeader === 'application/json') {
                    return response()->json($tanggapan, 200);
                } else {
                    return response('Unsupported Media Type', 403);
                }
            } else if ($acceptHeader === 'application/xml') {
                if ($contentTypeHeader === 'application/xml') {
                    $xml = new \SimpleXMLElement('<Tanggapan/>');

                    $xml->addChild('tanggapan_id', $tanggapan->tanggapan_id);
                    $xml->addChild('keluhan_id', $tanggapan->keluhan_id);
                    $xml->addChild('petugas_id', $tanggapan->petugas_id);
                    $xml->addChild('tanggapan', $tanggapan->tanggapan);
                    $xml->addChild('alasan', $tanggapan->alasan);
                    $xml->addChild('created_at', $tanggapan->created_at);
                    $xml->addChild('updated_at', $tanggapan->updated_at);

                    return $xml->asXML();
                } else {
                    return response('Unsupported Media Type', 403);
                }
            } else {
                return response('Not Acceptable!', 406);
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
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ], 403);
        }

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $tanggapan = Tanggapan::find($id);

            if (!$tanggapan) {
                abort(404);
            }

            $tanggapan->delete();
            $response = [
                'message' => 'Deleted Successfully!',
                'petugas_id' => $id
            ];

            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($response, 200);
            } 
                
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<Petugas/>');

                $xml->addChild('message', 'Deleted Successfully!');
                $xml->addChild('petugas_id', $id);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
