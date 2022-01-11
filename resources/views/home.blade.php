@extends('layouts.app')

@section('content')
    <div class="container" >
        <div id='vue_app_content' data-page="{{ json_encode($page) }}"></div>
    </div>
@endsection
