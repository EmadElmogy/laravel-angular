@extends('common.base')

@section('browser_subtitle', 'Doors')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Stock</h4></div>
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


                <h4>Please select a door to view stock</h4>

                <div class="panel panel-flat">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            @forelse($doors as $door)
                                <tr>
                                    <td class="v-align-middle semi-bold">
                                        <a href="{{url('stock/'.$door->id)}}">{{$door->name}}</a>
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