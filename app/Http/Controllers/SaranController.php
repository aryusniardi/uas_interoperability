<?php
namespace App\Http\Controllers;

use App\Models\Saran;
//use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SaranController extends Controller {
	public function store(Request $request){
		$acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $contentTypeHeader = $request->header('Content-Type');
                $input = $request->all();

                /*
				protected $fillable = array ('user_id', 'jenis_saran', 'lokasi_sarab', 'isi_saran');
                */

                $validationRules = [
                    //'user_id' => 'required',
                    'jenis_saran' => 'required|in:pelayanan,infrastruktur',
                    'lokasi_saran' => 'required',
                    'isi_saran' => 'required',
                ];

                $validator = Validator::make($input, $validationRules)
                ;

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $saran = new Saran;
                $saran->user_id = Auth::guard('user')->user()->user_id;
                $saran->jenis_saran = $request->input('jenis_saran');
                $saran->lokasi_saran = $request->input('lokasi_saran');
                $saran->isi_saran = $request->input('isi_saran');
                $saran->save();

                return response()->json($saran, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
	}

	public function index(Request $request){
		$acceptHeader = $request->header('Accept');

         if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $id = Auth::guard('user')->user()->user_id;

            $saran = Saran::where("user_id", $id)->paginate(4)->toArray();

            if (!$saran) {
                abort(404);
            }

            $response = [
                "total_count" => $saran["total"],
                "limit" => $saran["per_page"],
                "pagination" => [
                    "next_page" => $saran["next_page_url"],
                    "current_page" => $saran["current_page"]
                ],
                "data" => $saran["data"],
            ];
            
            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($response, 200);
            }
            /*
				protected $fillable = array ('user_id', 'jenis_saran', 'lokasi_sarab', 'isi_saran');
                */
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<Data_Saran/>');

                $xml->addChild('total_count', $saran['total']);
                $xml->addChild('limit', $saran['per_page']);
                $pagination = $xml->addChild('pagination');
                $pagination->addChild('next_page', $saran['next_page_url']);
                $pagination->addChild('current_page', $saran['current_page']);
                $xml->addChild('total_count', $saran['total']);

                foreach ($saran['data'] as $item) {
                    $xmlItem = $xml->addChild('saran');

                    $xmlItem->addChild('saran_id', $item['saran_id']);
                    $xmlItem->addChild('user_id', $item['user_id']);
                    $xmlItem->addChild('jenis_saran', $item['jenis_saran']);
                    $xmlItem->addChild('lokasi_saran', $item['lokasi_saran']);
                    $xmlItem->addChild('isi_saran', $item['isi_saran']);
                    $xmlItem->addChild('created_at', $item['created_at']);
                    $xmlItem->addChild('updated_at', $item['updated_at']);
                }

                return $xml->asXML();
            } 
        } else {
            return response('Not Acceptable!', 406);
        }
	}

	public function show(Request $request, $id){
		$acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $saran = Saran::find($id);

            if (!$saran) {
                abort(404);
            }
            
            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($saran, 200);
            } 
            
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<saran/>');

                $xml->addChild('saran_id', $saran->keluhan_id);
                $xml->addChild('user_id', $saran->user_id);
                $xml->addChild('jenis_saran', $saran->jenis_saran);
                $xml->addChild('lokasi_saran', $saran->lokasi_saran);
                $xml->addChild('isi_saran', $saran->isi_saran);
                $xml->addChild('created_at', $saran->created_at);
                $xml->addChild('updated_at', $saran->updated_at);

                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
	}

	public function destroy(Request $request, $id){
		$acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $saran = Saran::find($id);

            if (!$saran) {
                abort(404);
            }
            
            $saran->delete();
            $response = [
                'message' => 'Deleted Successfully!',
                'user_id' => $id
            ];

            // Response Accept : 'application/json'
            if ($acceptHeader === 'application/json') {
                return response()->json($saran, 200);
            } 
            
            // Response Accept : 'application/xml'
            else {
                $xml = new \SimpleXMLElement('<saran/>');

                $xml->addChild('message', 'Deleted Successfully!');
                $xml->addChild('petugas_id', $id);

                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
	}
}
?>