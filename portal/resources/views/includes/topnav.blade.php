<nav class="navbar navbar-default top-navbar">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/portal">Fusion Portal</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> @if (!empty($user)) {{ucfirst($user['name'])}} @endif <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        @if (!empty($user))
                        <li><a data-vbtype="ajax" class="venbobox"  href="{{ action('UserController@recovery', ['id' => $user['id']]) }}"><i class="fa fa-cog fa-fw"></i>User Setting</a></li>
                        <li><a href="{{ action('UserController@logout') }}"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
                        @else
                        <li><a href="{{ action('AuthenticateController@login') }}"><i class="fa fa-sign-out fa-fw"></i>Login</a></li>
                        @endif
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->