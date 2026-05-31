@extends('adminlte::page')

@section('title', 'Customers List')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')



<table class="table table-dark" id="accessCodeTable">
<thead>
<tr>
    <th scope="col">#Id</th>
      <th scope="col">Register Number</th>
      <th scope="col">Email</th>
      <th scope="col">Access_code</th>
</tr>
</thead>
<tbody>
@foreach ($access as $acces)
<tr>
<th scope="row">{{ $acces->id }}</td>
<td>{{ $acces->phone }}</td>
<td>{{ $acces->email }}</td>
<td>{{ $acces->access_code }}</td>

</tr>

@endforeach
</table>
@stop
@section('footer')

@stop


@section('css')

@stop

@section('js')
 @livewireScripts


    <script>
        $('#accessCodeTable').DataTable({
           processing: true,

           "pageLength": 10,
           "paging": true,

           "searching": true,
           "ordering": true,
           "bLengthChange": true,
           "responsive": true,
           "lengthChange": true,
           "autoWidth": false,








        });
    </script>



@stop
