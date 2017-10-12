@extends('common.base')

@section('browser_subtitle', 'Apartments')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Apartments Management: {{$item->id ? $item->street : 'Add New'}}</h4></div>
        </div>
    </div>

    <div class="content">

        @if(session('validationErrors'))
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"></button>
                {{session('validationErrors')}}
            </div>
        @endif

        <div class="panel panel-flat">
            <div class="panel-body">
                <form role="form" method="post" autocomplete="off" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <fieldset class="content-group">

                      <div class="form-group">
                          <label class="control-label col-lg-2">Contact Email<span class="text-danger">*</span></label>
                          <div class="col-lg-10">
                              <select name="contact_id" class="form-control select2" required="required">
                                  {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Contact::pluck('email','id')->toArray(), old('contact_id', $item->contact_id)) !!}
                              </select>
                          </div>
                      </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Street<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="street" value="{{$item->street ?: old('street')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Move In Date<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" required="required" name="move_in_date" value="{{$item->move_in_date ?: old('move_in_date')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Postcode<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="postcode" value="{{$item->postcode ?: old('postcode')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Country<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="country" class="form-control select2" required="required">
                                  {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Apartment::$countries, old('country', $item->country)) !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Town<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="town" value="{{$item->town ?: old('town')}}">
                            </div>
                        </div>




                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <script>
        $("#parent_id").on('change', function() {
            //alert('punk');
            document.getElementById("brand_id").disabled = true;

        });


    </script>
@stop
