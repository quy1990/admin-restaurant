@extends('backend.backend')

@section('content')
    <form class="form-horizontal form-label-left" method="POST" action="{{ route('restaurants.store') }}">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Restaurant Register</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Restaurant Register <small>Register form</small></h2>
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
                                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Restaurant's
                                                Name <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="name" required="required" class="form-control "
                                                       name="name">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="address"
                                                   name="adress">Restaurant's Address <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="address" required="required" class="form-control"
                                                       name="address">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="middle-name"
                                                   class="col-form-label col-md-3 col-sm-3 label-align" name="email">Restaurant's
                                                Email<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="middle-name" class="form-control" type="text" name="email">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="middle-name"
                                                   class="col-form-label col-md-3 col-sm-3 label-align"
                                                   name="seat_number">Seat Number<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="middle-name" class="form-control" type="text"
                                                       name="seat_number">
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6 offset-md-3">
                                                <button class="btn btn-primary" type="button">Cancel</button>
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
</form>
@endsection
