<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // تأكد من استيراد نموذج المستخدم

class AuthController extends Controller
{
    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        ini_set('max_execution_time', 3600);
        return view('auth.login');
    }
   

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $validated + ['is_active' => true];

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/dashboard');
    } else {
        return back()->withErrors([
            'email' => 'The email or password is incorrect, or your account is not activated.',
        ]);
    }


        if (Auth::attempt($validated)) {
            return redirect()->intended('/dashboard'); // توجيه المستخدم إلى لوحة تحكم عامة بعد تسجيل الدخول
        } else {
            return back()->withErrors([
                'email' => 'The email or password is incorrect.',
            ]);
        }
    }

    // عرض نموذج التسجيل
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // معالجة التسجيل
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:employer,candidate,admin',
            
        ];

        // التحقق من كلمة المرور بناءً على الدور
        if ($request->input('role') === 'admin') {
            // كلمة المرور يمكن أن تكون أقل من 8 أحرف للمسؤولين
            $rules['password'] .= '|min:0'; // يمكنك ضبط الحد الأدنى وفقًا لاحتياجاتك
        } else {
            // كلمة المرور يجب أن تكون 8 أحرف على الأقل لأدوار أخرى
            $rules['password'] .= '|min:8';
        }

        $validated = $request->validate($rules);

        User::create([ // تأكد من أن User هو الكلاس الصحيح
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'is_active' => true,
        ]);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
