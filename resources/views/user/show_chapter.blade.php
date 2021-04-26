@extends('user.layouts.app')
@section('title', $story->name . ' - ' . $chapter->subname . ' :' . $chapter->name)
@section('breadcrumb')
    {!! showBreadcrumb($breadcrumb) !!}
@endsection
@section('content')
    <div class="container chapter" id="chapterBody" style="margin-top: 0px;">
        <div class="row">
            <div class="col-xs-12">
                <button type="button" class="btn btn-responsive btn-success toggle-nav-open">
                    <span class="glyphicon glyphicon-menu-up"></span>
                </button>

                <a class="truyen-title" href="{{ route('story.show', $story->alias)  }}" title="{{ $story->name }}">{{ $story->name }}</a>
                <h2>
                    <a class="chapter-title" href="{{ route('chapter.show', [$story->alias, $chapter->alias]) }}" title="{{ $story->name }} - {{ $chapter->subname }}: {{ $chapter->name }}">
                        <span class="chapter-text">{{ $chapter->subname }}</span>: {{ $chapter->name }}
                    </a>
                </h2>
                <hr class="chapter-start">
                @include('user.partials.chapter')
                <hr class="chapter-end">

                <div class="chapter-content">
                    {!! ($chapter->content) !!}
                </div>

                <div class="ads container">
                    {!! \App\Models\Option::getvalue('ads_chapter') !!}
                </div>

                <hr class="chapter-end">
                <div class="chapter-nav" id="chapter-nav-bot">
                    @include('user.partials.chapter')

                    <div class="col-xs-12">
                        <div class="row">
                            <div class="fb-comments fb_iframe_widget" data-href="{{ route('chapter.show', [$story->alias, $chapter->alias]) }}" data-width="832" data-numposts="5" data-colorscheme="light" fb-xfbml-state="rendered">
                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0" nonce="azdpO8L1"></script>
                                <div class="fb-comments" data-href="http://localhost/story/public" data-width="" data-numposts="5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
