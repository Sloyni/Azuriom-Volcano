<div class="shop-sidebar">
    @guest
        <a class="login" href="{{ route('shop.cart.index') }}">{{ trans('shop::messages.cart.title') }}</a>
    @else
        <div class="top-user-info">
            <img src="{{ auth()->user()->getAvatar(150) }}" class="rounded img-fluid" alt="{{ auth()->user()->name }}">
            <h3>{{ auth()->user()->name }}</h3>
            @if(use_site_money())
                <p style="margin-bottom: 15px" class="text-center"><i class="fas fa-coins"></i> {{ trans('messages.fields.money') }}: <span>{{ format_money(auth()->user()->money) }}</span></p>
                <a href="{{ route('shop.offers.select') }}">{{ trans('shop::messages.cart.credit') }}</a>
            @endif

            <a @if(!use_site_money())style="margin-top: 20px"@endif href="{{ route('shop.cart.index') }}">{{ trans('shop::messages.cart.title') }}</a>
        </div>
    @endguest

    <div class="list-group mb-3 mt-3 categories">
        @foreach($categories as $subCategory)
            <a href="{{ route('shop.categories.show', $subCategory) }}" class="list-group-item @if($category->is($subCategory)) active @endif">{{ $subCategory->name }}</a>
            @foreach($subCategory->categories ?? [] as $cat)
                <a href="{{ route('shop.categories.show', $cat) }}" class="sub-category @if($category->is($cat)) active @endif">
                    {{ $cat->name }}
                </a>
            @endforeach
        @endforeach
    </div>

    @if($goal)
        <div class="mb-4">
            <h4>{{ trans('shop::messages.month-goal') }}</h4>

            <div class="progress mb-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $goal }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $goal }}%"></div>
            </div>

            <p class="text-center">{{ trans_choice('shop::messages.month-goal-current', $goal) }}</p>
        </div>
    @endif
</div>