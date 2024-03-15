<div>
        
</div>

<section class="sideBar col-xs-2  col-md-3 col-lg-2">
        <ul>
                <li>
                        <a class="user-data text-center list-group-item">
                                @auth
                                <img class="logo img-responsive img-circle img-thumbnail" src="{{asset('images/pixi.jpg')}}">
                                <h4><span>{{ Auth::user()->name }}</span></h4>
                                @endauth
                        </a>
                </li>
                <li><a class="sidebare-button list-group-item" href="{{route('users.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.users") }}</span></a></li>
                <li><a class="sidebare-button list-group-item" href="{{route('governorates.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.governorates") }}</span></a></li>
                <li><a class="sidebare-button list-group-item" href="{{route('cities.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.cities") }}</span></a></li>
                <li><a class="sidebare-button list-group-item" href="{{route('clients.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.clients") }}</span></a></li>
                <li><a class="list-group-item" href="{{route('visits.index')}}"><span class="fa fa-product-hunt"></span> <span>{{ __("lang.visits") }}</span></a></li>
                <li><a class="list-group-item" href="{{route('activity-logs.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.activity_log") }}</a></li>
                <li><a class="list-group-item" href="{{route('services.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.services") }}</a></li>
                <li><a class="list-group-item" href="{{route('reasons.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.reasons") }}</a></li>
                <li><a class="list-group-item" href="{{route('industries.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.industries") }}</a></li>
                <li><a class="list-group-item" href="{{route('sources.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.sources") }}</a></li>
                <li><a class="list-group-item" href="{{route('calls.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.calls") }}</a></li>
                <li><a class="list-group-item" href="{{route('meetings.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.meetings") }}</a></li>
                <li><a class="list-group-item" href="{{route('whatsapp-templates.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.whatsapp_templates") }}</a></li>
                <li><a class="list-group-item" href="{{route('whatsapp-messages.index')}}"></span> <span class="fa fa-users"></span> <span>{{ __("lang.whatsapp_messages") }}</a></li>
        </ul>
</section>