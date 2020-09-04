@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col m8 offfset-m2 l6 offset-l3 s12">
            <div class="card">
                
                <div class="card-content">
                    <span class="card-title">Register</span>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="input-field">
                            <label for="username">{{ __('Username') }}</label>
                            
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            
                            @error('username')
                            <span class="helper-text red-text">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="input-field">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                            
                            @error('email')
                            <span class="helper-text red-text">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            
                        </div>
                        
                        <div class="input-field">
                            <label for="password">{{ __('Password') }}</label>
                            
                            <input id="password" type="password" name="password" required autocomplete="new-password">
                            
                            @error('password')
                            <span class="helper-text red-text">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="input-field">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        
                        <div class="input-field">
                            <button type="submit" class="btn">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
