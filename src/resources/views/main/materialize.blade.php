@inject('menu', 'Kregel\Menu\Menu')
<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper"> <?php $name = config('kregel.menu.brand.name');?>
                {{-- Here we must make sure that we are checking to see if the name is that of a closure
                     If it is, we need to call the closure. Otherwise we need to just spit out the data. --}}
                @if($name instanceof Closure)

                    <a class="brand-logo" href="{{url(config('kregel.menu.brand.link'))}}"
                       style="padding-left: 10px;">{!! $name() !!}</a>
                @else
                    <a class="brand-logo" href="{{url(config('kregel.menu.brand.link'))}}"
                       style="padding-left: 10px;">{!! $name !!}</a>
                @endif</a>
            <ul class="right hide-on-med-and-down">
                {!! $menu->using('materialize')->config()->devour() !!}
            </ul>
        </div>
    </nav>
</div>