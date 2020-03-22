<?php

namespace App\Http\Controllers;

use App\Tarif;
use App\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PelangganController extends Controller
{

    public function index()
    {
    	try{
	        $data["count"] = Pelanggan::count();
	        $pelanggan = array();
	        $dataPelanggan = DB::table('pelanggan')->join('tarif','tarif.id','=','pelanggan.id_tarif')
                                               ->select('pelanggan.id', 'tarif.daya','tarif.tarifperkwh','pelanggan.id_tarif')
	                                           ->get();

	        foreach ($dataPelanggan as $p) {
	            $item = [
	              "id"          		=> $p->id,
                  "id_tarif"            => $p->id_tarif,
	              "daya"  		        => $p->daya,
	              "tarifperkwh"  		=> $p->tarifperkwh,
                  "username"            => $p->username,
	              "password"            => $p->password,
                  "nomor_kwh"  		    => $p->nomor_kwh,
                  "nomor_telp"          => $p->nomor_telp,
	              "nama_pelanggan"      => $p->nama_pelanggan,
                  "alamat"              => $p->alamat,
	               			   
	            ];

	            array_push($poin, $item);
	        }
	        $data["poin"] = $poin;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }
    
    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Pelanggan::count();
        $pelanggan = array();

        foreach (Pelanggan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_pelanggan"    => $p->id,
                "nama_pelanggan"  => $p->nama_pelanggan,
                "email"     	  => $p->email,
                "password"        => $p->password,
                "nomor_telp"      => $p->nomor_telp,
                "nomor_kwh"       => $p->nomor_kwh,
                "alamat"          => $p->alamat,
                "id_tarif"        => $p->id_tarif,
                "created_at"      => $p->created_at,
                "updated_at"      => $p->updated_at
            ];

            array_push($pelanggan, $item);
        }
        $data["pelanggan"] = $pelanggan;
        $data["status"] = 1;
        return response($data);
    }

    public function show($id) 
    {
        $data = Pelanggan::where('id',$id)->get();
        return response ($data);
    }

    public function delete($id)
    {
        try{

            Pelanggan::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }

    
	public function ubah(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama_pelanggan' => 'required|string|max:255',
			'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
            'nomor_telp' => 'required|string|max:255',
            'nomor_kwh' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'id_tarif' => 'required|string|max:255',

		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$pelanggan = Pelanggan::where('id', $request->id)->first();
		$pelanggan->nama_pelanggan 	= $request->nama_pelanggan;
		$pelanggan->email       	= $request->email;
        $pelanggan->password        = Hash::make($request->password);
        $pelanggan->nomor_telp  	= $request->nomor_telp;
        $pelanggan->nomor_kwh   	= $request->nomor_kwh;
        $pelanggan->alamat 	        = $request->alamat;
        $pelanggan->id_tarif    	= $request->id_tarif;
        $pelanggan->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil diubah'
		], 201);
    }
    
    public function store(Request $request) {
        $pelanggan = new Pelanggan([
          'nama_pelanggan' 	=> $request->nama_pelanggan,
          'email'       	=> $request->email,
          'password'        => $request->password,
          'nomor_telp' 	    => $request->nomor_telp,
          'nomor_kwh' 	    => $request->nomor_kwh,
          'alamat' 	        => $request->alamat,
          'id_tarif' 	    => $request->id_tarif,
        ]);
        $pelanggan->save();
        return response()->json([
			'status'	=> '1',
			'message'	=> 'Pelanggan berhasil ditambah'
        ], 201);    
    }

}
