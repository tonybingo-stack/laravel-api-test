<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public static function checkUser($data)
    {
        $response = [];
        if (array_key_exists('name', $data)) {
            if (Auth::validate(array('name' => $data['name'], 'password' => $data['password']))) {
                $user = User::where('name', $data['name'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect name or password';
            }
        } elseif (array_key_exists('email', $data)) {
            $userObj = User::where('email', $data['email'])->first();
            if (!$userObj) {
                $response['message'] = 'Please enter valid registered email.';
                return $response;
            }
            if (Auth::validate(array('email' => $data['email'], 'password' => $data['password']))) {
                $user = User::where('email', $data['email'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect password';
            }
        } else {
            $response['message'] = 'Email or name is required';
        }
        return $response;
    }

    public static function login($data)
    {
        $response = [];
        if (array_key_exists('username', $data)) {
            if (Auth::validate(array('name' => $data['username'], 'password' => $data['password']))) {
                $user = User::where('name', $data['username'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect name or password';
            }
        } else {
            $response['message'] = 'name or password is required';
        }
        return $response;
    }
}
