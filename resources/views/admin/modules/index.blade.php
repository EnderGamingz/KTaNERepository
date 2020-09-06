@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
          <div class="col s12">
            <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
            <a href="{{ route('admin.modules.index') }}" class="breadcrumb">@lang('modules.title')</a>
          </div>
        </div>
    </nav>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper">
                        <div class="col s12 m8">
                            <span class="card-title">@lang('modules.title')</span>
                        </div>
                        <div class="col s12 m4 right-align">
                            @can('create.admin.modules')
                            <a href="{{ route('admin.modules.create') }}" class="btn btn-flat">Create</a>
                            @endif
                        </div>
                    </div>
                    
                    <ul class="collection">
                        @forelse ($modules as $module)
                            <li class="collection-item">
                                <div class="row mb-0 valign-wrapper">
                                    <div class="col s12 m8">
                                        <b>{{ $module->uid }}</b> {{ $module->name }}<br>
                                        
                                    </div>
                                    <div class="col s12 m4 right-align">
                                        @can('show.admin.users')
                                        <a class="btn btn-flat" href="{{ route('admin.users.show', $user) }}"><i class="material-icons">keyboard_arrow_right</i></a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="collection-item">No Modules in list</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection