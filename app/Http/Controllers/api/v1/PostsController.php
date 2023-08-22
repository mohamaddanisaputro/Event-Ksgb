<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
        $post = Post::latest()->get();
        return response([
            'success'=> true,
            'message'=> 'List semua data',
            'data'=> $posts
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ],
            [
                'title.required' => 'Masukkan Title Post !',
                'content.required' => 'Masukkan Content Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $post = Post::create([
                'title'     => $request->input('title'),
                'content'   => $request->input('content')
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
        }
    }

    public function show($id)
    {
        $post = Post::whereId($id)->first();


        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required'
        ],
            [
                'title.required' => 'Masukan Title yang ingin di update!',
                'content.required' => 'Masukan content yang ingin di update',
            ]
    );
        if($validator->fails() ){

            return response()->json([
                'success'=> false,
                'message'=> 'Silahkan bagian yang kosong !',
                'data' => $validator->errors()
            ], 401);
        }else{
            $post = Post::whereId($request->input('id'))->update([
                'title'=> $request->input('title'),
                'content'=> $request->input('content'),
            ]);
            if ($post) {
                return response ()->json([
                    'success'=> true,
                    'message'=> 'Data berhasil di update! ',
                    
                ], 200);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=> 'Data gagal di update!',

                ], 401);
            }
        }
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();

            if($post){
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