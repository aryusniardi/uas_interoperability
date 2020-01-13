<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleXMLElement;

class UserController extends Controller {
	/**
    * Store a newly created resource in storage
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
	public function index(Request $request){
		$acceptHeader = $request->header('Accept');

		if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
			$user = User::OrderBy("user_id","DESC")->paginate(2);
			if ($acceptHeader === 'application/json') {
                // response json
                return response()->json($user->items('data'), 200);
            }
            else {
                $xml = new \SimpleXMLElement('<User/>');
                foreach ($user->items('data') as $item) {
                    $xmlItem = $xml->addChild('user');

                    $xmlItem->addChild('user_id', $item->user_id);
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

	/**
	* Store a newly created resource in storage
	* 
	* @param \Illuminate\Http\Request $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request){
		$acceptHeader = $request->header('accept');
		// Hanya memvalidasi application/json atau application/xml
		if ($acceptHeader === 'application/json') {
			$contentTypeHeader = $request->header('Content-Type');
			// Hanya application/json yang valid
			if ($contentTypeHeader === 'application/json') {
				$input = $request->all();
				
				$user = User::create($input);

				return response()->json($user, 200);
			} else {
				return response('Unsupported Media Type', 403);
			}
		} else if ($acceptHeader === 'application/xml') {
			$contentTypeHeader = $request->header('Content-Type');
			// Hanya application/xml yang valid
			if ($contentTypeHeader === 'application/xml') {
				$input = $request->all();

				$user = User::create($input);

				// Response XML
				// Create XML User Element
				$xml = new \SimpleXMLElement('<User/>');
				// Changing every field user to XML Format
				$xml->AddChild('user_id', $user->user_id);
				$xml->AddChild('nik', $user->nik);
				$xml->AddChild('nama', $user->nama);
				$xml->AddChild('email', $user->email);
				$xml->AddChild('password', $user->password);
				$xml->AddChild('created_at', $user->created_at);
				$xml->AddChild('updated_at', $user->updated_at);
				
				return $xml->asXML();
			} else {
				return response('Unsupported Media Type', 403);
			}
		} else {
			return response('Not Acceptable!', 406);
		}
	}

	/**
	* Display the specified resource
	* 
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	public function show(Request $request, $id){
		$acceptHeader = $request->header('Accept');

		// Validasi hanya application/json atau application/xml
		$user = User::Find($id);
		if ($acceptHeader === 'application/json') {
			// Response JSON
			return response()->json($user, 200);			
		} else if ($acceptHeader === 'application/xml') {
			// Response XML
			$xml = new \SimpleXMLElement('<post/>');

			$xml->addChild('user_id', $user->user_id);
			$xml->AddChild('nik', $user->nik);
			$xml->AddChild('nama', $user->nama);
			$xml->AddChild('email', $user->email);
			$xml->AddChild('password', $user->password);
			$xml->AddChild('created_at', $user->created_at);
			$xml->AddChild('updated_at', $user->updated_at);

            return $xml->asXML();
		} else {
			return response('Not Acceptable!', 406);
		}
	}

	/**
	* Update the specified resource in storage
	* 
	* @param \Illuminate\Http\Request $request
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id){
		$acceptHeader = $request->hedaer('Accept');
		$input = $request->all();

		$user = User::find($id);

		if (!$user) {
			abort(404);
		}

		// Validasi hanya application/json atau application/xml
		if ($acceptHeader === 'application/json') {
			// Hanya memvalidasi application/json
			$contentTypeHeader = $request->header('Content-Type');
			if ($contentTypeHeader === 'application/json') {
				$user->fill($input);
				$user->save();
		
				return response()->json($user,200);
			} else {
				return response('Unsupported Media Type', 403);
			}
		} else if ($acceptHeader === 'application/xml') {
			// Hanya memvalidasi applicaion/xml
			$contentTypeHeader = $request->header('Content-Type');
			if ($contentTypeHeader === 'application/json') {
				$input = $request->all();

				$user->fill($input);
				$user->save();

				$xml = new \SimpleXMLElement('<User/>');
				// Changing every field User to XML Format

				$xml->addChild('user_id', $user->user_id);
				$xml->AddChild('nik', $user->nik);
				$xml->AddChild('nama', $user->nama);
				$xml->AddChild('email', $user->email);
				$xml->AddChild('password', $user->password);
				$xml->AddChild('created_at', $user->created_at);
				$xml->AddChild('updated_at', $user->updated_at);

				return $xml->asXML();
			} else {
				return response('Unsupported Media Type', 403);
			}
		} else {
			return response('Not Acceptable!', 406);
		}
	}

	/**
	* Remove the specified resource from storage
	* 
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Request $request, $id){
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