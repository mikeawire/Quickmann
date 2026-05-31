@extends('adminlte::page')

@section('title', 'Outstanding Balance')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Customer Outstanding Balance</h5>
<br>

<br>
<div class="table-responsive bg-white p-4">


<table class="table table-striped " id="outstandingTable">
</table>


</div></div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    <script>
        $('#outstandingTable').DataTable({
           processing: true,
           serverSide: true,
           "pageLength": 10,
           "paging": true,
      
           "searching": true,
           "ordering": true,
           "bLengthChange": true,
           "responsive": true,
           "lengthChange": true,
           "autoWidth": false,
           "buttons": [{
                   extend: 'copy',
                   text: 'Copy',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
       
               {
                   extend: 'excel',
                   text: 'Excel',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
               {
                   extend: 'csv',
                   text: 'CSV',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
               {
                   extend: 'pdf',
                   text: 'PDF',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
               {
                   extend: 'print',
                   text: 'PRINT',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
               {
                   extend: 'colvis',
                   text: 'Colvis',
                   title: 'Student List ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
       
       
           ],
           
          
           ajax: "/ajax_arrier",
           "dom": 'lBfrtip',
           columns: [
               
              { data: 'id', title: 'S/N' },
              { data: 'name', title: 'Name' },
              { data: 'location_name', title: 'Location Name' },
              { data: 'plot_id', title: 'Plot No' },
              { data: 'amount', title: 'Amount' },
              { data: 'property_price', title: 'Property Price' },
             
           { data: 'button', title: 'Button' },
             
           
            
           ]
        }).buttons(0, null).container().appendTo('#outstandingTable_wrapper .col-md-6:eq(0)');
    </script>
@stop