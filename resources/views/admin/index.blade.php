@extends('layouts.app')

@section('content')
<div class="container">
    <h1>@lang('admin.title')</h1>
    <div class="row">
        @can('view.admin.users')
        <div class="col m6 s12 l6 xl4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">User Manager</span>
                    List, Update and Delete Users
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-flat">Manage Users</a>
                </div>
            </div>
        </div>  
        @endcan
        @can('view.admin.modules')
        <div class="col m6 s12 l6 xl4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Module Manager</span>
                    Create, Update and Delete Modules
                </div>
                <div class="card-action">
                    <a href="" class="btn btn-flat">Manage Modules</a>
                </div>
            </div>
        </div>  
        @endcan
        @can('view.admin.permissions')
        <div class="col m6 s12 l6 xl4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('permissions.title')</span>
                    @lang('permissions.description')
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-flat truncate">Manage Permissions</a>
                </div>
            </div>
        </div>  
        @endcan
    </div>
</div>
@endsection