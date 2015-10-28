@inject('menu', 'Kregel\Menu\Menu')
<nav class="navbar {{config('kregel.menu.theme')}}">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapsible" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    <?php $name = config('kregel.menu.brand.name');?>
    {{-- Here we must make sure that we are checking to see if the name is that of a closure
         If it is, we need to call the closure. Otherwise we need to just spit out the data. --}}
    @if($name instanceof Closure)

      <a class="navbar-brand" href="{{url(config('kregel.menu.brand.link'))}}" style="padding-top: 19px;">{!! $name() !!}</a>
    @else
      <a class="navbar-brand" href="{{url(config('kregel.menu.brand.link'))}}" style="padding-top: 19px;">{!! $name !!}</a>
    @endif
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapsible">
      <ul class="nav navbar-nav navbar-right">
        {!! $menu->using('bootstrap')->config()->devour() !!}
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
