@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col l6 offset-l3 m8 offset-m2 col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Login</span>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="input-field">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            
                            @error('email')
                            <span class="helper-text red-text">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        
                        <div class="input-field">
                            <label for="password">{{ __('Password') }}</label>
                            
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                            
                            @error('password')
                            <span class="helper-text red-text">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        <p> 
                            <label>
                                <input class="filled-in" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>{{ __('Remember Me') }}</span>
                            </label>
                        </p>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                            
                            @if (Route::has('password.request'))
                            <a class="btn btn-flat" href="{{ route('password.request') }}">
                                Reset Password
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
