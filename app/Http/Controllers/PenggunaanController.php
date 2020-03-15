<?php

namespace App\Http\Controllers;

use App\Penggunaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PenggunaanController extends Controller
{
    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Penggunaan::count();
        $penggunaan = array();

        foreach (Penggunaan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_penggunaan"      => $p->id,
                "id_pelanggan"       => $p->id_pelanggan,
                "bulan"              => $p->bulan,
                "tahun"              => $p->tahun,
                "meter_awal"         => $p->meter_awal,
                "meter_akhir"        => $p->meter_akhir,
                "created_at"         => $p->created_at,
                "updated_at"         => $p->updated_at
            ];

            array_push($penggunaan, $item);
        }
        $data["penggunaan"] = $penggunaan;
        $data["status"] = 1;
        return response($data);
    }

    public function show($id) 
    {
        $data = Penggunaan::where('id',$id)->get();
        return response ($data);
    }


    public function delete($id)
    {
        try{

            Penggunaan::where("id", $id)->delete();

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


    public function ubah($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
			'id_pelanggan'  => 'required|string|max:255',
            'bulan'         => 'required|string|max:255',
            'tahun'         => 'required|string|max:255',
            'meter_awal'    => 'required|string|max:255',
            'meter_akhir'   => 'required|string|max:255',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$penggunaan = Penggunaan::where('id', $request->id)->first();
		$penggunaan->id_pelanggan 	= $request->id_pelanggan;
        $penggunaan->bulan      	= $request->bulan;
        $penggunaan->tahun 	        = $request->tahun;
        $penggunaan->meter_awal 	= $request->meter_awal;
        $penggunaan->meter_akhir	= $request->meter_akhir;
        $penggunaan->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Penggunaan berhasil diubah'
		], 201);
    }
    
    public function store(Request $request)
    {
            $penggunaan = new Penggunaan([
                'id_pelanggan' 	=> $request->id_pelanggan,
                'bulan'  	    => $request->bulan,
                'tahun' 	    => $request->tahun,
                'meter_awal' 	=> $request->meter_awal,
                'meter_akhir'	=> $request->meter_akhir, 
              ]);
      
              $penggunaan->save();
              return response()->json([
                  'status'	=> '1',
                  'message'	=> 'Penggunaan berhasil ditambah'
              ], 201);   
        
    }

}
