@extends('layouts.app')

@section('content')
<div class="container">
    <h1>@lang('dashboard.title')</h1>
    <div class="row">
        <div class="col s12 m10 l8 xl6">
            <div class="card">
                <div class="card-content">
                    <div class="row valing-wrapper">
                        <div class="col m8 mb-0">
                            <span class="card-title mb-0">@lang('dashboard.modules') ({{ $modules->count() }})</span>
                        </div>
                        <div class="col m4 right-align">
                            <a class="btn btn-flat waves-effect" href="{{ route('modules.create') }}">@lang('modules.submit_new')</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <ul class="collection mb-0">
                        @forelse ($modules as $module)
                            <li class="collection-item">
                                <div class="row mb-0 valign-wrapper">
                                    <div class="col m8 m10">
                                        <b>{{ $module->name }}</b> ({{ $module->uid }}) <br>
                                        @if (!$module->approved)
                                        <span class="red-text">Module's approval is pending</span>
                                        @endif
                                    </div>
                                    <div class="col s4 m2 right-align">
                                        <a href="{{ route('modules.show', $module->uid) }}" class="btn btn-flat">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                        </a>
                                    </div>
                                </div>
                            </li>
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
