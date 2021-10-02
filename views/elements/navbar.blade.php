<div class="header-nav @if(!Route::is('home')) small-header @endif" id="header" style="background-position: 0px;background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') top / cover no-repeat">
    <div class="header-nav-top navigation">
        <div class="container navigation-content">
            <ul class="header-nav-top-left">
                @foreach($navbar as $element)
                    @if($loop->index < ($loop->count / 2))
                        @if(!$element->isDropdown())
                            <li class="item @if($element->isCurrent()) active @endif">
                                <a href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $element->name }}</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $element->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                    @foreach($element->elements as $childElement)
                                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
            <ul class="header-nav-top-mid">
                <li class="item">
                    @if(setting('logo'))
                        <img src="{{ image_url(setting('logo')) }}" alt="Logo">
                    @endif
                </li>
            </ul>
            <ul class="header-nav-top-right">
                @foreach($navbar as $element)
                    @if($loop->index >= ($loop->count / 2))
                        @if(!$element->isDropdown())
                            <li class="item @if($element->isCurrent()) active @endif">
                                <a href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $element->name }}</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $element->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                                    @foreach($element->elements as $childElement)
                                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="header-nav-bottom sub-navigation">
        <div class="container">
            <ul class="header-nav-bottom-left">
                <li class="item">
                    <div class="ip">
                        <p>{{ theme_config('server_ip') }}</p>
                    </div>
                </li>
            </ul>
            <ul class="header-nav-bottom-right">
                @guest
                    <li class="item">
                        <a href="{{ route('login') }}">
                            {{ trans('auth.login') }}
                        </a>
                    </li>
                    @if(Route::has('register'))
                        <li class="item">
                            <a href="{{ route('register') }}">
                                {{ trans('auth.register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="item">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- Counter - Notifications -->
                            <i class="fas fa-bell fa-fw"></i>
                            @if(! $notifications->isEmpty())
                                <span class="badge badge-danger" id="notificationsCounter">{{ $notifications->count() }}</span>
                            @endif
                        </a>

                        <!-- Dropdown - Notifications -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                            <h6 class="dropdown-header">{{ trans('messages.notifications.notifications') }}</h6>

                            @if(! $notifications->isEmpty())
                                <div id="notifications">
                                    @foreach($notifications as $notification)
                                        <a href="#" class="dropdown-item media align-items-center">
                                            <div class="mr-3">
                                                <div class="rounded-circle text-white p-1 bg-{{ $notification->level }}">
                                                    <i class="fas fa-{{ $notification->icon() }} fa-fw m-2"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="small">{{ format_date($notification->created_at, true) }}</div>
                                                {{ $notification->content }}
                                            </div>
                                        </a>
                                    @endforeach

                                    <a href="{{ route('notifications.read.all') }}" id="readNotifications" class="dropdown-item text-center small text-gray-500">
                                        <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                                        {{ trans('messages.notifications.read') }}
                                    </a>
                                </div>
                            @endif

                            <div id="noNotificationsLabel" class="dropdown-item text-center small text-success @if(! $notifications->isEmpty()) d-none @endif">
                                <i class="fas fa-check"></i> {{ trans('messages.notifications.empty') }}
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                {{ trans('messages.nav.profile') }}
                            </a>

                            @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                                <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                                    {{ trans($navItem['name']) }}
                                </a>
                            @endforeach

                            @if(Auth::user()->hasAdminAccess())
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    {{ trans('messages.nav.admin') }}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ trans('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="header-content">
        <div class="description">
            <h1>{{ site_name() }}</h1>
            <p>{{ theme_config('subtitle') }}</p>
        </div>
        <div class="go-to-button" id="go-to-bottom">
            <span><i class="fas fa-angle-double-down"></i></span>
        </div>
    </div>
</div>

<div class="header-mobile-nav">
    <div class="mobile-btn" id="mobile-btn">
        <span id="nav-btn-icon"><i class="fas fa-bars"></i></span>
    </div>

    <ul class="mobile-navigation" id="mobile-nav">
        @foreach($navbar as $element)
            @if(!$element->isDropdown())
                <li class="item @if($element->isCurrent()) active @endif">
                    <a href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                        <span class="name">{{ $element->name }}</span>
                    </a>
                </li>
            @else
                <li class="item nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $element->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                        @foreach($element->elements as $childElement)
                            <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                        @endforeach
                    </div>
                </li>
            @endif
        @endforeach
        @guest
            <li class="item">
                <a href="{{ route('login') }}">
                    <span class="name">{{ trans('auth.login') }}</span>
                </a>
            </li>

            @if(Route::has('register'))
                <li class="item">
                    <a href="{{ route('register') }}">
                        <span class="name">{{ trans('auth.register') }}</span>
                    </a>
                </li>
            @endif
        @else
            <li class="item nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- Counter - Notifications -->
                    <i class="fas fa-bell fa-fw"></i>
                    @if(! $notifications->isEmpty())
                        <span class="badge badge-danger" id="notificationsCounter">{{ $notifications->count() }}</span>
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="notificationsDropdown">
                    <h6 class="dropdown-header">{{ trans('messages.notifications.notifications') }}</h6>

                    @if(! $notifications->isEmpty())
                        <div id="notifications">
                            @foreach($notifications as $notification)
                                <a href="#" class="dropdown-item media align-items-center">
                                    <div class="mr-3">
                                        <div class="rounded-circle text-white p-1 bg-{{ $notification->level }}">
                                            <i class="fas fa-{{ $notification->icon() }} fa-fw m-2"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="small">{{ format_date($notification->created_at, true) }}</div>
                                        {{ $notification->content }}
                                    </div>
                                </a>
                            @endforeach

                            <a href="{{ route('notifications.read.all') }}" id="readNotifications" class="dropdown-item text-center small text-gray-500">
                                <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                                {{ trans('messages.notifications.read') }}
                            </a>
                        </div>
                    @endif

                    <div id="noNotificationsLabel" class="dropdown-item text-center small text-success @if(! $notifications->isEmpty()) d-none @endif">
                        <i class="fas fa-check"></i> {{ trans('messages.notifications.empty') }}
                    </div>
                </div>
            </li>

            <li class="item nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="notificationsDropdown">
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        {{ trans('messages.nav.profile') }}
                    </a>

                    @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                        <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                            {{ trans($navItem['name']) }}
                        </a>
                    @endforeach

                    @if(Auth::user()->hasAdminAccess())
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            {{ trans('messages.nav.admin') }}
                        </a>
                    @endif

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ trans('auth.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
