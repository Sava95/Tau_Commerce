<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark nav_right" style="height:65px; padding-bottom: 0px;">
  <div class='container' id='navbar'>
    <!-- Left Side -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">
            <img style="width:182px; height:30px" src="/images/Logo.png">
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#"> Home </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="#"> Add Store </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="#"> Add Product </a>
      </li>
    </ul>

    <!-- Right Side -->
    <ul class="navbar-nav ml-auto" style='margin-right: 10px; margin-top: 5px'>
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"> Login </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"> Register </a>
                </li>
            @endif
        @else 
            <li class="nav-item">
                <a class="nav-link" style='color:white;' href="{{ route('register') }}">{{ Auth::user()->name }}</a>
            </li>

            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();"> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        @endguest
    </ul>

  </div>
</nav>