<?php

namespace App\Http\Controllers;

use App\Detail_peminjaman_buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailPeminjamanBukuController extends Controller
{
    public function show(){
        return Detail_peminjaman_buku::all();
    }
    public function detail($id){
        if(Detail_peminjaman_buku::where('id_detail_peminjaman_buku', $id)->exists()){
            $data_detail = DB::table('Detail_peminjaman_buku')
            ->join('Peminjaman_buku', 'Detail_peminjaman_buku.id_peminjaman_buku', '=' , 'peminjaman_buku.id_peminjaman_buku')
            ->join('Buku', 'Detail_peminjaman_buku.id_buku', '=' , 'Buku.id_buku')
            ->select('Peminjaman_buku.id_peminjaman_buku', 'Peminjaman_buku.tanggal_pinjam', 'Peminjaman_buku.id_siswa',
             'Buku.id_buku', 'Buku.nama_buku', 'Detail_peminjaman_buku.qty', 'Peminjaman_buku.tanggal_kembali')
            ->where('Detail_peminjaman_buku.id_detail_peminjaman_buku', '=', $id)
            ->get();
            return Response()->json($data_detail);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'id_peminjaman_buku' => 'required',
            'id_buku' => 'required',
            'qty' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Detail_peminjaman_buku::create([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'id_buku' => $request->id_buku,
            'qty' => $request->qty
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
            'id_buku' => 'required',
            'qty' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Detail_peminjaman_buku::where('id_detail_peminjaman_buku', $id)->update([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'id_buku' => $request->id_buku,
            'qty' => $request->qty
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id){
        $hapus = Detail_peminjaman_buku::where('id_detail_peminjaman_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
