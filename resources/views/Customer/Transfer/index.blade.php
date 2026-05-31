@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Transfer</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section>
<div class="container-fluid bg-white">
<div class="row">
<div class="col-lg-12 shelter">


<div class="card  ">

<div class="col-lg-12">
@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

</div>

    
    <div class=" col-lg-6 offset-lg-3 pt-4">
     <div class="bg-light p-3">
            <h4 class="fw-bold">Available Balance: {{number_format(auth()->user()->customerProfile->wallet_balance,2) ?? 0}}</h4>
     </div>
     <form method="post" action="javascript:void(0)" id="initiateTransferForm">
        <p>Transfer fund to another quickmann customer</p>
        <label>Customer ID/Email</label>
        <input type="text" class="form-control" name="account" placeholder="Enter Customer ID or Customer Email" >
        
        <button class="btn btn-success btn-block mt-3">Verify Account</button>
        
        </form>
        
        <form method="post" action="{{route('transfer')}}" id="transferForm" style="display:none">
            @csrf()
        <p>Transfer fund to another quickmann customer</p>
        <label>Customer ID/Email</label>
        <input type="text" class="form-control" name="account" placeholder="Enter Customer ID or Customer Email" readonly  id="acc">
        
        <h5 class="mt-2 mb-2"><strong>NAME:</strong> <span id="acc_name"></span></h5>
        
     <input type="amount"  step="any" class="form-control" name="amount" placeholder="Enter Amount" required >
        
        <button class="btn btn-success btn-block mt-3">Transfer</button>
        
        </form>
    </div>
    <form >
        
    </form>
</div>
</div>
</div>
</div>
</section>
</main>

@endsection



@section('js')

<script>

  document.getElementById('initiateTransferForm').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = document.getElementById('initiateTransferForm');
  const formData = new FormData(form);
  const formDataObject = {};

  for (const [name, value] of formData) {
    formDataObject[name] = value;
  }

  const data =formDataObject;
    const url ="{{route('initiate_transfer')}}"
    
    postData(url, data,false,true);
  });
  
  
  
    function removeErrorMessages() {
  const errorMessages = document.querySelectorAll('.error-message');
  
  // Loop through each element with the 'error-message' class and remove them
  errorMessages.forEach(errorMessage => errorMessage.remove());
}

    


  async function postData(url, data , reload, info) {
    
    try {
      removeErrorMessages()
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Replace with your actual CSRF token
        },
        body: JSON.stringify(data)
      });

      const responseData = await response.json();
      if (!response.ok) {
        if (response.status == 422) {
          validationResponse(responseData.data.errors);
        } else {
            alert(responseData.message);
        }

      } else {
         if(response.status==200)
         {
             
             if(info)
             {
                 
                 let rData = responseData.data
                 console.log(rData)
                 let name = rData.surname + " "+rData.first_name+" "+rData.othername
                 
                 document.getElementById('acc').value= data.account
                document.getElementById('acc_name').innerHTML = name.toUpperCase();

                document.getElementById('initiateTransferForm').style.display="none"
                
                 document.getElementById('transferForm').style.display="block"
             }
             

            
         }
        
        if(reload)
        {
          window.location.reload()
        }

      }
    } catch (error) {
        //errorToastr("error occured")
    }
  }
  </script>
  
  
    <script>
  function validationResponse(errors) {
  // Clear previous error messages
  const errorSpans = document.querySelectorAll('.error-message');
  errorSpans.forEach(span => span.remove());

  const fieldNames = Object.keys(errors);

  fieldNames.forEach(fieldName => {
    const inputField = document.querySelector(`form [name="${fieldName}"], form [name="${fieldName}[]"]`);
    const passInput = document.querySelector(".auth-pass-inputgroup"); // Change getElementsByClassName to querySelector

    
    if (inputField) {
      const errorMessage = errors[fieldName];
      
      const errorSpan = document.createElement('span');
      errorSpan.className = 'error-message text-danger';
      errorSpan.innerText = errorMessage;
      
      if (fieldName === "password") {
        passInput.insertAdjacentElement('afterend', errorSpan);
      } else {
        inputField.insertAdjacentElement('afterend', errorSpan);
      }
    }
  });
}
        </script>
@endsection


