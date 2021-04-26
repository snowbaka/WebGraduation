@extends('user.layouts.app')
@section('title', $story->name)
@section('seo')
    <meta name="robots" content="noindex">
    <meta name="keywords" content="{{ $story->keyword }}">
@endsection
@section('breadcrumb')
    {!! showBreadcrumb($breadcrumb) !!}
@endsection
@section('content')
    <div class="container" id="truyen">
        <div class="col-xs-12 col-sm-12 col-md-9 col-truyen-main">
            <div class="col-xs-12 col-info-desc">
                <div class="title-list"><h2>Story information</h2></div>
                <div class="col-xs-12 col-sm-4 col-md-4 info-holder">
                    <div class="books">
                        <div class="book">
                            <img src="{{ url($story->image) }}" alt="{{ $story->name }}" itemprop="image">
                        </div>
                    </div>
                    <div class="info">
                        <div>
                            <h3>Author:</h3>
                            {!!  the_author($story->authors) !!}
                        </div>
                        <div>
                            <h3>Posted by :</h3>
                            {!!  $story->user->name !!}
                        </div>
                        <div>
                            <h3>Category:</h3>
                            {!!  the_category($story->categories) !!}
                        </div>
                        <div>
                            <h3>View:</h3>
                            {!!  number_format($story->view) !!}
                        </div>
                        <div>
                            <h3>Status :</h3> {!! statusStoryShow($story->status) !!}
                        </div>
                        @if($story->source)
                        <div>
                            <h3>Story source:</h3> {!! $story->source !!}
                        </div>
                        @endif
                        <div>
                   <div class="navbar-social pull-left">
  <div class="g-plusone" data-href="{{ route('story.show', $story->alias) }}" data-annotation="bubble" data-height="20" data-rel="publisher"></div>
                            <div class="navbar-social pull-left">
                     <div class="fb-like" data-href="{{ route('story.show', $story->alias) }}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 desc">
                    <h3 class="title" itemprop="name">{{ $story->name }}</h3>
                    <div class="desc-text desc-text-full" itemprop="about">
                        {!!  nl2p($story->content, false) !!}
                    </div>
                    <div class="showmore">
            					<a class="btn btn-default btn-xs" href="javascript:void(0)" title="Xem thêm">See more »</a>
            				</div>

                    <?php
                    $chapters = $story->chapters()->where('active', 1)->orderBy("created_at", "desc")->take(5)->get();
                    if ($chapters) {
                      echo '<div class="l-chapter"><div class="l-title"><h3>Latest chapters</h3></div><ul class="l-chapters">';
                      foreach($chapters as $chapter):
                      ?>
                      <li>
                        <span class="glyphicon glyphicon-certificate"></span>
                        <a href="{{ route('chapter.show', [$story->alias, $chapter->alias]) }}" title="{{ $story->name }} - {{ $chapter->subname }}: {{ $chapter->name }}">
                            <span class="chapter-text">{{ $chapter->subname }}</span>: {{ $chapter->name }}
                        </a>
                      <?php
                          endforeach;

                          echo '</ul></div>';
                    }
                    ?>
                </div>
            </div>

            <div class="ads container">
                {!! \App\Models\Option::getvalue('ads_story') !!}
            </div>

            <div class="col-xs-12" id="list-chapter">
                <div class="title-list"><h2>List of chapters</h2></div>
                <div class="row">
                    <?php
                    $t = 1; $c = 1;
                    $chapters = $story->chapters()->where('active', 1)->paginate(50);
                    foreach($chapters as $chapter):
                        $count = count($chapters);
                        if($t == 1) echo ' <div class="col-xs-12 col-sm-6 col-md-6"><ul class="list-chapter">';
                    ?>
                            <li>
                                <span class="glyphicon glyphicon-certificate"></span>
                                <a href="{{ route('chapter.show', [$story->alias, $chapter->alias]) }}" title="{{ $story->name }} - {{ $chapter->subname }}: {{ $chapter->name }}">
                                    <span class="chapter-text">{{ $chapter->subname }}</span>: {{ $chapter->name }}
                                </a>
                            </li>
                    <?php
                        if($t == 25 || $count == $c){
                            $t = 0;
                            echo '</ul></div>';
                        }
                            $t++; $c++;
                        endforeach;
                        ?>
                </div>

                {{ $chapters->fragment('list-chapter')->links() }}

                </div>
            <div class="visible-md visible-lg">
                <div class="col-xs-12 comment-box">
                    <div class="title-list"><h2>Comment</h2></div>
                    <div class="fb-comments fb_iframe_widget" data-href="{{ route('story.show', $story->alias) }}" data-width="832" data-numposts="5" data-colorscheme="light" fb-xfbml-state="rendered">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0" nonce="azdpO8L1"></script>
                        <div class="fb-comments" data-href="http://localhost/story/public" data-width="" data-numposts="5"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="visible-md-block visible-lg-block col-md-3 text-center col-truyen-side">
            @include('user.widgets.storiesByAuthor')
            @include('user.widgets.hotstory')
        </div>
    </div>

@endsection
