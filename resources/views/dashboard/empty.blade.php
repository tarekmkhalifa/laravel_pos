@extends('layouts.dashboard.app')
@section('title')
    @lang('site.users')
@endsection
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> <a
                        href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
                <li><i class="fa fa-dashboard"></i> @lang('site.users')</li>
            </ol>
        </section>

        <section class="content">



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endsection
