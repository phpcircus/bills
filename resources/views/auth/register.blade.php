@extends('auth.layout')

@section('content')
    <div class="flex flex-col items-center justify-start h-full mt-12">
        <div class="w-400p text-center">
            <h1 class="font-freude inline-block text-7xl text-red">All<span class="font-normal text-red text-6xl">Paid</span></h1>
        </div>
        <div class="flex flex-col w-400p bg-white text-center mt-4 border-red border-t-4 pt-4 rounded-lg shadow-md">
            <p class="text-sm text-grey pb-4">{{ __('Register') }}</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <!--Name Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="username name" type="text" placeholder="Jane Doe" name="name" id="name" aria-label="Name">
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="name">
                        @if ($errors->has('name'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('name') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">Name</span>
                        @endif
                    </label>
                </div>

                <!--Email Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="username email" type="email" placeholder="janedoe@email.com" name="email" id="email" aria-label="Email">
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="email">
                        @if ($errors->has('email'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('email') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">Email</span>
                        @endif
                    </label>
                </div>

                <!--Password Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="current-password" type="password" placeholder="**********************" name="password" id="password" aria-label="Password">
                        <span class="icon-lock-closed text-green"></span>
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="password">
                        @if ($errors->has('password'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('password') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">Password</span>
                        @endif
                    </label>
                </div>

                <!-- Password Confirmation Field -->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between accessible-input-container mx-auto py-1 mb-1">
                        <input class="w-full appearance-none bg-transparent border-none text-grey-darkest p-1 accessible-input" autocomplete="current-password" type="password" placeholder="**********************" name="password_confirmation" id="password-confirm" aria-label="Password Confirmation">
                        <span class="icon-lock-closed text-green"></span>
                    </div>
                    <label class="block w-4/5 mx-auto text-grey-darkest text-left text-sm font-bold" for="password-confirm">
                        @if ($errors->has('password'))
                            <span class="text-red text-xs italic ml-2">{{ $errors->first('password') }}</span>
                        @else
                            <span v-else class="text-sm text-grey-darkest">{{ __('Confirm Password') }}</span>
                        @endif
                    </label>
                </div>

                <!--Actions-->
                <div class="flex justify-between items-center mt-8 mb-8 w-4/5 mx-auto">
                    <button class="flex-none rounded-full bg-white text-blue font-bold py-2 px-4 border-2 border-blue hover:bg-blue hover:text-white hover:border-transparent mr-8" type="submit">
                        Register
                    </button>
                </div>
            </form>
            <p class="text-center text-grey text-xs mb-4">
                ©2019 AllPaid All rights reserved.
            </p>
        </div>
    </div>
@endsection
