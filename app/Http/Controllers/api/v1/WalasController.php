<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Walas;
use Illuminate\Support\Facades\Validator;

class WalasController extends Controller
{
    public function index()
    {
        $walas = Walas::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Walas',
            'data' => $walas
        ], 200);
    }

    //function store
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'kelas'   => 'required',
        ],
            [
                'nama.required' => 'Masukkan Nama Walas !',
                'kelas.required' => 'Masukkan Kelas !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $walas = Walas::create([
                'nama'     => $request->input('nama'),
                'kelas'   => $request->input('kelas')
            ]);

            if ($walas) {
                return response()->json([
                    'success' => true,
                    'message' => 'Walas Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Walas Gagal Disimpan!',
                ], 401);
            }
        }
    }
    public function show($id)
    {
        $walas = Walas::whereId($id)->first();


        if ($walas) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Walas ID '.$id,
                'data'    => $walas
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Walas Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }
    }


}
