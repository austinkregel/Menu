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
      <a class="navbar-brand" href="{{url(config('kregel.menu.brand.link'))}}" style="padding-top: 19px;">{!! config('kregel.menu.brand.name')!!}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapsible">
      <ul class="nav navbar-nav navbar-right">
        {!! $menu->using('bootstrap')->config()->devour() !!}
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
