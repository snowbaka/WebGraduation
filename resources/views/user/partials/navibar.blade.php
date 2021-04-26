<!-- navibar -->
<div class="navbar navbar-default navbar-static-top" role="navigation" id="nav">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Show menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h1><a class="header-logo" href="{{ route('user.home')}}" title=""></a></h1>
        </div>
        <div class="navbar-collapse collapse" itemscope="" itemtype="http://schema.org/WebSite">
            <meta itemprop="url" content="{{ url('/') }}">
            <ul class="control nav navbar-nav ">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-list"></i> List <i class="caret"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('list.story.new') }}" title="Truyện mới cập nhật">New stories</a></li>
                        <li><a href="{{ route('list.story.hot') }}" title="Truyện Hot">Hot stories</a></li>
                        <li><a href="{{ route('list.story.full') }}" title="Truyện Full">Full stories</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-list"></span> Category <span class="caret"></span></a>
                    <div class="dropdown-menu multi-column">
                        <div class="row">

                            <?php
                            $categories = \App\Models\Category::select('id', 'name', 'alias', 'parent_id')->orderBy('id', 'DESC')->get();
                            $t = 1; $c = 1;
                            foreach($categories as $category)
                            {
                                $count = count($categories);
                                if($t == 1)
                                    echo '<div class="col-md-4"><ul class="dropdown-menu">';
                                echo '<li><a href="'. route('category.list.index', $category->alias) .'">'. $category->name .'</a></li>';
                                if($t == 10 || $count == $c){
                                    $t = 0;
                                    echo '</ul></div>';
                                }
                                $t++; $c++;
                            }
                            ?>
                        </div>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Account <i class="caret"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            @if(Auth::user())
                                <a href="{{ route('admin.home') }}"><span class="glyphicon glyphicon-cog"></span> Admin Panel</a>
                            @else
                                <a href="{{ url("/admin/login") }}"><span class="glyphicon glyphicon-user"></span> Log in</a>
                                <a href="{{ url("/register") }}"><span class="glyphicon glyphicon-cog"></span> Register</a>
                            @endif
                        </li>
                    </ul>
                </li>


            </ul>
            <form class="navbar-form navbar-right" action="{{ route('list.search') }}" role="search" itemprop="potentialAction">
                <div class="input-group search-holder">
                    <meta itemprop="target" content="#?tukhoa={tukhoa}">
                    <input class="form-control" id="search-input" type="search" name="q" placeholder="Search..." value="{{ old('q') }}" itemprop="query-input" required="">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </div>
                </div>
                <div class="list-group list-search-res hide"></div>
            </form>

        </div>
        <!--/.nav-collapse -->
    </div>
    <div class="navbar-breadcrumb">
        <div class="container breadcrumb-container">
            @yield('breadcrumb')
            @include('user.partials.social')
        </div>
    </div>
</div><!-- navibar -->
