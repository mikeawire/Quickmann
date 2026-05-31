@extends('adminlte::page')

@section('title', 'Customers List')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')


<table class="table table-dark" id="otpViewTable">
<thead>
<tr>
    <th scope="col">#Id</th>
      <th scope="col">Register Number</th>
      <th scope="col">Otp Code</th>
      <th scope="col">Status</th>
</tr>
</thead>
<tbody>
@foreach ($otps as $otp)
<tr>
<th scope="row">{{ $otp->id }}</td>
<td>{{ $otp->phone }}</td>
<td>{{ $otp->otp_code }}</td>
<td>{{ $otp->status }}</td>

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
        $('#otpViewTable').DataTable({
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
