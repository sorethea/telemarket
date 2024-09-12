<?php

namespace App\Responses;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        $user = auth()->user();
        if($user->hasRole('admin')){
            $url = '/marketing';
        }elseif ($user->hasRole('marketing')){
            $url = '/marketing';
        }else{
            $url='/marketing';
        }
        return redirect()->intended($url);
    }
}
