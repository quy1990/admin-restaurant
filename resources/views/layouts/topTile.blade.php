@inject('TopTitleTrait', 'App\Repositories\TopTile')

<div class="row" style="display: inline-block;">
    <div class="tile_count">
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Restaurants</span>
            <div class="count">{{$TopTitleTrait->getCountRestaurant()}}</div>
            <span class="count_bottom"><i class="green">4% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Today</span>
            <div class="count">{{$TopTitleTrait->getCountUser()}}</div>
            <span class="count_bottom"><i class="green"><i
                        class="fa fa-sort-asc"></i>3% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Tomorrow</span>
            <div class="count green">{{$TopTitleTrait->getCountRestaurant()}}</div>
            <span class="count_bottom"><i class="green"><i
                        class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Last week</span>
            <div class="count">{{$TopTitleTrait->getCountRestaurant()}}</div>
            <span class="count_bottom"><i class="red"><i
                        class="fa fa-sort-desc"></i>12% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Reservation</span>
            <div class="count">{{$TopTitleTrait->getCountReservation()}}</div>
            <span class="count_bottom"><i class="green"><i
                        class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Invitation</span>
            <div class="count">{{$TopTitleTrait->getCountInvitation()}}</div>
            <span class="count_bottom"><i class="green"><i
                        class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
    </div>
</div>
