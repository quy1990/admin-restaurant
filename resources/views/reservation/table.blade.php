<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Reservation</h2>
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
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Restaurant</th>
                                <th>Customer</th>
                                <th>Number People</th>
                                <th>Booking Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('reservations.show', ['reservation' => $reservation->id]) }}">
                                                    <button class="btn btn-success btn-sm rounded-0"
                                                            type="button"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="POST" class=""
                                                      action="{{ route('reservations.destroy',['reservation' => $reservation->id]) }}">@method('DELETE')@csrf
                                                    <button class="btn btn-danger btn-sm rounded-0"
                                                            type="submit"
                                                            onclick="return confirm('Are you sure?')"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('restaurants.show', ['restaurant' => $reservation->restaurant->id]) }}">{{ $reservation->restaurant->getFullName() }}</a>
                                    </td>
                                    <td>{{ $reservation->user->getFullName() }}</td>
                                    <td>{{ $reservation->number_people }}</td>
                                    <td>{{ $reservation->booking_time }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$reservations->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
