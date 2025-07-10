<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Contact 1</h1>
    <p>{{$name}}</p>

    @if($name != "Steve")
        <p>Tu nombre no es Steve</p>
    @else
        <p>Tu nombre es Steve</p>
    @endif

    <ul>
        @foreach($letters as $item)
            <li>{{$item}}</li>
        @endforeach
    </ul>
    
</body>
</html>