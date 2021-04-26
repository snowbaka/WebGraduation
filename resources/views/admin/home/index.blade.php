@extends('admin.layouts.app')
@section('title', 'Admin Panel')
@section('content')
    <!-- Main content -->
    <section class="content-header">
        <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Information</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td><strong>{{ Auth::user()->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Position</td>
                                            <td><strong>{{ levelName(Auth::user()->level) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ Auth::user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Join date</td>
                                            <td>{{ Auth::user()->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td><a href="{{ route('change.password') }}">Change Password</a></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->isComposer())

                            <div class="col-sm-6">
                                <div class="panel panel-default" style="height: 280px;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Statistical</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>Total number of articles</td>
                                                <td><strong>{{ Auth::user()->stories()->count() }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><a href="{{ route('admin.story.create') }}">Post new stories</a></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endif

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Stories are watching</h3>
                                </div>
                                 <div class="panel-body">
                                    <?php
                                        $viewed = new \App\Models\Viewed;
                                        $data = $viewed->getListReading();
                                        if(count($data) > 0):
                                    ?>
                                    <ul>
                                        @foreach ($data as $item)
                                            @if(isset($item->story))
                                            <li><a href="{{route('story.show', $item->story->alias)}}/">{{ $item->story->name}}</a> (<a href="{{route('chapter.show', [$item->story->alias, $item->chapter->alias])}}">Continue reading {{ $item->chapter->subname}}</a>)</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <?php else: ?>
                                    <p>
                                        You have not read any stories
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Charts</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Name of the poster</td>
                                            <td>Total views</td>
                                        </tr>
                                        @foreach($charts as $key => $value)
                                            @if($key < 5 )
                                                <tr>
                                                    <td>{{ $value['name'] }}</td>
                                                    <td>{{ $value['view'] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
@endsection