@extends('admin.layouts.app')
@section('title-admin','Edit categories')
@section('content')

    <section class="content-header">
        <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit categories</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @include('admin.category.form')
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </section>
@endsection