<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
                <td>
                    <a href="" class="update" data-name="name" data-type="text" data-pk="{{ $field->id }}" data-title="Enter name">{{ $field->name }}</a>
                </td>
                <td>
                    <a href="" class="update" data-name="name" data-type="text" data-pk="{{ $field->id }}" data-title="Enter number">{{ $field->number }}</a>
                </td>
                <td>
                    <a class="deleteProduct btn btn-xs btn-danger" data-id="{{ $field->id }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $.fn.editable.defaults.mode = 'inline';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('.update').editable({
        url: "{{ route('fields.update') }}",
        type: 'text',
        pk: 1,
        name: 'name',
        title: 'Enter name'
    });

    $(".deleteProduct").click(function(){
        $(this).parents('tr').hide();
        var id = $(this).data("id");
        var token = '{{ csrf_token() }}';
        $.ajax(
            {
                method:'POST',
                url: "delete/"+id,
                data: {_token: token},
                success: function(data)
                {
                    toastr.success('Successfully!','Delete');
                }
            });
    });
</script>
</body>
</html>
