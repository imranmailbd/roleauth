@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Dashboard</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        <a class="btn btn-lg btn-primary" href="http://md-imran.com" role="button">Md. Imran&raquo;</a>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">Home Page Content Here.</p>
        @endguest
    </div>
@endsection