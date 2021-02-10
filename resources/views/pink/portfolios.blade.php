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
@section('copy')
    {!! $copyright !!}
@endsection


