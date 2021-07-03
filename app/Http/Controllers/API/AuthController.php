<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Helpers\JSONResponse;
use App\Models\Customer;

class AuthController extends Controller
{

    function login(Request $request)
    {

        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $cek_user = User::where('username', $request->username)->first();
            if (!Hash::check($request->password, $cek_user->password)) {
                throw new \Exception('Invalid Credentials');
            }

            if ($cek_user->roles == 'user') {

                $get_user = DB::select(
                    "SELECT a.id as user_id ,b.id as cust_id ,a.username,a.roles,b.cust_name,b.cust_address,b.cust_phone 
                        FROM users a 
                        INNER JOIN customers b ON a.id = b.user_id 
                        WHERE a.id = '$cek_user->id'"
                );
                $user = $get_user[0];
            } else {
                $user = $cek_user;
            }

            return JSONResponse::success(
                $user,
                'Authenticated',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Authentication Failed',
                500
            );
        }
    }

    function register(Request $request)
    {
        try {

            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'cust_name' => 'required',
                'cust_address' => 'required',
                'cust_phone' => 'required',
            ]);

            $insert_user = User::insert([
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "roles" => "user",
            ]);

            if ($insert_user) {
                $get_user = User::where('username', $request->username)->first();
                Customer::insert([
                    "user_id" => $get_user->id,
                    "cust_name" => $request->cust_name,
                    "cust_address" => $request->cust_address,
                    "cust_phone" => $request->cust_phone,
                ]);
            }

            $get_data = DB::select(
                "SELECT a.id as user_id ,b.id as cust_id ,a.username,a.roles,b.cust_name,b.cust_address,b.cust_phone 
                        FROM users a 
                        INNER JOIN customers b ON a.id = b.user_id 
                        WHERE a.id = '$get_user->id'"
            );

            $user = $get_data[0];

            return JSONResponse::success(
                $user,
                'Authenticated',
            );
        } catch (Exception $e) {

            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Registration Failed',
                500
            );
        }
    }
}
