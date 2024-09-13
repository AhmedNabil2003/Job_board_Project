<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\JobListing;
use App\Models\Application; // تأكد من استيراد النموذج
use App\Models\Notification; // تأكد من استيراد النموذج
use Carbon\Carbon; // تأكد من استيراد Carbon

class AdminController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 3600);
        $this->middleware('auth');
        $this->middleware('role:admin'); // تأكد من أن المسؤول هو فقط من يمكنه الوصول
    }

    public function dashboard()
    {
        // جلب جميع المستخدمين
        $users = User::all();

        // جلب عدد الوظائف
        $totalJobs = JobListing::count();

        // جلب عدد التطبيقات
        $totalApplications = Application::count();

        // جلب عدد المستخدمين
        $totalUsers = User::count();

        // جلب عدد المستخدمين الجدد في آخر 30 يومًا
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // جلب عدد الإشعارات المعلقة
        $pendingNotifications = Notification::where('status', 'pending')->count();

        $recentActivities = Notification::orderBy('created_at', 'desc')->take(5)->get(); // أو أي استعلام آخر يتناسب مع بياناتك

        $notifications = Notification::orderBy('created_at', 'desc')->get();
        // تمرير البيانات إلى العرض
         return view('admin.dashboard', compact('users', 'totalJobs', 'totalApplications', 'totalUsers', 'newUsers', 'pendingNotifications','recentActivities','notifications'));
    }

    public function manageUsers()
    {
        // جلب جميع المستخدمين من قاعدة البيانات
        $users = User::all();

        // إعادة عرض صفحة إدارة المستخدمين مع تمرير البيانات
        return view('admin.manage_users', compact('users'));
    }
    public function activateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_active = true;
            $user->save();
            return redirect()->route('admin.manage_users')->with('status', 'User activated successfully.');
        }
    
        return redirect()->route('admin.manage_users')->with('error', 'User not found.');
    }
    public function deactivateUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->is_active = false;
        $user->save();
        return redirect()->route('admin.manage_users')->with('status', 'User deactivated successfully.');
    }

    return redirect()->route('admin.manage_users')->with('error', 'User not found.');
}


    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->role = $request->input('role');
        $user->save();
        return redirect()->route('admin.manage_users')->with('success', 'User updated successfully');
    }

    // لإرسال الإشعار للمستخدم
    public function notifyUser(Request $request, $id) {
        $user = User::find($id);
        // الكود لإرسال الإشعار، مثلاً باستخدام إشعار داخل النظام أو بريد إلكتروني
        return redirect()->route('admin.manage_users')->with('success', 'Notification sent successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.manage_users')->with('success', 'User deleted successfully');
    }

    public function manageJobs()
    {
        $jobs = JobListing::all();
        return view('admin.manage_jobs', compact('jobs'));
    }

    public function approveJob($id)
    {
        $job = JobListing::findOrFail($id);
        $job->status = 'approved';
        $job->save();

        return redirect()->route('admin.manage_jobs')->with('status', 'Job approved successfully.');
    }

    // يمكنك إضافة المزيد من الأساليب هنا حسب الحاجة
}
