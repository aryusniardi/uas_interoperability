<?php
    namespace App\Http\Controllers;

    use App\Models\Petugas;

    class PetugasController extends Controller {
        public function index() {
            $petugas = Petugas::OrderBy("id_petugas", "DESC")->paginate(10);

            $output = [
                "message" => "petugas",
                "results" => $petugas
            ];

            return response()->json($petugas, 200);
        }
    }
?>