@extends(env('THEME').'.layouts.site')
@section('epilog')
    {!! $epilog !!}
@endsection
@section('navigation')
    {!! $navigation !!}
@endsection
@section('content')
    {!! $content !!}
@endsection
@section('bar')
    {!! $rightBar ?? '' !!}
@endsection
@section('copy')
    {!! $copyright !!}
@endsection
