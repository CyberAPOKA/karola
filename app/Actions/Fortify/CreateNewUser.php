<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // dd($input);
        $input['birth_date'] = \Carbon\Carbon::parse($input['birth_date'])->format('Y-m-d');
        $input['cpf'] = preg_replace('/\D/', '', $input['cpf']);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone' => ['required', 'string', 'regex:/^\(\d{2}\) \d{1} \d{4}-\d{4}$/'],
            'confirm_phone' => ['required', 'string', 'same:phone'],
            'birth_date' => ['required', 'date', 'before:today'],
            'cpf' => ['required', 'string', 'size:11', 'unique:users'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'birth_date' => $input['birth_date'],
            'cpf' => $input['cpf'],
        ]);
    }
}
