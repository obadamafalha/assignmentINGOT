<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function login(Request $request)
    {

        $user = DB::table('users')->where('email', $request->email)->first();
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
            'phone' => 'unique:users,phone'
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
            $user = DB::table('users')->where('referralLink', url("/") . '/register?registeredBy=' . $request['registeredBy'])->first();
            $request['registeredBy'] = $user->id;
            DB::table('users')->whereId($user->id)->increment('numberOfUserRegistered');
        }

        $user = DB::table('users')->insertGetId($request->except(['_token', 'User_image']));
        DB::table('wallets')->insert(['userId' => $user]);
        return redirect('/users/' . $user);
    }

    public function incrementVisit($registeredBy)
    {
        DB::table('users')->where('referralLink', url("/") . '/register?registeredBy=' . $registeredBy)
            ->increment('numberOfUserVisited');
    }
}
