<?php

namespace App\Http\Controllers;

use App\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TarifController extends Controller
{
   
    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Tarif::count();
        $tarif = array();

        foreach (Tarif::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_tarif"          => $p->id,
                "daya"              => $p->daya,
                "tarifperkwh"       => $p->tarifperkwh,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($tarif, $item);
        }
        $data["tarif"] = $tarif;
        $data["status"] = 1;
        return response($data);
    }


    public function show($id) 
    {
        $data = Tarif::where('id',$id)->get();
        return response ($data);
    }

    public function delete($id)
    {
        try{

            Tarif::where("id", $id)->delete();

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
			'daya'        => 'required|string|max:255',
            'tarifperkwh' => 'required|string|max:255',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$tarif = Tarif::where('id', $request->id)->first();
		$tarif->daya 	        = $request->daya;
		$tarif->tarifperkwh 	= $request->tarifperkwh;
        $tarif->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Tarif berhasil diubah'
		], 201);
    }

    public function store(Request $request)
    {
        $tarif = new Tarif([
            'daya' 	        => $request->daya,
            'tarifperkwh'   => $request->tarifperkwh,  
          ]);
  
          $tarif->save();
          return response()->json([
              'status'	=> '1',
              'message'	=> 'Tarif berhasil ditambah'
          ], 201);   
    }

 
  
}
