@extends('Template/menu')
@section('title','Input case and active')
@section('content')
    <h1>Hello Page 2</h1>
    <button type="submit" onclick="btnclick()">Click</button>
@endsection

@push('script')
    <script>
        $('#secondpage').addClass('active');
    </script>
    <script src="{{asset('public/js/contents/second.js')}}"></script>
@endpush
