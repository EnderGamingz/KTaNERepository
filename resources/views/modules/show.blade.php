@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <div class="row valign-wrapper">
            <div class="col m1">
                <a href="{{ url()->previous() }}" class="btn btn-floating btn-large"><i class="material-icons">keyboard_arrow_left</i></a>
            </div>
            <div class="col m10">
                <h1 class="m-0">{{ $module->name }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Information</span>
                        {{ $module->description }}
                        <div class="row mt-2">
                            <div class="col m6">
                                <h6>Expert Difficulty</h6>
                                {{ $module->difficultyToString($module->expert_difficulty) }} ({{ $module->expert_difficulty }})
                            </div>
                            <div class="col m6">
                                <h6>Defuser Difficulty</h6>
                                {{ $module->difficultyToString($module->defuser_difficulty) }} ({{ $module->defuser_difficulty }})
                            </div>
                        </div>
                        @if($module->tags)
                        <div class="mt-2">
                            <h6>Tags</h6>
                            @foreach ($module->tags as $tag)
                                <div class="chip">{{ $tag->name }}</div>
                            @endforeach
                        </div>
                        @endif
                        <div class="mt-2">
                            <h6>Publisher</h6>
                            {{ $module->publisher->username }}
                        </div>
                        @if($module->maintainer)
                        <div class="mt-2">
                            <h6>Maintainer</h6>
                            {{ implode(',', $module->maintainer->pluck('username')) }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manuals</span>
                        @if($module->manuals && $module->manuals->count() > 0)
                        @else
                            <div class="red-text">
                                No manuals avaliable
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection