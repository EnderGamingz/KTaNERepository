@extends('layouts.app')

@section('content')

<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
          <div class="col s12">
            <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
            <a href="{{ route('admin.permissions.index') }}" class="breadcrumb">@lang('permissions.title')</a>
          </div>
        </div>
    </nav>
    <div class="row">
        <div class="col l6 s12">
            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper">
                        <div class="col m10">
                            <span class="card-title mb-0">@lang('permissions.title')</span>
                        </div>
                        <div class="col m2 right-align">
                            <form action="{{ route('admin.permissions.sync') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-floating tooltipped" data-tooltip="Sync"><i class="material-icons">sync</i></button>
                            </form>
                        </div>
                    </div>
                    <h6>Permission List</h6>
                    <ul class="collection">
                        @foreach ($permissions as $permission)
                        <li class="collection-item"> 
                            <b>{{ $permission->name }}</b>  <br/> 
                            {{ $permission->description }}
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('permissions.roles')</span>
                    <h6>Role Creation</h6>
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="row mb-0">
                            <div class="col s12 m6 input-field">
                                <label for="role_name">Name</label>
                                <input type="text" name="name" class="char-count" data-length="50" id="role_name" maxlength="50" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="helper-text red-text">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col s12 m6 input-field">
                                <label for="role_description">Description</label>
                                <input type="text" name="description" class="char-count" data-length="255" id="role_description" maxlength="50" 
                                        value="{{ old('description') }}" required>
                                @error('description')
                                    <div class="helper-text red-text">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col s12 m8 input-field">
      
                                <select name="permissions" id="role_permissions" multiple>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                <label for="role_permissions">Permissions</label>
                                @error('description')
                                    <div class="helper-text red-text">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col s12 m2">
                                <button type="submit" class="btn mt-2"><i class="material-icons">add</i></button>
                            </div>
                        </div>
                    </form>
                    <h6>Role List</h6>
                    @foreach ($roles as $role)
                        <ul class="collection">
                            @foreach ($roles as $role)
                                <li class="collection-item">
                                    <div class="row valign-wrapper mb-0">
                                        <div class="col s12 m8">
                                            <b>{{ $role->name }}</b> <br>
                                            {{ $role->description }}
                                        </div>
                                        <div class="col s12 m4 right-align">
                                            <a href="{{ route('admin.roles.show', $role)}}" class="btn btn-flat"><i class="material-icons">keyboard_arrow_right</i></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>

    </div>    
</div>
@endsection