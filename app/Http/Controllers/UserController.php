<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
	public function index(Request $request){
		$acceptHeader = $request->header('Accept');

		if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
			$user = User::OrderBy("id","DESC")->paginate(2);
			if ($acceptHeader === 'application/json') {
                // response json
                return response()->json($user->items('data'), 200);
            }
            else {
                $xml = new \SimpleXMLElement('<user/>');
                foreach ($user->items('data') as $item) {
                    $xmlItem = $xml->addChild('user');

                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('nik', $item->nik);
                    $xmlItem->addChild('nama', $item->nama);
                    $xmlItem->addChild('email', $item->email);
                    $xmlItem->addChild('password', $item->password);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }

		}
		else {
			return response('not acceptable!', 406);
		}
	}

	public function store(Request $request){
		$input = $request->all();
		$user = User::create($input);

		return response()->json($user, 200);
	}

	public function show($id){
		$user = User::find($id);

		if (!$user) {
			abort(404);
		}

		return response()->json($user, 200);
	}

	public function update(Request $request, $id){
		$input = $request->all();

		$user = User::find($id);

		if (!$user) {
			abort(404);
		}
		$user->fill($input);
		$user->save();

		return response()->json($user,200);
	}

	public function destroy($id){
		$user = User::find($id);

		if (!$user) {
			abort(404);
		}
		$user->delete();
		$message = ['message' => 'berhasil dihapus', 'id' => $id];

		return response()->json($message,200);
	}
}
?>