@extends('layouts.app')

@section('content')
<div class="container">
    <h1>@lang('dashboard.title')</h1>
    <div class="row">
        <div class="col s12 m8 l6">
            <div class="card">
                <div class="card-content">
                    <div class="row valing-wrapper">
                        <div class="col m8 mb-0">
                            <span class="card-title mb-0">@lang('dashboard.modules')</span>
                        </div>
                        <div class="col m4 right-align">
                            <a class="btn btn-flat waves-effect" href="{{ route('modules.create') }}">@lang('modules.submit_new')</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <ul class="collection mb-0">
                        @forelse ($modules as $module)
                            
                        @empty
                            <li class="collection-item">@lang('modules.list_empty')</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
