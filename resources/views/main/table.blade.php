<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Include app.css --}}
    <link rel="stylesheet" href="{{asset('public/css/app.css')}}">
    <title>Document</title>
    <style>
        .rotate-text {
            transform: rotate(-90deg); /* Rotate text */
            transform-origin: left bottom; /* Adjust origin for better positioning */
            white-space: nowrap; /* Prevent text wrapping */
            display: inline-block; /* Allow rotation to take effect */
        }
        td {
            vertical-align: middle; /* Center align vertically */
        }
    </style>
</head>
<body>


    <script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
