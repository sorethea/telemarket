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
    public $tid;
    public function mount(): void
    {
        $this->tid = request()->get('tid');
        parent::mount(); // TODO: Change the autogenerated stub
    }

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
        $user = $this->getUserModel()::create($data);
        $user->assignRole('user');
        if(!empty($this->tid)){
            $customers = Customer::where('id',$this->tid)->get();
            foreach($customers as $customer){
                $customer->user($user)->save();
            }
        }
        return $user;
    }
}
