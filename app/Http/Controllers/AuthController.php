<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use App\Repositories\Repository;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    protected $model;

    public function __construct(User $user)
    {
        // set the model
        $this->model = new Repository($user);
    }


    public function register(Request $request) {
        $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|email',
           'password' => 'required|string|confirmed',
           'student_number' => 'required'
        ]);
        $student = DB::select("select * from students where student_number='".$request->student_number."'");

        if(empty($student)) {
            return response()->json([
                'message' => 'Geçersiz Öğrenci Numarası Girdiniz. Lütfen Kontrol Ediniz!',
                'status_code' => 500
            ],500);
        } else {

            $request->merge(['password'=>bcrypt($request->password)]);
            $response = $this->model->create($request->all());

            if($response){
                $details = [
                    'title' => 'Turk Ai - Öğrenci Bilgi Sistemi',
                    'link'  => 'http://127.0.0.1/login',
                    'body' => '<p>Sayın '. $request->name.',<br> Turk Ai - Öğrenci Bilgi Sistemine Hoşgeldiniz.</p><p>Kayıt esnasında belirlemiş olduğunuz kullanıcı bilgileri ile aşağıdaki linke tıklayarak giriş yapabilirsiniz.</p>'
                ];

                Mail::to($request->email)->send(new SendMail($details));

                return response()->json([
                    'message' => 'Kullanıcınız oluşturulmuştur',
                    'status_code' => 201
                ],201);
            } else {
                return response()->json([
                    'message' => 'Bir hata oluştu',
                    'status_code' => 500
                ],500);
            }
        }

    }
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Geçersiz şifre yada email adresi',
                'status_code' => 401
            ],401);
        }

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        $user = $request->user();

        if ($user->role == 'administrator') {
            $tokenData = $user->createToken('Personel Access Token', ['do_anything']);
        } else {
            $tokenData = $user->createToken('Personel Access Token', ['can_create']);
        }

        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        if ($token->save()) {
            return response()->json([
                'user' => $user,
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $tokenData->token->scopes[0],
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ],200);
        } else {
            return response()->json([
                'message' => 'Bir hata oluştu, Lütfen daha sonra tekrar deneyiniz',
                'status_code' => 500
            ],500);
        }

    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Çıkış Başarılı',
            'status_code' => 200
        ],200);
    }

    public function profile() {

        $profile = $this->model->find(auth()->user()->getAuthIdentifier());
        $student = DB::select("select * from students where student_number='".$profile->student_number."'");

        //$response = $profile->merge($student);
        $array = array_merge($student, $profile->toArray());
        return response()->json($array, 200);

    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
        if(isset($request->password)) {
            $request->merge(['password'=>bcrypt($request->password)]);
        }
        $response = $this->model->update($request->all(),$request->id);
        if($response) {
            return response()->json($response, 200);
        } else {
            return response()->json([
                'message' => 'Bir hata oluştu',
                'status_code' => 500
            ], 500);
        }
    }
}
