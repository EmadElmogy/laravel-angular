@extends('common.base')

@section('browser_subtitle', 'Admins')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Admins Management</h4></div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{url('admins/item')}}" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>Add New</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif


                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="v-align-middle semi-bold">{{$item->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->email}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('admins/item/'.$item->id)}}" class="btn btn-primary btn-xs"><i class="icon-pencil5"></i></a>
                                        <a href="{{url('admins/item/'.$item->id)}}" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="41" class="text-center">No records were found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop