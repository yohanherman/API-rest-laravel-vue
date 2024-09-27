<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ticket</title>
</head>
<body>

        <div>
            @foreach ($datas as $data)
            <p>Auteur: {{$data->name}}</p>
             <p>Date: {{$data->created_at}}</p>
             <p>ticket N° : {{$data->id}}</p>
             <p>Place number: {{$data->place_number}}</p>
            @endforeach
        </div>

</body>
</html>