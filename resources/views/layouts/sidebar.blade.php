<div>
        
</div>

<section class="sideBar col-xs-2  col-md-3 col-lg-2 text-left">
        <ul>
                <li>
                        <a class="user-data text-center list-group-item">
                                <img class="user-img img-responsive img-circle img-thumbnail" src="{{asset('images/default.jpg')}}">
                                <h4><span>{{ Auth::user()->name }}</span></h4>
                                <a class="text-center list-group-item active" href="{{url("/settings")}}"><span>{{ __("lang.profile") }}</span></a>
                        </a>
                </li>
                <li><a class="sidebare-button list-group-item" href="{{route('governorates.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.governorates") }}</span></a></li>
                <li><a class="sidebare-button list-group-item" href="{{route('cities.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.cities") }}</span></a></li>
                <li><a class="sidebare-button list-group-item" href="{{route('clients.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.clients") }}</span></a></li>
                <li><a class="list-group-item" href="{{route('visits.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.visits") }}</span></a></li>
                <li><a class="list-group-item" href="{{route('activity-logs.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.activity_log") }}</a></li>
                <li><a class="list-group-item" href="{{route('services.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.services") }}</a></li>
                <li><a class="list-group-item" href="{{route('reasons.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.reasons") }}</a></li>
                <li><a class="list-group-item" href="{{route('reasons.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.targets") }}</a></li>
        </ul>
</section>