@extends('admin.layouts.app')
@section('title-admin','Ad editing')
@section('content')

    <!-- Main content -->
    <section class="content-header">
        <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ad editing</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_redirect" value="admin.setting.ads">
                            <div class="form-group">
                                <label>Top</label>
                                <textarea name="ads_header" class="form-control" cols="30" rows="10">{{ old('ads_header', \App\Models\Option::getvalue('ads_header'))}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>End of page</label>
                                <textarea name="ads_footer" class="form-control" cols="30" rows="10">{{ old('ads_footer', \App\Models\Option::getvalue('ads_footer'))}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>In the middle of the story</label>
                                <textarea name="ads_story" id="ads_story" class="form-control" cols="30" rows="10">{{ old('ads_story', \App\Models\Option::getvalue('ads_story'))}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>At The End of Chapter</label>
                                <textarea name="ads_chapter" id="description" class="form-control" cols="30" rows="10">{{ old('ads_chapter', \App\Models\Option::getvalue('ads_chapter'))}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
@endsection