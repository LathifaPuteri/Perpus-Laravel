<?php

namespace App\Http\Controllers;

use App\Pengembalian_buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PengembalianBukuController extends Controller
{
    public function show(){
        return Pengembalian_buku::all();
    }
    public function detail($id){
        if(Pengembalian_buku::where('id_pengembalian_buku', $id)->exists()){
            $data_balik = DB::table('Pengembalian_buku')
            ->join('Peminjaman_buku','Pengembalian_buku.id_peminjaman_buku','=', 'Peminjaman_buku.id_peminjaman_buku')
            ->select('Pengembalian_buku.id_pengembalian_buku','Peminjaman_buku.id_peminjaman_buku','Pengembalian_buku.tanggal_pengembalian','Pengembalian_buku.denda')
            ->where('Pengembalian_buku.id_pengembalian_buku', '=', $id)
            ->get();
            return Response()->json($data_balik);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'id_peminjaman_buku' => 'required',
            'tanggal_pengembalian' => 'required',
            'denda' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Pengembalian_buku::create([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'denda' => $request->denda
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
            'id_peminjaman_buku' => 'required',
            'tanggal_pengembalian' => 'required',
            'denda' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Pengembalian_Buku::where('id_pengembalian_buku', $id)->update([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'denda' => $request->denda
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id){
        $hapus = Pengembalian_Buku::where('id_pengembalian_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
