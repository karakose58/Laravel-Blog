<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function userinfo()
    {
        $user = auth()->user();
        return $this->success($user, 'Kullanıcı bilgileri getirildi.');
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
    
        return $this->success(null, 'Başarıyla çıkış yaptınız.');

    }
    
    
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
    
        $user = User::where('email', $validated['email'])->first();
        
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                
                'message' => 'Giriş bilgileri hatalı. E-posta adresinizi yada şifrenizi kontrol edin.'
            ], 401);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Giriş başarılı!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    


public function register(RegisterRequest $request)
    {
        
        $validated = $request->validated();
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            
        ]);

  
            
            
        if ($user) {
            return response()->json([
                'message' => 'Kayıt başarılı.',
            ], 201);
        }
    
        return response()->json([
            'message' => 'Bir şeyler ters gitti, lütfen tekrar deneyin.',
        ], 500);
    }








        
        


        public function update_user(UpdateUserRequest $request)
        {
            $validated = $request->validated();
        
            $user = auth()->user();
        
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        
            return response()->json([
                'message' => 'Kullanıcı başarıyla güncellendi.',
                'user' => $user
            ]);
        }
        
}
