<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function registerForm(){
        return view('auth.register');
    }
    public function register(RegisterRequest  $request){
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        if($user->admin){
            return redirect('dashboard.products.index');
        }else{
            return redirect('/');
        }
    }

    public function loginForm(){
        return view('auth.login');
    }
public function login(LoginRequest $request)
{
    $credentials = $request->validated();

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Email or password is incorrect'
        ])->withInput();
    }

    $request->session()->regenerate();
    
    if (Auth::user()->hasRole('admin')) {

    return redirect()->route('dashboard.products.index');
    }

return redirect()->route('products.index');


    return redirect()->route('products.index');
}


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function profile(){
        $user = Auth::user();
        return view('auth.profile',compact('user'));
    }



    public function updateProfileForm()
    {
    $user = Auth::user();
    return view('auth.updateprofile', compact('user'));
    }



        public function updateProfile(Request $request)
    {

    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'current_password' => 'required|string',
        'new_password' => 'nullable|string|min:6|confirmed',
    ]);
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    $user = User::find(Auth::id());
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->new_password);
    $user->save();
    return redirect()->route('profile')->with('success', 'Profile Updated');
    }





    public function forgetPasswordForm(){
        return view('auth.forget');
    }
    public function forgetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $code = rand(100000, 999999);

    Mail::to($request->email)
        ->send(new ResetPasswordMail($code));

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => Hash::make($code),
            'created_at' => now()
        ]
    );

    return redirect()->route('verify.code')
        ->with('email', $request->email);
}

 

    public function verifyCodeForm(){
        return view('auth.verify-code');        
    }
    public function verifyCode(Request $request){
        $request->validate([
            'email'=>'email|required|exists:users,email',
            'code'=>'required|max_digits:6|min_digits:6'
        ]);
        $reset = DB::table('password_reset_tokens')
        ->where('email',$request->email)
        ->where('token',$request->code)
        ->first();
        if(!$reset){
            return redirect()->back()->withErrors(['email' => 'email wrong']);
        }
        if(now()->diffInMinutes($reset->created_at) > 10){
            return redirect()->back()->withErrors(['code' => 'code Expired']);
        }
        return redirect()-> route('reset.password')->with(['code' =>$request->code ,'email' => $request->email]);
    }
    public function resetPasswordForm(){
        return view('auth.reset-password');        
    }
    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'email|required|exists:users,email',
            'code'=>'required|max_digits:6|min_digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $reset = DB::table('password_reset_tokens')
        ->where('email',$request->email)
        ->where('token',$request->code)
        ->first();
        if(!$reset){
            return redirect()->back()->withErrors(['email' => 'email wrong']);
        }
        $user = User::where('email',$request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('email',$request->email)->delete();
        return redirect()->route('login');
    }
}
