<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Наименование</th>
            <th scope="col">Некое число</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fields as $field)
            <tr>
                <td>{{$field->name}}</td>
                <td>{{$field->number}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
