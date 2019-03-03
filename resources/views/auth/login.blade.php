@extends('auth.layout')

@section('content')
    <div class="flex flex-col items-center justify-start h-full mt-12">
        <div class="w-400p text-center">
            <h1 class="font-freude inline-block text-6xl text-red">All<span class="font-normal text-red text-6xl"> Paid</span></h1>
        </div>
        <div class="flex flex-col w-400p bg-white text-center mt-4 border-red border-t-4 pt-4 rounded-lg shadow-md">
            <p class="text-sm text-grey pb-4">{{ __('Login') }}</p>
            <form action="#" method="POST" @submit.prevent="login">
                @csrf
                <!--Email Field-->
                <div class="mb-4">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input v-model="email" class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="username email" type="email" placeholder="janedoe@email.com" name="email" id="email" aria-label="Email">
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="email">
                        @if ($errors->has('email'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('email') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">{{ __('Email') }}</span>
                        @endif
                    </label>
                </div>

                <!--Password Field-->
                <div class="mb-4">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input v-model="password" class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="current-password" type="password" placeholder="**********************" name="password" id="password" aria-label="Password">
                        <span class="icon-lock-closed text-green"></span>
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="password">
                        @if ($errors->has('password'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('password') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">{{ __('Password') }}</span>
                        @endif
                    </label>
                </div>

                <!--Remember Me-->
                <div class="w-4/5 mx-auto mb-4 text-left mt-4">
                    <label class="block text-grey font-bold">
                        <input class="mr-2 text-green" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="text-sm" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </label>
                </div>

                <!--Actions-->
                <div class="flex justify-between items-center mt-8 mb-8 w-4/5 mx-auto">
                    <button class="flex-none rounded-full bg-green text-white font-bold py-2 px-4 border-2 border-transparent hover:bg-white hover:text-green hover:border-green mr-8" type="submit">
                        Sign In
                    </button>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-grey font-light no-underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
            <p class="text-center text-grey text-xs mb-4">
                ©2019 AllPaid All rights reserved.
            </p>
        </div>
    </div>
@endsection
