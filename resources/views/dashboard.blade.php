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
                <a href="{{ route('csv.upload')}}" class="btn btn-primary">Новая таблица</a>
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
                                url: "delete/"+id,
                                data: {_token: token},
                                success: function(data)
                                {
                                    toastr.success('Successfully!','Delete');
                                }
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
