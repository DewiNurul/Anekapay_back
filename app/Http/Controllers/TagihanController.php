<?php

namespace App\Http\Controllers;

use App\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TagihanController extends Controller
{
  

    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Tagihan::count();
        $tagihan = array();

        foreach (Tagihan::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_tagihan"      => $p->id,
                "id_penggunaan"   => $p->id_penggunaan,
                "bulan"           => $p->bulan,
                "tahun"           => $p->tahun,
                "jumlah_meter"    => $p->jumlah_meter,
                "status"          => $p->status,
                "created_at"      => $p->created_at,
                "updated_at"      => $p->updated_at
            ];

            array_push($tagihan, $item);
        }
        $data["tagihan"] = $tagihan;
        $data["status"] = 1;
        return response($data);
    }

    public function show($id) 
    {
        $data = Tagihan::where('id',$id)->get();
        return response ($data);
    }


    public function delete($id)
    {
        try{

            Tagihan::where("id", $id)->delete();

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
			'id_penggunaan'  => 'required|string|max:255',
            'bulan'          => 'required|string|max:255',
            'tahun'          => 'required|string|max:255',
            'jumlah_meter'   => 'required|string|max:255',
            'status'         => 'required|string|max:255',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$tagihan = Tagihan::where('id', $request->id)->first();
		$tagihan->id_penggunaan	= $request->id_penggunaan;
        $tagihan->bulan      	= $request->bulan;
        $tagihan->tahun 	    = $request->tahun;
        $tagihan->jumlah_meter 	= $request->jumlah_meter;
        $tagihan->status	    = $request->status;
        $tagihan->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Tagihan berhasil diubah'
		], 201);
    }
    
    public function store(Request $request)
    {
            $tagihan = new Tagihan([
                'id_penggunaan' => $request->id_penggunaan,
                'bulan'  	    => $request->bulan,
                'tahun' 	    => $request->tahun,
                'jumlah_meter' 	=> $request->jumlah_meter,
                'status'	    => $request->status, 
              ]);
      
              $tagihan->save();
              return response()->json([
                  'status'	=> '1',
                  'message'	=> 'Tagihan berhasil ditambah'
              ], 201);   
        
    }

}
