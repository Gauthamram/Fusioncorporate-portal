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
           <user-menu @if(!empty($user)) user="{{json_encode($user)}}" @endif></user-menu>
        </nav>
        <!--/. NAV TOP  -->