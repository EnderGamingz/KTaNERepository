@extends('layouts.app')

@section('content')

<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
                <a href="{{ route('admin.permissions.index') }}" class="breadcrumb">@lang('permissions.title')</a>
                <a href="{{ route('admin.permissions.index') }}" class="breadcrumb">@lang('roles.title')</a>
                <a href="{{ route('admin.roles.show', $role)}}" class="breadcrumb">{{ $role->name }}</a>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('roles.info')</span>
                    <h6>Name</h6>
                    <span class="light">{{ $role->name }}</span>
                    <h6>Description</h6>
                    <span class="light">{{ $role->description }}</span>
                    <h6>Permissions</h6>
                    <ul class="collection">
                        @foreach ($role->permissions as $permission)
                        <li class="collection-item">
                            {{ $permission->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @can('edit.admin.roles')
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('roles.edit')</span>
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-0">
                            <div class="col s12 m6 input-field">
                                <label for="role_name">Name</label>
                                <input type="text" name="name" class="char-count" data-length="50" id="role_name" maxlength="50" required value="{{ $role->name }}">
                                @error('name')
                                <div class="helper-text red-text">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col s12 m6 input-field">
                                <label for="role_description">Description</label>
                                <input type="text" name="description" class="char-count" data-length="255" id="role_description" maxlength="50" 
                                value="{{ $role->description }}" required>
                                @error('description')
                                <div class="helper-text red-text">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col s12 m8 input-field">
                                <select name="permissions[]" id="role_permissions" multiple>
                                    @foreach (cache('permissions') as $permission)
                                    <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <label for="role_permissions">Permissions</label>
                                @error('permissions')
                                <div class="helper-text red-text">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col s12 m2">
                                <button type="submit" class="btn mt-2"><i class="material-icons">check</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection