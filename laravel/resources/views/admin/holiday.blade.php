@include('admin.common.main')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
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
            <h3 class="box-title m-b-0">{{ !empty($getEditHoliday->id) ? 'Edit Holiday' : 'Add  Holiday' }}</h3>
            <p class="text-muted m-b-30 font-13 "> 
               <span class="text-danger"> *Indicates Required Field </span> 
            </p>
            
            @if(!empty($getEditHoliday->id))
                <form class="form-horizontal" autocomplete="off" class="form-horizontal" id="register-form" 
                action="{{ route('holiday.edit') }}" method="post" autocomplete="off">
            @else 
                <form class="form-horizontal" style="margin-top: 10px;" id="register-form"  method="post" 
                action="{{ route('holiday.add') }}" enctype="multipart/form-data" autocomplete="off" >
            @endif
                @if(!empty($getEditHoliday->id))
                    <input type="hidden" name="holidayId"  value="{{$getEditHoliday->id}}">
                @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div  class="col-md-4">
                        <div class="form-group has-feedback {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label ">Date<b class="text-danger">*</b>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="holiday_date" name="date" class="form-control" style="border:1px solid #e74a25!important" data-date-format="dd-mm-yyyy"   placeholder="Date" value="{{$holidayDate}}"> 
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                  @if (!empty($emptyErrorMsg['checkDateMsg']))
                                    <span class="text-danger"> {{ $emptyErrorMsg['checkDateMsg'] }} </span>
                                @endif 
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-4">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="col-sm-3 control-label">Name<b class="text-danger">*</b></label>
                            <div class="col-sm-9">
                                <input class="form-control"  style="height: 39px; border:1px solid #e74a25!important" id="name" 
                                name="name" rows="2" placeholder="Name" value="{{ !empty($getEditHoliday->name) ? $getEditHoliday->name : old('name') }}{{ !empty($registerHolidayPostData['name']) ? $registerHolidayPostData['name'] : '' }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" >
                        <div class="row" style="margin-left: 20px;">
                            <div class="form-group">
                                <div class="col-md-5">
                                    @if(empty($getEditHoliday->id))
                                        <button type="submit" class="btn btn-block btn-primary"> 
                                        <i class="fa fa-save"></i> Save</button>
                                    @else
                                        <button type="submit" class="btn btn-block btn-primary"> 
                                        <i class="fa fa-save"></i> Update</button>
                                    @endif
                                </div>
                                <div class="col-md-5" style="margin-left: -25px;">
                                    <button type="button" onclick="resetHolidayForm()" class="btn btn-block btn-default">
                                        <i class="icon-close"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title pull-left">Manage Holiday</h3>
            <div class="clearfix"></div>
            <div class="table-responsive" >
                <style type="text/css">
                .table td{
                    padding: 0.1rem !important;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                </style>
                <table id="myTable" class="table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @if (!empty($getHolidayData))
                            @foreach ($getHolidayData as $key => $holiday)
                                <tr  
                                    @if($holiday->status == 'No') 
                                        style="background-color:#ff851b !important"
                                    @endif
                                    >
                                    <td>{{$key+1}}</td>
                                    <td>&nbsp;
                                    {{date("d-m-Y",strtotime($holiday->date))}}</td>
                                    <td>&nbsp;&nbsp;{{$holiday->name}}</td>
                                    <td>&nbsp;&nbsp;
                                        <a href="{{ route('holiday.viewbyid',['holidayId' =>  base64_encode($holiday->id)]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" style="padding: 0px 7px;" ><i class="icon-pencil"></i> </a>
                                        <a href="{{ route('holiday.delete',['holidayId' =>  base64_encode($holiday->id)]) }}"  class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"  onclick="return confirm('Are you Want to delete?')" style="padding: 0px 7px;"><i class="icon-trash"></i> </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function resetHolidayForm() {
        window.location.href="{{ route('holiday') }}";
    }
</script>
@include('admin.common.script')

<script>
    @if (!empty($successMsg))
        $.toast({
            heading: 'Success!',
            position: 'top-right',
            text: '{{$successMsg}}',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
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