<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <input id="myInput" type="text" placeholder="Поиск..">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Новая таблица
                </button>
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Добавление новой таблицы</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" accept=".csv">
                                    <button type="submit" class="btn btn-success">Загрузить</button>
                                </form>
                            </div>

                            <!-- Modal footer -->
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
                        <th scope="col">Наименование</th>
                        <th scope="col">Некое число</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($fields as $field)
                        <tr>
                            <td>
                                <a href="" class="updateName" data-name="name" data-type="text" data-pk="{{ $field->id }}" data-title="Enter name">{{ $field->name }}</a>
                            </td>
                            <td>
                                <a href="" class="updateNumber" data-name="number" data-type="text" data-pk="{{ $field->id }}" data-title="Enter number">{{ $field->number }}</a>
                            </td>
                            <td>
                                <a class="deleteField btn btn-xs btn-danger" data-id="{{ $field->id }}">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                    <form id="add-field-form" action="{{ route('fields.store') }}" method="POST">
                        @csrf
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="number" name="number" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Add Field</button>
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
                        title: 'Enter name'
                    });

                    $('.updateNumber').editable({
                        url: "{{ route('fields.update') }}",
                        type: 'text',
                        pk: 1,
                        number: 'number',
                        title: 'Enter number'
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
