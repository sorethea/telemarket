<?php

namespace App\Filament\Auth;
use App\Models\Customer;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getPhoneNumberFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getPhoneNumberFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label(__('general.contact.phone_number'))
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel());
    }
    protected function handleRegistration(array $data): Model
    {
        logger(request()->all());
        $user = $this->getUserModel()::create($data);
        $user->assignRole('user');
//        if(!empty($this->tid)){
//            Customer::where('id',$this->tid)->update(['user_id',$user->id]);
//        }
        return $user;
    }
}
