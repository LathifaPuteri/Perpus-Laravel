<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Peminjaman_buku;
use App\Detail_peminjaman_buku;
use App\Pengembalian_buku;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class transaksiController extends Controller
{
    public function pinjamBuku(Request $req){
        $validator = Validator::make($req->all(),[
            'id_siswa'=>'required',
            'tanggal_pinjam'=>'required',
            'tanggal_kembali'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = Peminjaman_buku::create([
            'id_siswa'=>$req->id_siswa,
            'tanggal_pinjam'=>$req->tanggal_pinjam,
            'tanggal_kembali'=>$req->tanggal_kembali,
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }

    public function tambahItem(Request $req, $id){
        $validator = Validator::make ($req->all(),[
            'id_buku'=>'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = Detail_peminjaman_buku::create([
            'id_peminjaman_buku'=>$id,
            'id_buku'=>$req->id_buku,
            'qty'=>$req->qty,
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }

    public function mengembalikanBuku(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'id_peminjaman_buku'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $cek_kembali=PEngambalian_buku::where('id_peminjaman_buku',$req->id_peminjaman_buku);
        if($cek_kembali->count() == 0){
            $dt_kembali = peminjamanBukuModel::where('id',$req->id_peminjaman_buku)->first();
            $tanggal_sekarang = Carbon::now()->format('Y-m-d');
            $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
            $dendaperhari = 1500;
            if(strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)){
                $jumlah_hari = $tanggal_kembali->diff($tanggal_sekarang)->days;
                $denda = $jumlah_hari*$dendaperhari;
            }else {
                $denda = 0;
            }
            $save = Pengembalian_buku::create([
                'id_peminjaman_buku'    => $req->id_peminjaman_buku,
                'tanggal_pengembalian'  => $tanggal_sekarang,
                'denda'                 => $denda,
            ]);
            if($save){
                $data['status'] = 1;
                $data['message'] = 'Berhasil dikembalikan';
            } else {
                $data['status'] = 0;
                $data['message'] = 'Pengembalian gagal';
            }
        } else {
            $data = ['status'=>0,'message'=>'Sudah pernah dikembalikan'];
        }
        return response()->json($data);
    }
}
