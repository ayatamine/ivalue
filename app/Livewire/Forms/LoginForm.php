<?php

namespace App\Livewire\Forms;

use App\Models\Establishment;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule('required|string|email')]
    public string $email = '';

    #[Rule('required|string')]
    public string $password = '';

    #[Rule('required|string')]
    public string $establishment_name = '';

    #[Rule('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        if(!$establishment = Establishment::whereNameEn($this->establishment_name)->first())
        {
            throw ValidationException::withMessages([
                'establishment_name' => trans('auth.wrong_establishment'),
            ]);
        }
        else{
            config(['database.connections.tenant.database' =>  $establishment->database]);
            config(['database.connections.tenant.username' =>  $establishment->database_username]);
            config(['database.connections.tenant.password' =>  $establishment->database_password]);

            \DB::purge('tenant');
            \DB::connection('tenant')->reconnect();

            \DB::setDefaultConnection('tenant');
            \App::singleton('tenant', function() use($establishment){
                return $establishment;
            });
            if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
