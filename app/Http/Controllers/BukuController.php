<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function show(){
        return Buku::all();
    }
    public function detail($id) {
        if(Buku::where('id_buku', $id)->exists()) {
            $data = DB::table('Buku')->where('Buku.id_buku','=', $id)->get();
            return Response()->json($data);
        }
        else {
            return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            ['nama_buku' => 'required',
            'pengarang' => 'required',
            'deskripsi' => 'required']
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Buku::create([
            'nama_buku' => $request->nama_buku,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi
        ]);
        if($simpan)
        {
            return Response()->json(['status' => 1]);
        }
        else
        {
            return Response()->json(['status' => 0]);
        }
    }
    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [
            'nama_buku' => 'required',
            'pengarang' => 'required',
            'deskripsi' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Buku::where('id_buku', $id)->update([
            'nama_buku' => $request->nama_buku,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id){
        $hapus = Buku::where('id_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
