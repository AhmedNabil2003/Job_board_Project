<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {        ini_set('max_execution_time', 3600);
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        } elseif ($user->hasRole('candidate')) {
            return redirect()->route('candidate.dashboard');
        }

        return abort(403, 'Unauthorized action.');
    }
}
