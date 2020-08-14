@extends('layouts.template')

@section('content')
	<!-- Start Stuff -->
	<div class="stuff-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="heading-title text-center">
						<h2>{{ $restaurant->name }}</h2>
						<p><a href="https://www.google.com/maps/place/{{ $restaurant->adress }}">{{ $restaurant->adress}}</a></p>
					</div>
				</div>
			</div>
				<form class="form-horizontal form-label-left" method="POST" action="{{ route('home.store') }}">
					<input name="_token" type="hidden" value="{{ csrf_token() }}">
					<input name="restaurant_id" type="hidden" value="{{ $restaurant->id }}">
					<input name="customer_id" type="hidden" value="1">
					<div class="form-group row">
						<label class="control-label col-md-3 col-sm-3 ">
							Your Email:
						</label>
						<div class="col-md-9 col-sm-9 ">
							<input type="text" class="form-control" name="email" required="required" value="nguyentuquy2008@gmail.com">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3 col-sm-3 ">
							How many people:
						</label>
						<div class="col-md-9 col-sm-9 ">
							<select class="form-control" name="number_people" required="required">
								<option>Choose option</option>
								<option value="1">1 People</option>
								<option value="2" selected>2 People</option>
								<option value="3">3 People</option>
								<option value="4">4 People</option>
								<option value="8">8 People</option>
								<option value="12">12 People</option>
								<option value="20">20 People</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-md-3 col-sm-3 ">When do you want to come<span class="required">*</span>
						</label>
						<div class="col-md-9 col-sm-9 ">
							<input  name="date" class="date-picker form-control" placeholder="dd-mm-yyyy" type="date" required="required" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
							<script>
								function timeFunctionLong(input) {
									setTimeout(function() {
										input.type = 'text';
									}, 60000);
								}
							</script>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-md-3 col-sm-3 ">Time to come<span class="required">*</span>
						</label>
						<div class="col-md-9 col-sm-9 ">
							<input name="time" type="text" id="clock" value="00:00" required="required">
							<script>
								$(document).ready(function(){
									$("#clock").clockTimePicker({
										required:true,
										separator:'.',
										precision:10,
										duration:true, 
										minimum:'01:00', 
										maximum:'03:00',
										durationNegative:true
									});
								});
							</script>						
						</div>
					</div>
					<button type="submit" class="btn btn-success" style="float: right;">Success</button>
				</form>
		</div>
	</div>
	<!-- End Stuff -->
	
	<!-- Start Contact info -->
	<div class="contact-imfo-box">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<i class="fa fa-volume-control-phone"></i>
					<div class="overflow-hidden">
						<h4>Phone</h4>
						<p class="lead">
							+01 123-456-4590
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<i class="fa fa-envelope"></i>
					<div class="overflow-hidden">
						<h4>Email</h4>
						<p class="lead">
							yourmail@gmail.com
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<i class="fa fa-map-marker"></i>
					<div class="overflow-hidden">
						<h4>Location</h4>
						<p class="lead">
							800, Lorem Street, US
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Contact info -->
	<script src="https://raw.githubusercontent.com/loebi-ch/jquery-clock-timepicker/master/jquery-clock-timepicker.min.js"></script>

	
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-daterangepicker -->
	<script src="../vendors/moment/min/moment.min.js"></script>
	
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="../vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="../vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- jQuery Knob -->
    <script src="../vendors/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- Cropper -->
    <script src="../vendors/cropper/dist/cropper.min.js"></script>

    <!-- Custom Theme Scripts -->
	<script src="../build/js/custom.min.js"></script>
	
    <!-- Custom Theme Scripts -->
	
	
    
    <!-- Initialize datetimepicker -->
	<script  type="text/javascript">
	$(function () {
					$('#myDatepicker').datetimepicker();
				});
		
		$('#myDatepicker2').datetimepicker({
			format: 'DD.MM.YYYY'
		});
		
		$('#myDatepicker3').datetimepicker({
			format: 'hh:mm A'
		});
		
		$('#myDatepicker4').datetimepicker({
			ignoreReadonly: true,
			allowInputToggle: true
		});

		$('#datetimepicker6').datetimepicker();
		
		$('#datetimepicker7').datetimepicker({
			useCurrent: false
		});
		
		$("#datetimepicker6").on("dp.change", function(e) {
			$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
		});
		
		$("#datetimepicker7").on("dp.change", function(e) {
			$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
		});
	</script>
@endsection
