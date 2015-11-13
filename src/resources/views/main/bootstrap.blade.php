@inject('menu', 'Kregel\Menu\Menu')
<style>
    .user.user-menu > .dropdown-menu {
        width: 20em;
        padding: 0;
    }

    .user.user-menu > .dropdown-menu > .user-header {
        padding: 0.8em;
        text-align: center;
        background: #333;
    }

    .user.user-menu > .dropdown-menu > .user-header > p > small,
    .user.user-menu > .dropdown-menu > .user-header > p > span {
        display: block;
        width: 100%;
    }

    .user.user-menu > .dropdown-menu > .user-header > p > span {
        font-size: 1.2em;
        padding-top: 0.5em;
    }

    .user.user-menu > .dropdown-menu > .user-header > p > small {
        font-size: 1em;
    }

    .user-menu > .dropdown-menu > .user-body {
        padding: 1em;
        border-bottom: 1px solid #f4f4f4;
        border-top: 1px solid #dddddd;
    }

    .user-menu > .dropdown-menu > .user-footer {
        background-color: #f9f9f9;
        padding: 0.8em;
        width:100%;
        display:table;
    }

    .user.user-menu > .dropdown-menu > .user-body:after {
        clear: both;
    }

    .user.user-menu > .dropdown-menu > .user-footer:before, .user.user-menu > .dropdown-menu > div:after,
    .navbar-nav > .user-menu > .dropdown-menu > .user-body:after{
        content: " ";
        display: table;
    }
    .user.user-menu > .dropdown-menu > .user-header{
        color:#f1f1f1;
    }
</style>

<nav class="navbar {{config('kregel.menu.theme')}}">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapsible" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php $name = config('kregel.menu.brand.name');?>
            {{-- Here we must make sure that we are checking to see if the name is that of a closure
                 If it is, we need to call the closure. Otherwise we need to just spit out the data. --}}
            @if($name instanceof Closure)

                <a class="navbar-brand" href="{{url(config('kregel.menu.brand.link'))}}"
                   style="padding-top: 19px;">{!! $name() !!}</a>
            @else
                <a class="navbar-brand" href="{{url(config('kregel.menu.brand.link'))}}"
                   style="padding-top: 19px;">{!! $name !!}</a>
            @endif
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapsible">
            <ul class="nav navbar-nav navbar-right">
                {!! $menu->using('bootstrap')->config()->devour() !!}


            @if(Auth::check() && config('kregel.menu.login.user-nav.enabled'))
                @include('menu::main.subnav')
            @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
