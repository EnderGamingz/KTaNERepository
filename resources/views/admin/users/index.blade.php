@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
          <div class="col s12">
            <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
            <a href="{{ route('admin.users.index') }}" class="breadcrumb">@lang('users.title')</a>
          </div>
        </div>
    </nav>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('users.title')</span>
                    <ul class="collection">
                        @foreach ($users as $user)
                            <li class="collection-item">
                                <div class="row mb-0 valign-wrapper">
                                    <div class="col s12 m8">
                                        <b>{{ $user->username }}</b> <br>
                                        {{ $user->email }}
                                    </div>
                                    <div class="col s12 m4 right-align">
                                        @can('show.admin.users')
                                        <a class="btn btn-flat" href="{{ route('admin.users.show', $user) }}"><i class="material-icons">keyboard_arrow_right</i></a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection