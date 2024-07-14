<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<tr>
    <th>Наименование</th>
    <th>Некое число</th>
</tr>
<br>
@foreach ($fields as $field)
    <tr>
        <td>{{$field->name}}</td>
        <td>{{$field->number}}</td>
    </tr>
    <br>
@endforeach
</body>
</html>
