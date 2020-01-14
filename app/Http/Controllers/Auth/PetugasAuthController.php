<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Petugas;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule as Rule;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

class PetugasAuthController extends Controller {
        /**
         * Store a new Petugas
         * 
         * @param Request $request
         * @return Response
         */
        public function register(Request $request) {
            if (Gate::denies('admin')) {
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'You are Unauthorized'
                ], 403);
            }

            // Validation
            $this->validate($request, [
                'email' => 'required|email|unique:petugas',
                'password' => 'required|confirmed|min:6',
                'role' => ['required',  Rule::in(['admin', 'super admin'])]
            ]);

            $input = $request->all();

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

            $petugas->save();

            return response()->json($petugas, 200);
        }

        /**
         * Get a JWT via given credentials.
         * 
         * @param Request $request
         * @return Response
         */
        public function login(Request $request) {
            if (Gate::denies('admin')) {
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'You are Unauthorized'
                ], 403);
            }
            
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

            // Login Process
            $credentials = $request->only(['email', 'password']);
            if (!$token = Auth::guard('admin')->attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            return response()->json([
                'token' => $token,
                'token_type' => 'bearier',
                'expires_in' => Auth::factory('admin')->getTTL() * 60
            ], 200);
        }
    }
?>