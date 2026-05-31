@extends('adminlte::page')

@section('title', 'Manage Staff Sales Report')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-4 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="row p-3">
    <div class="col-12">
   <h3>Staff Sales Performance Report for {{\Carbon\Carbon::create()->month($month)->format('F')}} {{$year}}</h3>
        <div class="d-flex justify-content-end p-4">
          <a href="/search-performance" class="btn btn-primary">Search New Staff Sales Performance</a>
        </div>
<div class="table-responsive bg-white p-2"  id="printable">
           <p>Staff Sales Performance Report for {{\Carbon\Carbon::create()->month($month)->format('F')}} {{$year}}</p>
        <table class="table table-striped">
          <thead>
            <th>S/N</th>
            <th>Staff Name</th>
            <th>Staff Reg. No</th>
             <th>Branch</th>
            <th>Total Sales</th>
          </thead>
          <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{$i++}}</td>
                <td>{{ucwords($result->surname) ?? ''}} {{ucwords($result->first_name) ?? ''}} {{ucwords($result->othername) ?? ''}}</td>
                <td>{{ucwords($result->reg_no) ?? ''}}</td>
                 <td>{{ucwords($result->branch_name) ?? ''}}</td>
                
                <td>
                 {{number_format($result->total) ?? ''}}
                </td>
                
               
            </tr>
            @endforeach
          </tbody>
        </table>

        </div>
        
      <div class="text-right mt-3">
          
            <button class="btn btn-sm btn-primary" onclick="printDiv('printable')">Print</button>
      </div>

</div>
</div>

  
</div>
</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    <script>
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
    </script>
@stop