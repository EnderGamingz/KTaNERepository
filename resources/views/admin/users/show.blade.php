@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
                <a href="{{ route('admin.users.index') }}" class="breadcrumb">@lang('users.title')</a>
                <a href="{{ route('admin.users.show', $user) }}" class="breadcrumb">{{ $user->username }}</a>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col s12 m5">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('users.title')</span>
                    <h6>Username</h6>
                    <span class="light">{{ $user->username }}</span>
                    <h6>Email</h6>
                    <span class="light">{{ $user->email }}</span>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-content">
                    <div class="span card-title">@lang('users.permissions')</div>
                    <h6>Permissions</h6>
                    <ul class="collection">
                        @forelse($user->permissions as $permission)
                        <li class="collection-item">{{ $permission->name }}</li>
                        @empty
                        <li class="collection-item">No User Permissions</li>
                        @endforelse
                    </ul>
                    <h6>Roles</h6>
                    <ul class="collection">
                        @forelse($user->roles as $role)
                        <li class="collection-item">{{ $role->name }}</li>
                        @empty
                        <li class="collection-item">No User Roles</li>
                        @endforelse
                    </ul>
                </div>
                <div class="divider"></div>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">keyboard_arrow_down</i> Update</div>
                        <div class="collapsible-body">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-field">
                                    <select name="permissions[]" id="permissions" multiple>
                                        @foreach (cache('permissions') as $permission)
                                            <option value="{{ $permission->id }}" {{ $user->permissions->contains($permission) ? 'selected' : ''}}>
                                                {{$permission->name}}
                                            </option>
                                        @endforeach
                                    </select>    
                                    <label for="permissions">Permissions</label>
                                </div>
                                <div class="input-field">
                                    <select name="roles[]" id="roles" multiple>
                                        @foreach (cache('roles') as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : ''}}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>    
                                    <label for="roles">Roles</label>
                                </div>
                                <div>
                                    <button class="btn btn-flat">Update</button>
                                </div>
                            </form> 
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection