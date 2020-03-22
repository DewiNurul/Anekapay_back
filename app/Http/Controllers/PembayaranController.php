<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PembayaranController extends Controller
{
   
    
    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Pembayaran::count();
        $pembayaran = array();

        foreach (Pembayaran::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_pembayaran"        => $p->id,
                "id_tagihan"           => $p->id_tagihan,
                "tanggal_pembayaran"   => $p->tanggal_pembayaran,
                "bulan_bayar"          => $p->bulan_bayar,
                "biaya_admin"          => $p->biaya_admin,
                "total_bayar"          => $p->total_bayar,
                "status"               => $p->status,
                "bukti"                => $p->bukti,
                "id_admin"             => $p->id_admin,
                "created_at"           => $p->created_at,
                "updated_at"           => $p->updated_at
            ];

            array_push($pembayaran, $item);
        }
        $data["pembayaran"] = $pembayaran;
        $data["status"] = 1;
        return response($data);
    }

   
    public function show($id) 
    {
        $data = Pembayaran::where('id',$id)->get();
        return response ($data);
    }

    public function delete($id)
    {
        try{

            Pembayaran::where("id", $id)->delete();

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
			'id_tagihan' => 'required|integer|max:255',
			'tanggal_pembayaran' => 'required|date|max:255',
            'bulan_bayar' => 'required|string|min:5',
            'biaya_admin' => 'required|integer|max:255',
            'total_bayar' => 'required|integer|max:255',
            'status' => 'required|string|max:255',
            'bukti' => 'required|string|max:255',
            'id_admin' => 'required|integer|max:255',

		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$pembayaran = Pembayaran::where('id', $request->id)->first();
		$pembayaran->id_tagihan	            = $request->id_tagihan;
		$pembayaran->tanggal_pembayaran     = $request->tanggal_pembayaran;
        $pembayaran->bulan_bayar            = $request->bulan_bayar;
        $pembayaran->biaya_admin  	        = $request->biaya_admin;
        $pembayaran->total_bayar   	        = $request->total_bayar;
        $pembayaran->status 	            = $request->status;
        $pembayaran->bukti 	                = $request->bukti;
        $pembayaran->id_admin    	        = $request->id_admin;
        $pembayaran->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil diubah'
		], 201);
    }
    

    public function store(Request $request)
    {
        $pembayaran = new Pembayaran([
            'id_tagihan' 	            => $request->id_tagihan,
            'tanggal_pembayaran'  	    => $request->tanggal_pembayaran,
            'bulan_bayar' 	            => $request->bulan_bayar,
            'biaya_admin' 	            => $request->biaya_admin,
            'total_bayar'	            => $request->total_bayar, 
            'status' 	                => $request->status,
            'bukti' 	                => $request->bukti,
            'id_admin'	                => $request->id_admin, 
          ]);
  
          $pembayaran->save();
          return response()->json([
              'status'	=> '1',
              'message'	=> 'Pembayaran berhasil ditambah'
          ], 201);   
    }

}
