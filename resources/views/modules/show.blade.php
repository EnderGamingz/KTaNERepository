@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row valign-wrapper">
        <div class="col m1 left-align">
            <a href="{{ url()->previous() }}" class="btn btn-floating btn-large"><i class="material-icons">keyboard_arrow_left</i></a>
        </div>
        <div class="col m11">
            <h1 class="m-0">{{ $module->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col m6">
            @if(!$module->approved && Auth::user()->can('approve', $module))
            <div class="card-panel">
                <div class="row mb-0 valign-wrapper">
                    <div class="col m6">
                        Approving this module
                    </div>
                    <div class="col m6 right-align">
                        <form action="{{ route('modules.approve', $module->uid) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button class="btn btn-flat">Approve</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-content">
                    <div class="row mb-0 valign-wrapper">
                        <div class="col m8">
                            <span class="card-title mb-0">Information</span>
                        </div>
                        <div class="col m4 right-align">
                            @can('update', $module)
                            <a href="{{ route('modules.edit', $module->uid) }}" class="btn btn-flat"><i class="material-icons left">edit</i> Edit</a>
                            @endcan
                        </div>
                    </div>
                    @if(!$module->approved)
                    <span class="orange-text">Module has been submitted but not approved yet</span>
                    <br>
                    @endif
                    <p>{{ $module->description }}</p>
                    <a target="_blank" href="https://steamcommunity.com/sharedfiles/filedetails/?id={{ $module->steam_id }}" class="btn btn-flat"><i class="material-icons left">videogame_asset</i>VISIT WORKSHOP</a>
                    @if($module->links)
                    <div class="mt-2">
                        <h6>Additonal Links</h6>
                        @foreach ($module->links as $link)
                            @if($link->name == "github")
                                <a target="_blank" class="btn btn-floating waves-effect mr-2" href="{{ $link->link }}"><i class="material-icons">code</i></a>
                            @endif
                            @if($link->name == "website")
                                <a target="_blank" class="btn btn-floating waves-effect mr-2" href="{{ $link->link }}"><i class="material-icons">public</i></a>
                            @endif
                        @endforeach
                    </div>
                    @endif
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
                    <div class="mt-2">
                        <h6>Module ID</h6>
                        {{ $module->uid }}
                    </div>
                    @if($module->tags && $module->tags->count() > 0)
                    <div class="mt-2">
                        <h6>Tags</h6>
                        @foreach ($module->tags as $tag)
                        <div class="chip">{{ $tag->name }}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="mt-2">
                        <h6>Publisher</h6>
                        <i>{{ $module->publisher->username }}</i>
                    </div>
                    @if($module->maintainer)
                    <div class="mt-2">
                        <h6>Maintainer</h6>
                        {{ implode(',', $module->maintainer->pluck('username')) }}
                    </div>
                    @endif
                </div>
                <div class="card-action">
                    <button class="btn btn-flat"><i class="material-icons left">code</i> Generate JSON</button>
                    <a target="_blank" href="{{ route('api.modules.show', $module->uid) }}" class="btn btn-flat"><i class="material-icons left">api</i> Show API</a>
                </div>
            </div>
            @if(($module->capabilities && $module->capabilities->count() > 0 ) || Gate::check('update', $module))
            <div class="card">
                <div class="card-content pb-1">
                    <div class="row">
                        <div class="col m8">
                            <span class="card-title mb-0">Capabilities</span>
                        </div>
                        <div class="col m4 right-align">
                            @can('update', $module)
                            <button class="btn btn-flat modal-trigger" data-target="addCapabilityModal"><i class="material-icons">add</i></button>
                            @endcan
                        </div>
                    </div>
                    @if($module->capabilities->count() == 0)
                    <span class="orange-text">No defined capabilities</span>
                    @endif
                </div>
                @if($module->capabilities->count() > 0)                    
                <ul class="collapsible">
                    @foreach ($module->capabilities as $capability)
                    <li>
                        <div class="collapsible-header"><i class="material-icons right">keyboard_arrow_down</i> {{ $capability->name }}</div>
                        <div class="collapsible-body pt-0">
                            <pre>{{ json_encode($capability->data) }}</pre>
                            @can('update', $module)
                            <form action="{{ route('modules.capabilities.destroy', [$module->uid, $capability->name]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-flat" type="submit">Remove</button>
                            </form>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endif
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

@can('update', $module)
<add-module-capability url="{{ route('modules.capabilities.store', $module->uid) }}" raw_capabilities='{{ $module->capabilities ? $module->capabilities->pluck('name') : '[]' }}'></add-module-capability>
@endcan

@endsection