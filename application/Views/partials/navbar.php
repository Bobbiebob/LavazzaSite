<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/"><img src="\assets\images\Lavazza.png" alt="Logo" style="height:100%;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto"></ul>
        <ul class="navbar-nav" >

            <li class="nav-item">
                <label style="padding-top: 0.5em;" class="form-switch">
                    <input class="darkmode-toggle" type="checkbox">
                    <i></i>
                </label>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(\Application\Routing\Router::getURI() == 'dashboard/colombia' ? 'active' : '');?>" href="/dashboard/colombia">Data on Colombia</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(\Application\Routing\Router::getURI() == 'dashboard/europe' ? 'active' : '');?>" href="/dashboard/europe">Data on Europe</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(\Application\Routing\Router::getURI() == 'dashboard/map' ? 'active' : '');?>" href="/dashboard/map">Map</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bongiorno, <?=Application\Helpers\Auth::user()['first_name'];?>!
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Name</a>
                    <a class="dropdown-item" href="#">Account settings</a>
                    <a class="dropdown-item" href="/logout">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>