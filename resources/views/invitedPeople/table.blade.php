<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Peoples were invited</h2>
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
                                <th>Invitation Messages</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invitedPeoples as $invitedPeople)
                                <tr>
                                    <td>
                                        <a href="{{ route('invitations.show', ['invitation' => $invitedPeople->invitation_id]) }}">{{ $invitedPeople->invitation->message }}</a>
                                    </td>
                                    <td>{{ $invitedPeople->email }}</td>
                                    <td>{{ $invitedPeople->phone }}</td>
                                    <td>{{ $invitedPeople->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$invitedPeoples->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
