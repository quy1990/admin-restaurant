<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Invitations</h2>
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
                                <th>Reservation</th>
                                <th>Messages</th>
                                <th>Created Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invitations as $invitation)
                                <tr>
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('invitations.show', ['invitation' => $invitation->id]) }}">
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
                                                      action="{{ route('invitations.destroy',['invitation' => $invitation->id]) }}">@method('DELETE')@csrf
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
                                        <a href="{{ route('reservations.show', ['reservation' => $invitation->reservation->id]) }}">{{ $invitation->reservation->id }}</a>
                                    </td>
                                    <td>{{ $invitation->message }}</td>
                                    <td>{{ $invitation->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$invitations->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
