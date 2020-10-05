@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            @if(!empty($getHolidayDataByID))
                @foreach ($getHolidayDataByID as $getEditHoliday)
                @endforeach
            @endif
            <?php 
                $holidayDates = !empty($getEditHoliday->date) ? $getEditHoliday->date : '';
                if (!empty($holidayDates)) {
                    $holidayDate  =  date("d-m-Y", strtotime($holidayDates));
                } else {
                    if (!empty($registerHolidayPostData['date'])) {
                        $holidayDate = $registerHolidayPostData['date'];
                    } else {
                        $holidayDate = date('d-m-Y');
                    }
                }
            ?>  
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Holiday</h4>
                        <style type="text/css">
                            .text-right {
                                color: black;
                            }
                            .borderred {
                                border: 1px solid red !important;
                                border-radius:4px;
                            }
                        </style>
                        @if(!empty($getEditHoliday->id))
                        <form  autocomplete="off" class="form-horizontal" id="register-form" action="{{ route('holiday.edit') }}" 
                        method="post" autocomplete="off">
                        @else 
                        <form  id="register-form"  method="post" action="{{ route('holiday.add') }}" enctype="multipart/form-data" 
                        autocomplete="off" >
                        @endif
                            @if(!empty($getEditHoliday->id))
                                <input type="hidden" name="holidayId"  value="{{$getEditHoliday->id}}">
                            @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <div class="row">
                                <div  class="col-md-3">
                                    <div class="form-group row has-feedback {{ $errors->has('date') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Date : </label>
                                        <div class="col-md-9">
                                            <input type="text" id="holiday_date" name="date" class="form-control borderred" 
                                            style="border:1px solid #e74a25!important" data-date-format="dd-mm-yyyy" placeholder="Date" 
                                            value="{{$holidayDate}}"> 
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @if (!empty($emptyErrorMsg['checkDateMsg']))
                                                <span class="text-danger"> {{ $emptyErrorMsg['checkDateMsg'] }} </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-md-3">
                                    <div class="form-group row has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="control-label text-right col-md-3 col-form-label">Name : </label>
                                        <div class="col-md-9">
                                            <input class="form-control borderred"  style="height: 39px; border:1px solid #e74a25!important" id="name" name="name" rows="2" placeholder="Name" value="{{ !empty($getEditHoliday->name) ? $getEditHoliday->name : old('name') }}{{ !empty($registerHolidayPostData['name']) ? $registerHolidayPostData['name'] : '' }}">
                                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="button" onclick="resetHolidayForm()" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive" >
                            <table id="zero_config" class="table table-striped table-bordered" >
                                <thead style="color: black;background: #456c4552;">
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getHolidayData))
                                        @foreach ($getHolidayData as $key => $holiday)
                                            <tr  
                                                @if($holiday->status == 'No') 
                                                    style="background-color:#ff851b !important"
                                                @endif
                                                >
                                                <td>{{$key+1}}</td>
                                                <td>&nbsp;{{date("d-m-Y",strtotime($holiday->date))}}</td>
                                                <td>&nbsp;{{$holiday->name}}</td>
                                                <td>
                                                    <a href="{{ route('holiday.viewbyid',['holidayId' =>  base64_encode($holiday->id)]) }}" 
                                                    class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Edit"  
                                                    style="padding: 0px 7px;" ><i class="icon-pencil"></i> 
                                                    </a>
                                                    <a href="{{ route('holiday.delete',['holidayId' =>  base64_encode($holiday->id)]) }}"  
                                                    class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" 
                                                    onclick="return confirm('Are you Want to delete?')" style="padding: 0px 7px;"><i class="icon-trash"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script type="text/javascript">
        function resetHolidayForm() {
            window.location.href="{{ route('holiday') }}";
        }
    </script>
    @include('admin.common.script2')
    <script>
        /*@if (!empty($successMsg))
            toastr.success(
                '{{$successMsg}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 
                3000 
            });
        @endif
        */
        @if(\Session::has('message'))
            toastr.success(
                '{{session()->get('message')}}', 'Success',
                { 
                    "closeButton": true,
                    timeOut: 3000 
                }
            );
        @endif
        
        $(function() {
            $("#register-form").validate({
                rules: {
                    date : {
                        required: true
                    },
                    name: {
                        required: true,
                    },
                },
                // Specify the validation error messages
                messages: {
                    date: "<span class='text-danger'>The Date field is required.</span>",
                    name: "<span class='text-danger'>The Name field is required.</span>",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
    </body>
</html>
