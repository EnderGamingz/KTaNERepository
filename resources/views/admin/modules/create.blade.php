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
    <form action="{{ route('admin.modules.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col s12 m8">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">@lang('modules.create')</span>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection