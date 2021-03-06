@extends('admin.layouts.app')
@section('content')

    <section class="content-header">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Story </h3>

                    <div class="box-tools">
                        <a href="{{ route('admin.story.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add new stories</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="dataTableList">
                        <thead>
                            <tr align="center">
                                <th>Story name</th>
                                <th>Categories</th>
                                <th>Author</th>
                                <th>Posted by</th>
                                <th>Chapter Number</th>
                                <th>Status</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        @php
                            if(!isset(\Auth::user()->level)) {
                                return redirect()->route('admin.logout');
                            }
                            $level = \Auth::user()->level
                        @endphp
                        <tbody>
                            @foreach($datas as $key => $item)
                                <tr>
                                    <td>{!! statusStoryShow($item->status)  !!} {{ $item->name }}</td>
                                    <td>
                                        @foreach ($item->categories as $key => $category)
                                            {{ $category->name }} {{ $key + 1 < $item->categories->count() ? ',' : '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($item->authors as $key =>  $author)
                                            {{ $author->name }} {{ $key + 1 < $item->authors->count() ? ',' : '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $item->user->name  }}
                                    </td>
                                    <td>
                                        {{ $item->chapters->count() }}
                                    </td>
                                    <td>
                                        <p class="status-code">
                                            @if($level == 2 || $level == 3)
                                                @if($item->active == 1)
                                                    Approved
                                                @else
                                                    <a href="{{ route('admin.active.status', $item->id) }}" class=" btn btn-success active-story" style="padding: 0px 12px !important;">Browse articles</a>
                                                @endif
                                            @else
                                                @if($item->active == 1)
                                                    Approved
                                                @else
                                                    Unapproved
                                                @endif
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-xs" href="{{ route('admin.chapter.list', $item->id) }}">
                                            <i class="fa fa-book fa-fw"></i>
                                        </a>
                                        <a href="{{ route('admin.story.update', $item->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                        @if($level == 2 || $level == 3)
                                            <a href="{{ route('admin.story.delete', $item->id) }}" class="btn btn-xs btn-info confirm__btn"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-right" >

                </div>
            </div>
            <!-- /.box -->
        </div>
    </section>
@endsection
@section('script')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection