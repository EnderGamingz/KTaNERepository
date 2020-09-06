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
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">@lang('modules.create')</span>
                        <div class="row">
                            <div class="col s12 m6 input-field">
                                <label for="name">Name</label>
                                <input type="text" required class="char-count" data-length="100" id="name" name="name" maxlength="100">
                            </div>
                            <div class="col s12 m6 input-field">
                                <input type="text" readonly value=" " id="uid">
                                <label for="uid">UID</label>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="description">Description</label>
                            <input type="text" required class="char-count" data-length="255" id="description" name="description" maxlength="255">
                        </div>
                        <div class="row">
                            <div class="col s12 m6 input-field">
                                <label for="expert_difficulty">Expert Difficulty</label>
                                <input value="1" type="number" min="1" max="100" id="expert_difficulty" name="expert_difficulty" required>
                            </div>
                            <div class="col s12 m6 input-field">
                                <label for="defuser_difficulty">Defuser Difficulty</label>
                                <input value="1" type="number" min="1" max="100" id="defuser_difficulty" name="defuser_difficulty" required>
                            </div>
                        </div>
                        <div class="chips input-field">
                            <input name="tags" id="tags" name="tags" placeholder="Tags">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">@lang('modules.metadata')</span>
                        <div class="row">
                            <div class="col s12 m6 input-field">
                                <label for="key">Key</label>
                                <input type="text" name="key" id="key">
                            </div>
                            <div class="col s12 m6 input-field">
                                <label for="value">Value</label>
                                <textarea class="materialize-textarea" name="value" id="value" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="center">
            <button class="btn">Create</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        $('#name').on('input', (e) => {
            let name = e.target.value;
            name = name.replace(/[^A-Za-z0-9]/mg, '');
            $('#uid').val(name);
        });
        $(document).ready(() => {
            $('#tags').chips({
                autocompeleteOptions: {
                    data: {
                        @foreach(cache('tags') as $tag)
                        '{{ $tag->name }}': null,
                        @endforeach
                    }
                }
            })
        });
    </script>
@endsection