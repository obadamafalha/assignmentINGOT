<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{

    private $userReferrals = [];
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect('/')->withErrors("Your Email Not Found");
        }

        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return redirect('/')->withErrors("Password Not Correct");
        }

        return redirect('/users/' . $user->id);
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
            'phone' => 'unique:users,phone',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $imageName = url('/') . "/uploads/images/" . time() . '.' . $request->User_image->extension();
        $request->User_image->move(public_path('uploads/images'), $imageName);
        $request['image'] = $imageName;

        $request['password'] = Hash::make($request['password']);


        $request['referralLink'] = url("/") . '/register?registeredBy=' . Str::uuid();


        if (!empty($request['registeredBy'])) {
            $user = User::where('referralLink', url("/") . '/register?registeredBy=' . $request['registeredBy'])->first();
            $request['registeredBy'] = $user->id;
            User::whereId($user->id)->increment('numberOfUserRegistered');
            $wallet = Wallet::where('userId', $user->id)->first();

            if ($user->numberOfUserRegistered >= 0 && $user->numberOfUserRegistered <= 5) {
                $wallet->increment('point', 5);
            } elseif ($user->numberOfUserRegistered >= 6 && $user->numberOfUserRegistered <= 10) {
                $wallet->increment('point', 7);
                $user->update(['level' => 'Expert Referrer']);
            } else {
                $wallet->increment('point', 10);
                $user->update(['level' => 'Master Referrer']);
            }
        }

        $user = User::insertGetId($request->except(['_token', 'User_image']));
        Wallet::insert(['userId' => $user]);



        return redirect('/users/' . $user);
    }

    public function incrementVisit($registeredBy)
    {
        User::where('referralLink', url("/") . '/register?registeredBy=' . $registeredBy)
            ->increment('numberOfUserVisited');
    }

    public function userPage($userId)
    {
        $user = User::find($userId);
        $data = $this->collectRelatedUser($user);
        $date_to = Carbon::now()->format('Y-m-d H:i:s');
        $date_from = Carbon::now()->subDays(14)->format('Y-m-d H:i:s');
        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"))
            ->where('registeredBy', $userId)
            ->where('created_at', '>=', $date_from)
            ->where('created_at', '<=', $date_to)
            ->groupBy(DB::raw("DAYNAME(created_at)"))
            ->pluck('count', 'day_name');
        $labels = $users->keys();
        $chartData = $users->values();

        return view('users', compact('user', 'data', 'labels', 'chartData'));
    }


    public function collectRelatedUser($user)
    {
        if ($user->referrals->isNotEmpty()) {
            foreach ($user->referrals as $value) {
                array_push($this->userReferrals, $value);
                $this->collectRelatedUser($value);
            }
        }
        return $this->userReferrals;
    }


    public function userTree(User $user)
    {
        $tree = $user->referrals;

        return view('userTree', compact('tree', 'user'));
    }
}
