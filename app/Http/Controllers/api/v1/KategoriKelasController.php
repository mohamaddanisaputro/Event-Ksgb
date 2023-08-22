<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\KategoriKelas;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class KategoriKelasController extends Controller
{

    public function index()
    {
        $kategorikelas = KategoriKelas::latest()->get();
        return response([
            'success'=>true,
            'message'=>'List semua kategori kelas',
            'data'=> $kategorikelas
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_peserta'=> 'required',
            'jenis_kategori_kelas'=> 'required',
            
        ],
        [
            'id_peserta.required'=> 'Masukan id_peserta',
            'jenis_kategori_kelas.required'=> 'Masukan jenis_kategori_kelas',
            
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> 'silahkan isi data yang kosong',
                'data'=> $validator->errors()
            ], 401 );
        }else {
            $kategorikelas = KategoriKelas::create([
                'id_peserta'=> $request->input('id_peserta'),
                'jenis_kategori_kelas'=> $request->input('jenis_kategori_kelas'),
               
            ]);

            if ($kategorikelas){
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
        $kategorikelas = KategoriKelas::whereId($id)->first();


        if ($kategorikelas) {
            return response()->json([
                'success' => true,
                'message' => 'Detail kategorikelas!',
                'data'    => $kategorikelas
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'kategorikelas Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }
    }

    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'id_peserta'     => 'required',
            'jenis_kategori_kelas'   => 'required',
            
        ],
            [
                'id_peserta.required' => 'Masukkan id_peserta peserta !',
                'jenis_kategori_kelas.required' => 'Masukkan jenis_kategori_kelas peserta !',
                
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $kategorikelas = KategoriKelas::whereId($request->input('id'))->update([
                'id_peserta'     => $request->input('id_peserta'),
                'jenis_kategori_kelas'   => $request->input('jenis_kategori_kelas'),
                
            ]);

            if ($kategorikelas) {
                return response()->json([
                    'success' => true,
                    'message' => 'kategorikelas Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'kategorikelas Gagal Diupdate!',
                ], 401);
            }

        }

    }
    public function destroy($id){
        $kategorikelas = KategoriKelas::findOrFail($id);
        $kategorikelas->delete();

            if($kategorikelas){
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
