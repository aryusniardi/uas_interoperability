<?php
namespace App\Http\Controllers;

use App\Models\Keluhan;
//use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class KeluhanController extends Controller {
	public function store(Request $request){
        /*if (Gate::denies('user')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ], 403);
        }*/

		$acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $contentTypeHeader = $request->header('Content-Type');
                $input = $request->all();

                $validationRules = [
                    'user_id' => 'required',
                    'jenis_keluhan' => 'required|in:pelayanan,infrastruktur',
                    'lokasi_keluhan' => 'required',
                    'foto_keluhan' => 'required',
                    'isi_keluhan' => 'required',
                ];

                $validator = Validator::make($input, $validationRules)
                ;

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }
                /*
                $keluhan = Keluhan::create($input);

                return response()->json($keluhan, 200);*/
                $keluhan = new Keluhan;
                $keluhan->user_id = Auth::user()->petugas_id;
                $keluhan->jenis_keluhan = $request->input('jenis_keluhan');
                $keluhan->lokasi_keluhan = $request->input('lokasi_keluhan');
                $keluhan->foto_keluhan = $request->input('foto_keluhan');
                $keluhan->isi_keluhan = $request->input('isi_keluhan');
                $keluhan->save();
                return response()->json($keluhan, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
	}
}
?>