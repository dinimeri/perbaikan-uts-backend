<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index() {
        // menampilkan data patients dari database
        $patients = Patient::all();
        // menghitung jumlah data pada tabel patient
        $jumlah = count($patients);
        // jika data ada, maka data akan ditampilkan
        if ($jumlah) {
            $data = [
                'message' => 'Get all patients',
                'data' => $patients
            ];
            // mengirim data (json) dan kode 200
            return response()->json($data, 200);
        // jika data tidak ada, maka akan menampilkan pesan 'Data is empty'
        }else {
            $data = [
                'message' => 'Data is empty'
            ];
            // mengirim data (json) dan kode 200
            return response()->json($data, 404);
        }
    }

    public function store(Request $request) {
        // membuat validation
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:10|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'date'
        ]);

        // menggunakan model Patient untuk insert data
        $patient = Patient::create($validated);

        $data = [
            'message' => 'Resource is added succesfully',
            'data' => $patient
        ];
        // mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    public function show($id) {
        $patient = Patient::find($id);

        if ($patient) {
            $data = [
                'message' => 'Get detail resource',
                'data' => $patient
            ];
            // jika resource ada, maka mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else {
            $data = [
                'message' => 'Resource not found'
            ];
            // jika resource tidak ada, maka mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    public function update(Request $request, $id) {
        $patient = Patient::find($id);

        if ($patient) {
            // menangkap data request
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];
            // update data
            $patient->update($input);

            $data = [
                'message' => 'Resource is updated successfully',
                'data' => $patient
            ];
            // jika resource ada, maka akan mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else {
            $data = [
                'message' => 'Resource not found'
            ];
            // jika resource tidak ada, maka akan mengembalikan kode 404
            return response()->json($data, 404);
        }
    }
    public function destroy($id) {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();

            $data = [
                'message' => 'Resource is deleted successfully'
            ];
            // jika resource ada, maka data akan dihapus dan mengembalikan kode 200
            return response()->json($data, 200);

        }else {
            $data = [
                'message' => 'Resource not found'
            ];

            // jika resource tidak ada, maka akan mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    // membuat method search
    public function search($name) {
        // mencari resource patient berdasarkan nama
        $patient = Patient::where('name', 'like', '%'.$name.'%')->get();
        // menghitung jumlah pasien
        $jumlah = count($patient);
        if ($jumlah) {
            $data = [
                'message' => 'Get searched resource',
                'data' => $patient
            ];

            // jika resource ditemukan, maka akan mengembalikan data (json) dan kode 200
            return response()->json($data, 200);

        }else {
            $data = [
                'message' => 'Resource not found'
            ];
            // jika resource tidak ditemukan, maka akan mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    // membuat method positive
    public function positive() {
        // mencari resource patient berdasarkan status yang positive
        $patient = Patient::where('status', 'positive')->get();
        // menghitung jumlah pasien
        $jumlah = count($patient);
        $data = [
            'message' => 'Get positive resource',
            'total' => $jumlah,
            'data' => $patient
        ];
        // mengembalikan data(json) dan kode 200
        return response()->json($data, 200);
    }

    // membuat method recovered
    public function recovered() {
        // mencari resource patient berdasarkan status yang recovered
        $patient = Patient::where('status', 'recovered')->get();
        // menghitung jumlah pasien
        $jumlah = count($patient);
        $data = [
            'message' => 'Get recovered resource',
            'total' => $jumlah,
            'data' => $patient
        ];
        // mengembalikan data(json) dan kode 200
        return response()->json($data, 200);
    }

    // membuat method dead
    public function dead() {
        // mencari resource patient berdasarkan status yang dead
        $patient = Patient::where('status', 'dead')->get();
        // menghitung jumlah pasien
        $jumlah = count($patient);
        $data = [
            'message' => 'Get dead resource',
            'total' => $jumlah,
            'data' => $patient
        ];
        // mengembalikan data(json) dan kode 200
        return response()->json($data, 200);
    }
}
