<?php

namespace App\Http\Controllers;

use App\Peminjaman_buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PeminjamanBukuController extends Controller
{
    public function show(){
        $data = DB::table('Peminjaman_buku')
        ->join('Siswa','Peminjaman_buku.id_siswa','=', 'Siswa.id')
        ->select('Peminjaman_buku.id_peminjaman_buku','Peminjaman_buku.tanggal_pinjam','Peminjaman_buku.tanggal_kembali','Siswa.id')
        ->get();
        return Response()->json($data);
    }
    public function detail($id){
        if(Peminjaman_buku::where('id_peminjaman_buku', $id)->exists()){
            $data_pinjam = DB::table('Peminjaman_buku')
            ->join('Siswa','Peminjaman_buku.id_siswa','=', 'Siswa.id')
            ->select('Peminjaman_buku.id_peminjaman_buku','Peminjaman_buku.tanggal_pinjam','Peminjaman_buku.tanggal_kembali','Siswa.id')
            ->where('Peminjaman_buku.id_peminjaman_buku', '=', $id)
            ->get();
            return Response()->json($data_pinjam);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            ['id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required']
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Peminjaman_buku::create([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
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
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Peminjaman_Buku::where('id_peminjaman_buku', $id)->update([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id){
        $hapus = Peminjaman_Buku::where('id_peminjaman_buku', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
