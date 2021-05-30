@section('headChart')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}"> 
    <link rel="stylesheet" href="{{ asset('/css/chart.css') }}"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>@yield('title')</title>
@endsection