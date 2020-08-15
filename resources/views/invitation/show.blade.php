@extends('backend.backend')

@section('content')
    <form class="form-horizontal form-label-left" method="POST"
          action="{{ route('invitations.update', $invitation->id) }}">
        @method("PUT")
        @csrf
        <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Invitation Edit</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Invitation Edit</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br/>
                                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                   for="restaurant">Restaurant
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="name" required="required" class="form-control "
                                                       name="restaurant"
                                                       value="{{$invitation->restaurant?$invitation->restaurant->getFullName():"No data"}}">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="user"
                                                   name="user">User <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="user" required="required" class="form-control"
                                                       name="user"
                                                       value="{{$invitation->user?$invitation->user->getFullName():"No data"}}">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="middle-name"
                                                   class="col-form-label col-md-3 col-sm-3 label-align"
                                                   name="booking_time">Booking Time<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="middle-name" class="form-control" type="text"
                                                       name="booking_time"
                                                       value="{{$invitation->reservation->booking_time}}">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="middle-name"
                                                   class="col-form-label col-md-3 col-sm-3 label-align"
                                                   name="booking_time">Messages</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <textarea id="middle-name" class="form-control" rows="5" type="textarea"
                                                          name="message">{!! $invitation->message !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6 offset-md-3">
                                                <button class="btn btn-primary" type="button">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @include("invitedPeople.table")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
