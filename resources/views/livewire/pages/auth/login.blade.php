<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
     protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        // $this->validate();

        $this->form->authenticate();

        Session::regenerate();
        //set session team id for spatie permissions
        Session::put('team_id',1);

        if (auth()->user()->membership_level == 'client') {
            $this->redirect( 'client/dashboard', navigate: true);
        }else {
            $this->redirect(
            session('url.intended', $this->redirectTo()),
            navigate: true
            );
        }

    }
    protected function redirectTo()
    {

        if (auth()->user()->membership_level == 'client') {
            return 'client/dashboard';
        }
        return $this->redirectTo;
    }
    }
; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- establishment name -->
        <div>
            <x-input-label for="email" :value="__('trans.establishment_name')" />
            <x-text-input wire:model="form.establishment_name" id="establishment_name" class="block mt-1 w-full" type="text" name="establishment_name" required autofocus autocomplete="establishment_name" />
            <x-input-error :messages="$errors->get('establishment_name')" class="mt-2" />
        </div>
        <!-- Email Address -->
        <div class="">
            <x-input-label for="email" :value="__('trans.your_email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required  autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('trans.password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('trans.remember') }}</span>
            </label>
        </div>
        <x-primary-button class="w-full my-3 justify-center">
            {{ __('trans.sign_in') }}
        </x-primary-button>
        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-blue-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register',Route::current()->parameter('subdomain')) }}" wire:navigate>
                {{ __('trans.sign_up') }}
            </a>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request',Route::current()->parameter('subdomain')) }}" wire:navigate>
                    {{ __('trans.forget_pass') }}
                </a>
            @endif


        </div>
    </form>
</div>
