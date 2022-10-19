<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private function responseBody($data, $code = 200)
    {
        return response()
            ->json([
                'data' => $data
            ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $attempt = auth()->attempt($request->only('username', 'password'));

        if ($attempt) {
            $user = User::where('username', $request->username)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->responseBody([
                'status' => 'success',
                'message'       => 'Login Success',
                'access_token'  => $token,
                'token_type'    => 'Bearer'
            ]);
        } else {
            return $this->responseBody([
                'status' => 'fail',
                'message' => 'Wrong Credentials'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validated) {
                User::create([
                    'name' => request('name'),
                    'username' => request('username'),
                    'password' => Hash::make(request('password')),
                ]);


                return $this->responseBody([
                    'status' => 'success',
                    'message'       => 'Silahkan Login',
                ]);
            } else {

                return $this->responseBody([
                    'status' => 'fail',
                    'message' => 'Gagal Register',
                ]);
            }
        } catch (\Throwable $th) {

            return $this->responseBody([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->responseBody([
            'status' => 'success',
            'message' => 'You have been logged out'
        ]);
    }
}
