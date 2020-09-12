@extends('layouts.app')
@section('content')
{{ $manual }}
<iframe src="{{ asset("storage/" . $manual->source_path) }}" frameborder="0" style="width: 100%; height: 1000px;"></iframe>
@endsection