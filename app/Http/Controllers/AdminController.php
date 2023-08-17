<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminPage()
    {
        $users = User::where('role', 'user')->get();


        $labels = ['total number of users', 'total points awarded'];
        $chartData = [$users->count(), Wallet::sum('point')];

        $labels2 = ['Novice Referrer', 'Expert Referrer','Master Referrer'];
        $chartData2 = [$users->where('level','Novice Referrer')->count(),$users->where('level','Expert Referrer')->count(),$users->where('level','Master Referrer')->count()];

        return view('admin', compact('users', 'labels', 'chartData','labels2','chartData2'));
    }
}
