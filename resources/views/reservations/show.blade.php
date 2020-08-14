@extends('backend.backend')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Reservation for customer</h3>
			</div>
		</div>
<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Reservation for customer</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />									
									<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('reservations.update', ['reservation'=> $reservation]) }}">
										{{method_field('PATCH')}}
										{{ csrf_field() }}
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="full-name">Full Name<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="full-name" required="required" class="form-control " name="fullName" disabled value="{{ $reservation->customer->getFullName() }}">
											</div>
										</div>

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="email" name="email">Email<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="email" required="required" class="form-control" name="email" disabled value="{{ $reservation->customer->email }}">
											</div>
										</div>
										<div class="item form-group">
											<label for="date" class="col-form-label col-md-3 col-sm-3 label-align" name="number_people">Number of people<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="date" class="form-control" type="text" name="number_people" value="{{ $reservation->number_people }}">
											</div>
										</div>
										<div class="item form-group">
											<label for="time" class="col-form-label col-md-3 col-sm-3 label-align" name="booking_time">Time to come<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="time" class="form-control" type="text" name="booking_time" value="{{ $reservation->booking_time }}">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button class="btn btn-primary" type="button">Cancel</button>
												<button class="btn btn-primary" type="reset">Reset</button>
												<button type="submit" class="btn btn-success">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>	
		</div>
	</div>
@endsection
