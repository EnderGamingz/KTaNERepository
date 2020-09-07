{{-- The create view is only for authenticated users --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('dashboard') }}" class="breadcrumb">@lang('dashboard.title')</a>
                <a href="{{ route('modules.create') }}" class="breadcrumb">@lang('modules.create')</a>
            </div>
        </div>
    </nav>
    <create-module url="{{ route('modules.store') }}" tag_url="{{ route('api.tags.index') }}"></create-module>
</div>
@endsection