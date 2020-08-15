@extends('layouts.app')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <!-- top tiles -->
        @include("customer.topTile")
        <!-- /top tiles -->
        <!-- table -->
        @include("customer.table")
        <!-- /table -->
    </div>
    <!-- /page content -->
@endsection
