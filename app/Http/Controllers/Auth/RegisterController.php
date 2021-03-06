<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Links\LinksIndexController;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;

class RegisterController
{
    use RegistersUsers, ValidatesRequests;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        if (isset($data['newsletter'])) {
            $emailList = EmailList::where('name', 'freek.dev newsletter')->first();

            Subscriber::createWithEmail($data['email'])->subscribeTo($emailList);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova/posts';
        }

        return action(LinksIndexController::class);
    }
}
