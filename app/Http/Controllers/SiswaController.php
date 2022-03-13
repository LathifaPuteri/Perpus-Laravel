<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function show(){
        return Siswa::all();
    }
    public function detail($id) {
        if(Siswa::where('id', $id)->exists()) {
            $data = DB::table('Siswa')->where('Siswa.id','=', $id)->get();
            return Response()->json($data);
        }
        else {
            return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }
    public function store(Request $request) {
        $validator=Validator::make($request->all(),
            [
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
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
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $ubah = Siswa::where('id', $id)->update([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
        ]);
        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy($id){
        $hapus = Siswa::where('id', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
