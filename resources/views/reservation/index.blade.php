@extends('layouts.app')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <!-- top tiles -->
    @include("layouts.topTile")
    <!-- /top tiles -->
        <!-- table -->
    @include("reservation.table")
    <!-- /table -->
    </div>
    <!-- /page content -->
@endsection

