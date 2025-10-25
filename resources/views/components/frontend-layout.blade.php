<!DOCTYPE html>
<html lang="en">
@props(['title', 'description', 'keywords'])
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }} | {{$title}}</title>
     <meta name="description" content="{{$description}}">
    <meta name="keywords" content="{{$keywords}}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/index.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>

<body>
    @include('sweetalert::alert')

    <x-frontend-header />
    <main>
        {{ $slot }}
    </main>
    <x-frontend-footer />
</body>

</html>
