@extends('admin.layouts.app')
@section('title-admin','Change Password')
@section('content')

<!-- Main content -->
<section class="content-header">
    <div class="col-xs-12">
        <div class="box">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ route('post.change.password') }}" method="POST">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('currentPassword') ? 'has-error' : '' }}">
                            <label>Current password</label>
                            <input type="password" class="form-control" name="currentPassword" placeholder="Enter current password" />
                            @if($errors->has('currentPassword'))
                                <span class="help-block">{{$errors->first('currentPassword')}}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('txtPassword') ? 'has-error' : '' }}">
                            <label>A new password</label>
                            <input type="password" class="form-control" name="txtPassword" placeholder="Enter your new password" />
                            @if($errors->has('txtPassword'))
                            <span class="help-block">{{$errors->first('txtPassword')}}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('txtPassword_confirmation') ? 'has-error' : '' }}">
                            <label>Enter the password</label>
                            <input type="password" class="form-control" name="txtPassword_confirmation" placeholder="Enter the password" />
                            @if($errors->has('txtPassword_confirmation'))
                            <span class="help-block">{{$errors->first('txtPassword_confirmation')}}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                        <button type="reset" class="btn btn-danger">Rework, do it again</button>

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