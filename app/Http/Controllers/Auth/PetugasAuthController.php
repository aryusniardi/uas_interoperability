<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Petugas;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule as Rule;
    use Illuminate\Support\Facades\Auth;
    
class PetugasAuthController extends Controller {
        /**
         * Store a new Petugas
         * 
         * @param Request $request
         * @return Response
         */
        public function register(Request $request) {
            // Validation
            $this->validate($request, [
                'email' => 'required|email|unique:petugas',
                'password' => 'required|confirmed|min:6',
                'role' => ['required',  Rule::in(['admin', 'super admin'])]
            ]);

            $input = $request->all();
            $acceptHeader = $request->header('Accept');
            // Validation Starts
            $validationRules = [
                'email' => 'required|email|unique:petugas',
                'password' => 'required|confirmed|min:6',
                'role' => ['required',  Rule::in(['admin', 'super admin'])]
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            } 
            // Validation Ends

            // Create new Petugas
            $petugas = new Petugas;
            $petugas->email = $request->input('email');
            $plainPassword = $request->input('password');
            $petugas->password = app('hash')->make($plainPassword);
            $petugas->role = $request->input('role');

            
            if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
                $petugas->save();

                // Response Accept : 'application/json'
                if ($acceptHeader === 'application/json') {
                    return response()->json($petugas, 200);
                    
                } 
                
                // Response Accept : 'application/xml'
                else {
                    $xml = new \SimpleXMLElement('<Petugas/>');

                    $xml->addChild('email', $petugas->email);
                    $xml->addChild('password', $petugas->password);
                    $xml->addChild('role', $petugas->role);

                    return $xml->asXML();
                }
            } else {
                return response('Not Acceptable!', 403);
            }
        }

        /**
         * Get a JWT via given credentials.
         * 
         * @param Request $request
         * @return Response
         */
        public function login(Request $request) {
            $acceptHeader = $request->header('Accept');
            $input = $request->all();

            // Validation Rules
            $validationRules = [
                'email' => 'required|email',
                'password' => 'required|min:6|string'  
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
                $credentials = $request->only(['email', 'password']);
                if (!$token = Auth::guard('admin')->attempt($credentials)) {
                    return response()->json(['message' => 'Unauthorized'], 401);
                }

                $response = [
                    'token' => $token,
                    'token_type' => 'bearier',
                    'expires_in' => Auth::factory('admin')->getTTL() * 60
                ];

                // Response Accept : 'application/json'
                if ($acceptHeader === 'application/json') {
                    return response()->json($response, 200);
                } 
                
                // Response Accept : 'application/xml'
                else {
                    $xml = new \SimpleXMLElement('<Response/>');

                    $xml->addChild('token', $response['token']);
                    $xml->addChild('token_type', $response['token_type']);
                    $xml->addChild('expires_in', $response['expires_in']);

                    return $xml->asXML();
                }
            } else {
                return response('Not Acceptable!', 403);
            }
            // Login Process
        }

        /**
         * Logout.
         */
        public function logout(Request $request) {
            $acceptHeader = $request->header('Accept');
            if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
                $response = [
                    'status' => 'success',
                    'message' => 'logout'
                ];

                // Response Accept : 'application/json'
                if ($acceptHeader === 'application/json') {
                    Auth::guard('admin')->logout();

                    return response()->json($response, 200);
                } 
                
                // Response Accept : 'application/xml'
                else {
                    Auth::guard('admin')->logout();

                    $xml = new \SimpleXMLElement('<Response/>');

                    $xml->addChild('status', $response['status']);
                    $xml->addChild('message', $response['message']);

                    return $xml->asXML();
                }
            } else {
                return response('Not Acceptable!', 403);
            }
        }
    }
?>