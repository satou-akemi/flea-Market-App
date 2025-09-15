<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    public function store(Request $request, CreateNewUser $creator)
{
    event(new Registered($user = $creator->create($request->all())));
    session()->put('unauthenticated_user', $user);

    return redirect()->route('thanks');
}
}