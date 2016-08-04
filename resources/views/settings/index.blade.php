@extends('common.base')

@section('browser_subtitle', 'Settings')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Settings</h4></div>
        </div>
    </div>

    <div class="content">

        @if(session('validationErrors'))
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"></button>
                {{session('validationErrors')}}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span>×</span><span class="sr-only">Close</span></button>
                Saving operation completed successfully.
            </div>
        @endif

        <div class="panel panel-flat">
            <div class="panel-body">
                <form role="form" method="post" autocomplete="off" class="form-horizontal form-validate-jquery">

                    <fieldset class="content-group">

                        <div class="form-group">
                            <label class="control-label col-lg-2">Reports Emails</label>
                            <div class="col-lg-10">
                                <textarea name="reports_emails" rows="3" class="form-control">{{ old('reports_emails', @\App\Setting::whereKey('reports_emails')->first()->value)}}</textarea>
                                <span class="help-block">List of emails that will receive notifications on every new report sent.</span>
                                <span class="help-block">Add a single email per line.</span>
                            </div>
                        </div>

                        @foreach(\App\Complain::$TYPES as $id => $typeName)
                            <div class="form-group">
                                <label class="control-label col-lg-2">{{$typeName}} complains emails</label>
                                <div class="col-lg-10">
                                    <textarea name="complains_emails_{{$id}}" rows="3" class="form-control">{{ old('complains_emails_'.$id, @\App\Setting::whereKey('complains_emails_'.$id)->first()->value)}}</textarea>
                                    <span class="help-block">List of emails that will receive notifications on {{$typeName}} complains.</span>
                                    <span class="help-block">Add a single email per line.</span>
                                </div>
                            </div>
                        @endforeach

                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@stop