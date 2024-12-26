<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required','email','unique:users','max:255'],
            'password' => ['required', 'max:255','confirmed']
        ],[
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Panjang karakter max 255',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Panjang email max 255',
            'password.required' => 'Password harus diisi',
            'password.max' => 'Panjang password max 255',
            'password.confirmed' => 'password tidak sama'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],400);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Pengguna baru berhasil ditambahkan'
            ],201);
        }
    }
}
