@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="breadcrumb">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('admin.index') }}" class="breadcrumb">@lang('admin.title')</a>
                <a href="{{ route('admin.modules.index') }}" class="breadcrumb">@lang('modules.title')</a>
                <a href="{{ route('admin.modules.create') }}" class="breadcrumb">@lang('modules.create')</a>
            </div>
        </div>
    </nav>
    <create-module url="{{ route('admin.modules.store') }}" tag_url="{{ route('api.tags.index') }}"></create-module>
</div>
@endsection

@section('scripts')
    <script>
        $('#name').on('input', (e) => {
            
        });
    </script>
@endsection