<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Дэшборд') }}
        </h2>
    </x-slot>
    <style>
        .editable-buttons{
            display: none;
        }
        #name:focus {
            outline: none;
            box-shadow: none;
            border-color: initial;
        }
        #number:focus {
            outline: none;
            box-shadow: none;
            border-color: initial;
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div style="display: flex; justify-content: space-between; align-items: center">
                    <input style="border-radius: 10px; margin-left: 5px; margin-right: 5px;margin-top: 5px" id="myInput" type="text"  placeholder="Поиск..">
                    <button type="button" class="btn btn-primary"style="margin-right: 5px;margin-top: 2px" data-bs-toggle="modal" data-bs-target="#myModal">
                        Импорт
                    </button>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Добавление таблицы</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" accept=".csv">
                                    <button type="submit" class="btn btn-success">Загрузить</button>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                @error('file')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th style="text-align: left" class="col-md-6" scope="col">Наименование</th>
                        <th style="text-align: left" class="col-md-5" scope="col">Некое число</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($fields as $field)
                        <tr>
                            <td class="align-middle" style="text-align: left">
                                <a href="" class="updateName" data-name="name" data-type="text" data-pk="{{ $field->id }}" data-title="Enter name">{{ $field->name }}</a>
                            </td>
                            <td style="text-align: left" class="align-middle">
                                <a href="" class="updateNumber" data-name="number" data-type="text" data-pk="{{ $field->id }}" data-title="Enter number">{{ $field->number }}</a>
                            </td>
                            <td class="align-middle">
                                <a class="deleteField btn" data-id="{{ $field->id }}"><img style="width: 1.5vw" src="{{asset('images/del.png')}}" alt="delete"></a>
                            </td>
                        </tr>
                    @endforeach
                    <form id="add-field-form" action="{{ route('fields.store') }}" method="POST">
                        @csrf
                        <tr>
                            <td>
                                <input placeholder="Введите наименование..." style="border: 0;border-radius: 15px;background-color: #00000000;outline:none;"  type="text" class="form-control" id="name" name="name" required>
                            </td>
                            <td>
                                <input placeholder="Введите число..."  style="border: 0;border-radius: 15px;background-color: #00000000" type="text" class="form-control" id="number" name="number" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </td>
                        </tr>
                    </form>

                    </tbody>
                </table>
                <script type="text/javascript">
                    $.fn.editable.defaults.mode = 'inline';

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    $('.updateName').editable({
                        url: "{{ route('fields.update') }}",
                        type: 'text',
                        pk: 1,
                        name: 'name',
                        title: 'Enter name',
                        validate: function(value) {
                            if (value.length > 40) {
                                return 'Поле не должно превышать 40 символов.';
                            }
                        }
                    });

                    $('.updateNumber').editable({
                        url: "{{ route('fields.update') }}",
                        type: 'text',
                        pk: 1,
                        number: 'number',
                        title: 'Enter number',
                        validate: function(value) {
                            if (!/^\d+(\.\d{1,2})?$/.test(value)) {
                                return 'Поле должно содержать только числа.';
                            }
                            if (value.length > 10) {
                                return 'Поле не должно превышать 10 символов.';
                            }
                        }
                    });

                    $(".deleteField").click(function(){
                        $(this).parents('tr').hide();
                        var id = $(this).data("id");
                        var token = '{{ csrf_token() }}';
                        $.ajax(
                            {
                                method:'POST',
                                url: "fields/delete/"+id,
                                data: {_token: token}
                            });
                    });

                    $(document).ready(function(){
                        $("#myInput").on("keyup", function() {
                            var value = $(this).val().toLowerCase();
                            $("#myTable tr").filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });


                </script>
            </div>
        </div>
    </div>
</x-app-layout>
