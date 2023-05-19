@extends('layouts.dashboard.app')
@section('title', __('site.edit'))

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.edit_client')</h1>

            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.index') }}"> @lang('site.dashboard')</a>
                </li>
                <li><i class="fa fa-dashboard"></i>
                    <a href="{{ route('dashboard.clients.index') }}">@lang('site.clients')</a>
                </li>
                <li class="active"><i class="fa fa-dashboard"></i>@lang('site.edit_client')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                        </div>

                        @for ($i = 0; $i < 2; $i++)
                            <div class="form-group">
                                <label>@lang('site.phone')</label>
                                <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[$i] ?? '' }}">
                            </div>
                        @endfor

                        <div class="form-group">
                            <label>@lang('site.address')</label>
                            <textarea rows="3" name="address" class="form-control">{{$client->address}}</textarea>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i>
                                @lang('site.update')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->


        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endsection
