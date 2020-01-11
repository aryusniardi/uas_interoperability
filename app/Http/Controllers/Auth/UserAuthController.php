<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller {
        /**
         * Store a new Petugas
         * 
         * @param Request $request
         * @return Response
         */
        public function register(Request $request) {
            // Validation
            $this->validate($request, [
                'nama' => 'required|string|min:5',
                'email' => 'required|email|unique:petugas',
                'password' => 'required|confirmed|min:6',
            ]);

            $input = $request->all();

            // Validation Starts
            $validationRules = [
                'nama' => 'required|string|min:5',
                'email' => 'required|email|unique:petugas',
                'password' => 'required|confirmed|min:6',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            } 
            // Validation Ends

            // Create new Petugas
            $user = new User;
            $user->nama = $request->input('nama');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            return response()->json($user, 200);
        }

        /**
         * Get a JWT via given credentials.
         * 
         * @param Request $request
         * @return Response
         */
        public function login(Request $request) {
            $input = $request->all();

            // Validation Rules
            $validationRules = [
                'email' => 'required|email',
                'password' => 'required|string|min:6'  
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Login Process
            $credentials = $request->only(['email', 'password']);
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            return response()->json([
                'token' => $token,
                'token_type' => 'bearier',
                'expires_in' => Auth::factory('user')->getTTL() * 60
            ], 200);
        }
    }
