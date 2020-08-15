<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Users</h2>
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Registered at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('customers.show', ['customer' => $user->id]) }}">
                                                    <button class="btn btn-success btn-sm rounded-0"
                                                            type="button"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                    <button class="btn btn-danger btn-sm rounded-0"
                                                            type="submit"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td><a href="{{ route('customers.show', ['customer' => $user->id]) }}">{{ $user->getFullName() }}</a></td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
