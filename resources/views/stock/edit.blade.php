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


                <form role="form" method="post" autocomplete="off">
                    {{csrf_field()}}
                    <div class="panel panel-flat">

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td class="v-align-middle semi-bold">
                                            {{$item->product->category->name}} > {{$item->product->name}} > {{$item->name}}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                   name="variation[{{$item->id}}]"
                                                   value="{{ @$stock->where('variation_id', $item->id)->where('door_id', $door->id)->first()->stock ?: 0}}">
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

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

@stop