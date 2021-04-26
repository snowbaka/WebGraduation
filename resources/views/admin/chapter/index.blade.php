@extends('admin.layouts.app')
@section('content')

    <section class="content-header">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ isset($story->name) ? $story->name : 'General chapter' }}</h3>

                    <div class="box-tools">
                        <a href="{{ route('admin.story.index') }}" class="btn btn-success"><i class="fa fa-book"></i> Managing stories </a>
                        @if (isset($story))
                        <a href="{{ route('admin.chapter.index') }}" class="btn btn-success"><i class="fa fa-book"></i> Complete chapter </a>
                        <a href="{{ route('admin.chapter.create', $story->id) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add new chapters </a>
                        @endif
                    </div>
                </div>
                <div class="box-header">
                    <div class="pull-left">
                    </div>
                </div>
                @php
                    if(!isset(\Auth::user()->level)) {
                        return redirect()->route('admin.logout');
                    }
                    $level = \Auth::user()->level
                @endphp
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered" id="dataTableList">
                        <thead>
                            <tr align="center">
                                <th>Section Name</th>
                                <th>Chapter</th>
                                @if (!isset($story->name))
                                    <th>Belonging</th>
                                @endif
                                <th>Status</th>
                                <th>Update day</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $key => $item)
                                <tr>
                                    <td>{{ $item->subname }}</td>
                                    <td>{{ $item->name }}</td>
                                    @if (!isset($story->name))
                                        <td>
                                            {{ isset($item->story)? $item->story->name : '' }}
                                        </td>
                                    @endif
                                    <td>
                                        <p class="status-code">
                                            @if($level == 2 || $level == 3)
                                                @if($item->active == 1)
                                                    Đã duyệt
                                                @else
                                                    <a href="{{ route('admin.active.status.chapter', $item->id) }}" class=" btn btn-success active-story" style="padding: 0px 12px !important;">Duyệt bài</a>
                                                @endif
                                            @else
                                                @if($item->active == 1)
                                                    Đã duyệt
                                                @else
                                                    Chưa duyệt
                                                @endif
                                            @endif
                                        </p>
                                    </td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.chapter.update', $item->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                        @if($level == 2 || $level == 3)
                                        <a href="{{ route('admin.chapter.delete', $item->id) }}" class="btn btn-xs btn-info confirm__btn"><i class="fa fa-trash-o"></i></a>
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