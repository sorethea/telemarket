<?php

namespace App\Responses;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        $user = auth()->user();
        if($user->hasRole('admin')){
            $url = '/admin';
        }elseif ($user->hasRole('marketing')){
            $url = '/marketing';
        }else{
            $url='';
        }
        return redirect()->intended($url);
    }
}
