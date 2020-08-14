@extends('backend.backend')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row" style="display: inline-block;" >
    <div class="tile_count">
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Reservation</span>
        <div class="count">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Today</span>
        <div class="count">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Tomorrow</span>
        <div class="count green">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Last week</span>
        <div class="count">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
        <div class="count">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
        <div class="count">{{ count($reservations) }}</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
      </div>
    </div>
  </div>
    <!-- /top tiles -->

    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Customer Reservation</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
          <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
            <thead>
              <tr>
                <th>
     <th><input type="checkbox" id="check-all" ></th>
    </th>
                <th>Customer Name(first and last name)</th>
                <th>Number of people</th>
                <th>Email/contact</th>
                <th>Time to go</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reservations as $reservation)
                <tr>
                  <td>
                  <th><input type="checkbox" id="check-all" ></th>
                  </td>
                  <td>{{ $reservation->user()->first()->getFullName() }}</td>
                  <td>{{ $reservation->number_people }}</td>
                  <td>{{ $reservation->user()->first()->email }}</td>
                  <td>{{ $reservation->booking_time }}</td>
                  <td>
                    <a href="{{ route('reservations.show', ['reservation' => $reservation->id]) }}">View</a>/
                    <a href="{{ route('reservations.destroy',['reservation' => $reservation->id]) }}">Delete</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
    </div>
  </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection
