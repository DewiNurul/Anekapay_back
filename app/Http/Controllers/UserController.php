<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
			if(!$token = JWTAuth::attempt($credentials)){
				return response()->json([
						'logged' 	=>  false,
						'message' 	=> 'Invalid email and password'
					]);
			}
		} catch(JWTException $e){
			return response()->json([
						'logged' 	=> false,
						'message' 	=> 'Generate Token Failed'
					]);
		}

		return response()->json([
					"logged"    => true,
                    "token"     => $token,
                    "message" 	=> 'Login berhasil'
		]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'nama_admin' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> 0,
				'message'	=> $validator->errors()->toJson()
			]);
		}

		$user = new User();
		$user->nama_admin 	= $request->nama_admin;
        $user->email 		= $request->email;
		$user->password	    = Hash::make($request->password);
		$user->save();

		$token = JWTAuth::fromUser($user);

		return response()->json([
			'status'	=> '1',
			'message'	=> 'Admin berhasil terregistrasi'
		], 201);
    }

    
	public function getAll($limit = 10, $offset = 0){
        $data["count"] = User::count();
        $user = array();

        foreach (User::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id_admin"    => $p->id,
                "nama_admin"  => $p->nama_admin,
                "email"    	  => $p->email,
                "password"    => $p->password,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($user, $item);
        }
        $data["user"] = $user;
        $data["status"] = 1;
        return response($data);
	}
	
	public function show($id) 
    {
        $data = User::where('id',$id)->get();
        return response ($data);
    }


    public function delete($id)
    {
        try{

            User::where("id", $id)->delete();

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
			'nama_admin' => 'required|string|max:255',
			'email'		 => 'required|string|email|max:255',
            'password'	 => 'required|string|min:5',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$user = User::where('id', $request->id)->first();
		$user->nama_admin 	= $request->nama_admin;
		$user->email 		= $request->email;
		$user->password	    = Hash::make($request->password);
        $user->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil diubah'
		], 201);
	}

	public function store(Request $request) {
        $user = new User([
          'nama_admin'  => $request->nama_admin,
          'email'       => $request->email,
          'password'    => $request->password,
        ]);

        $user->save();
        return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil ditambah'
        ], 201);    
	}

    public function getAuthenticatedUser()
    {
        try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					]);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token expired'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token absent'
					], $e->getStatusCode());
		}

		 return response()->json([
		 		"auth"      => true,
                "user"    => $user
		 ], 201);
    }
}
