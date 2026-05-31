
@extends('layouts.app')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Find Property</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section>

    <section style="background-color: #eee;">
        <div class="container py-5">
          



            <div class="col-lg-10 offset-lg-1">
                <div class="card mb-8 offset-lg-2">
                  <div class="card-body">
                      <section>
<div class=" calculator">
<div class="row">
<div class="col-lg-8 offset-lg-2 bg-white">
<div class="col-lg-8 offset-lg-2">



<form class=" " method="POST" action="{{ route('findproperty.store') }}"   >
                        @csrf


                <div class="clear"></div>
                <h4 style="margin-block: 20px">


                      <strong>  Find Property </strong> <br> <i class="fa fa-calculator "  ></i>
</h4>

                </div>
<div class="form-group">
<label class=""><span class="text-danger">Step 1: </span>Select State</label>


                    <select  class=" form-control @error('state') is-invalid @enderror"  name="state"
                        autocomplete="state"  style="height:50px;">


                        <option value="" selected="selected">- Select State-</option>
          <option value="Abuja FCT">Abuja FCT</option>
          <option value="Abia">Abia</option>
          <option value="Adamawa">Adamawa</option>
          <option value="Akwa Ibom">Akwa Ibom</option>
          <option value="Anambra">Anambra</option>
          <option value="Bauchi">Bauchi</option>
          <option value="Bayelsa">Bayelsa</option>
          <option value="Benue">Benue</option>
          <option value="Borno">Borno</option>
          <option value="Cross River">Cross River</option>
          <option value="Delta">Delta</option>
          <option value="Ebonyi">Ebonyi</option>
          <option value="Edo">Edo</option>
          <option value="Ekiti">Ekiti</option>
          <option value="Enugu">Enugu</option>
          <option value="Gombe">Gombe</option>
          <option value="Imo">Imo</option>
          <option value="Jigawa">Jigawa</option>
          <option value="Kaduna">Kaduna</option>
          <option value="Kano">Kano</option>
          <option value="Katsina">Katsina</option>
          <option value="Kebbi">Kebbi</option>
          <option value="Kogi">Kogi</option>
          <option value="Kwara">Kwara</option>
          <option value="Lagos">Lagos</option>
          <option value="Nassarawa">Nassarawa</option>
          <option value="Niger">Niger</option>
          <option value="Ogun">Ogun</option>
          <option value="Ondo">Ondo</option>
          <option value="Osun">Osun</option>
          <option value="Oyo">Oyo</option>
          <option value="Plateau">Plateau</option>
          <option value="Rivers">Rivers</option>
          <option value="Sokoto">Sokoto</option>
          <option value="Taraba">Taraba</option>
          <option value="Yobe">Yobe</option>
          <option value="Zamfara">Zamfara</option>
 <option value="Outside Nigeria">Outside Nigeria</option>
</select>

                    @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror



</div>

<div class="form-group">

					<label class=""><span class="text-danger">Step 2: </span>Select Price  Range</label>


						<select  class=" form-control @error('price_range') is-invalid @enderror"  name="price_range"
							autocomplete="mode_of_payment" style="height:50px;" >
                            <option  value="{{ old('price_range') }}">Select Price Range</option>
                            <option value="a"> &#8358;500,000 Less </option>
							<option value="b"> &#8358;500,000  - &#8358;1,000,000 </option>
                            <option value="c">&#8358;1,000,000  - &#8358;1,500,000 </option>
                            <option value="d"> &#8358;1,500,000  - &#8358;3, 000,000 </option>
                            <option value="e"> &#8358;3,000,000  Above</option>
                            <option value="f"> Any Amount </option>
</select>
                        @error('price_range')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
                                <div class="form-group">

					<label class=""><span class="text-danger">Step 3: </span>Select Mode of Payment</label>

						<select  class="form-control @error('mode_of_payment') is-invalid @enderror"  name="mode_of_payment"
							autocomplete="mode_of_payment" style="height:50px;" >
							<option  value="{{ old('mode_of_payment') }}">Mode of Payment</option>
							<option value="Outright">Outright Payment</option>
							<option value="Installment">Installment</option>
</select>
                        @error('mode_of_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


</div>
<div class="form-group">
					<label class=""><span class="text-danger">Step 4: </span>Enter Monthly payment</label>

						<input  type="text" placeholder="&#8358;100,000" class="form-control @error('monthly_payment') is-invalid @enderror" name="monthly_payment"  autocomplete="installation">
                        @error('monthly_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">

					<label class=""><span class="text-danger">Step 5: </span>Enter Initial Payment</label>

                        <input  type="text" placeholder="&#8358;300,000"
                        class=" form-control @error('initial_payment') is-invalid @enderror" name="initial_payment"  autocomplete="initial_payment">
                        @error('initial_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


					<div class="form-group">
						<button class="">
							Search
						</button>
					</div>

				</form>

</div>
</div>

</div>

</div>
</div>
</section>
</main>



  

@endsection
