<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Başarıyla çıkış yaptınız.'
            
        ]);
    }
    
    
        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        
            $user = User::where('email', $request->email)->first();
            
            if (!$user || !Hash::check($request->password, $user->password)) {
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
    


        public function register(Request $request)
        {
            $messages = [
                'name.required'     => 'İsim alanı zorunludur.',
                'email.required'    => 'E-posta adresi zorunludur.',
                'email.email'       => 'Geçerli bir e-posta adresi giriniz.',
                'email.unique'      => 'Bu e-posta adresi zaten kayıtlı.',
                'password.required' => 'Şifre alanı zorunludur.',
                'password.min'      => 'Şifre en az 6 karakter olmalıdır.',
            ];
        
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ], $messages); 
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
        
            try {
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                ]);
        
                $user->assignRole('user');

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Kayıt başarılı!'
                ], 201);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Kayıt sırasında bir hata oluştu: ' . $e->getMessage()
                ], 500);
            }
        }
        
        


        public function update_user(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ]);
        
            $user = auth()->user();
   
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        
            return response()->json(['message' => 'Yazı başarıyla güncellendi', 'user' => $user]);
        }
}
