<?php
$user_img   = config('kregel.menu.login.user-nav.user-img');
$left_foot  = config('kregel.menu.login.user-nav.footer-left');
$right_foot = config('kregel.menu.login.user-nav.footer-right');
?>
<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown">
        {{ config('kregel.menu.login.user-nav.menu-warding') }}
        <span class="caret"></span>
    </a>

    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header text-center">
            <img src="{{ $user_img() }}" class="img-circle" alt="User Image">

            <p>
                <span>{{ Auth::user()->name }}</span>
                <small>Member since {{ date('M. Y', strtotime(Auth::user()->created_at)) }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <?php
            $body = config('kregel.menu.login.user-nav.user-body');
            $body_elements = [];
            foreach ($body as $text => $closure) {
                if($closure instanceof Closure)
                    $body[$text] = $closure();
                else
                    $body[$text] = $closure;
            }
            ?>
            @foreach( $body as $text => $link)
                <div class="col-xs-{{ 12 / count(config('kregel.menu.login.user-nav.user-body')) }} text-center">
                    <a href="{{ $link }}">{{ $text }}</a>
                </div>
            @endforeach
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                {{-- Force using bootstrap for this functionallity just because... --}}
                <a href="{{ $menu->using('bootstrap')->routify($left_foot['link']) }}" class="btn btn-default btn-flat">{{ $left_foot['text'] }}</a>
            </div>

            <div class="pull-right">
                {{-- Force using bootstrap for this functionallity just because... --}}
                <a href="{{ $menu->using('bootstrap')->routify($right_foot['link']) }}" class="btn btn-default btn-flat">{{ $right_foot['text'] }}</a>
            </div>
        </li>
    </ul>
</li>
