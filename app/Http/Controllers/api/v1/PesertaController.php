<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Peserta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PesertaController extends Controller
{


    public function index()
    {
        $peserta = Peserta::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Posts',
            'data' => $peserta
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'=> 'required',
            'nama_lengkap'=> 'required',
            'usia'=> 'required',
            'jenis_kelamin'=> 'required',
            'asal_kota'=> 'required',
        ],
        [
            'username.required'=> 'Masukan username',
            'nama_lengkap.required'=> 'Masukan nama_lengkap',
            'usia.required'=> 'Masukan usia',
            'jenis_kelamin.required'=> 'Masukan jenis_kelamin',
            'asal_kota.required'=> 'Masukan asal_kota',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> 'silahkan isi data yang kosong',
                'data'=> $validator->errors()
            ], 401 );
        }else {
            $peserta = Peserta::create([
                'username'=> $request->input('username'),
                'nama_lengkap'=> $request->input('nama_lengkap'),
                'usia'=> $request->input('usia'),
                'jenis_kelamin'=> $request->input('jenis_kelamin'),
                'asal_kota'=> $request->input('asal_kota')
            ]);

            if ($peserta){
                return response()->json([
                    'success'=>true,
                    'message'=> 'Data berhasil di tambah'
                ],200 );
            } else {
                return response()->json([
                    'success'=>false,
                    'message'=>'Data gagal di tambah',
                ],401);
            }
        }
       
    }
    public function show($id)
    {
        $peserta = Peserta::whereId($id)->first();


        if ($peserta) {
            return response()->json([
                'success' => true,
                'message' => 'Detail peserta!',
                'data'    => $peserta
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'peserta Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }
    }
    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'nama_lengkap'   => 'required',
            'usia'   => 'required',
            'jenis_kelamin'   => 'required',
            'asal_kota'   => 'required',
        ],
            [
                'username.required' => 'Masukkan username peserta !',
                'nama_lengkap.required' => 'Masukkan nama_lengkap peserta !',
                'usia.required' => 'Masukkan usia peserta !',
                'jenis_kelamin.required' => 'Masukkan usia peserta !',
                'asal_kota.required' => 'Masukkan usia peserta !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $peserta = Peserta::whereId($request->input('id'))->update([
                'username'     => $request->input('username'),
                'nama_lengkap'   => $request->input('nama_lengkap'),
                'usia'   => $request->input('nama_lengkap'),
                'jenis_kelamin'   => $request->input('nama_lengkap'),
                'asal_kota'   => $request->input('nama_lengkap'),
            ]);

            if ($peserta) {
                return response()->json([
                    'success' => true,
                    'message' => 'peserta Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'peserta Gagal Diupdate!',
                ], 401);
            }

        }

    }
    public function destroy($id){
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

            if($peserta){
                return response()->json([
                    'success'=>true,
                    'message'=> 'Data berhasil dihapus!',
                ], 200);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=> 'Data gagal dihapus !',
                ], 400);
            }
    }
}