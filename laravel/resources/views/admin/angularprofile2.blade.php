@include('admin.common.main')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">  
                        
                        <?php 
                            $sessionUserData = Session::get('sessionUserData');
                           // $userId = !empty($sessionUserData[0][0]->id) ? $sessionUserData[0][0]->id : 0;
                           // $userTypeId = !empty($sessionUserData[0][0]->user_type) ? $sessionUserData[0][0]->user_type : 0;

                            $getUserDataByID = DB::table('company_edit_profile')
                            ->select('*')
                            ->where('is_deleted_status','N')
                           // ->where('user_id',$userId)
                           // ->where('user_type_id',$userTypeId)
                            ->get()
                            ->toArray();
                        ?> 
                        
                        @if(!empty($getUserDataByID))
                            @foreach ($getUserDataByID as $getUserData)
                            @endforeach
                        @endif
                        


                         <form id="register-form"  class="form-horizontal" name="register_form" method="post" 
                                enctype="multipart/form-data" autocomplete="off" action="{{route('angularUpdateProfile')}}">
                            
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="_token" 
                                    id="_token" value="{{ csrf_token() }}">
                                     <input type="hidden" name="company_edit_profile_id" id="company_edit_profile_id" 
                                    value="{{!empty($getUserData->id) ? $getUserData->id : ''  }}">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Company Name :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc" name="company_name" id="company_name" 
                                                placeholder="Company Name" type="text" value="{{!empty($getUserData->company_name) ? $getUserData->company_name : ''  }}">
                                                <span class="text-danger" id="empty_company_name" 
                                                ></span> 
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Address :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <textarea class="form-control abc" rows="1" id="address" 
                                                name="address" placeholder="Address" value="{{!empty($getUserData->address) ? $getUserData->address : ''  }}"
                                        value="" >{{!empty($getUserData->address) ? $getUserData->address : ''  }}</textarea>
                                                <span class="text-danger" id="empty_address"></span> 
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Phone :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc" 
                                                onkeypress="return isNumber(event)" 
                                                name="phone" id="phone" maxlength="10" 
                                                placeholder="Phone" type="text" value="{{!empty($getUserData->phone) ? $getUserData->phone : ''  }}">
                                                <span class="text-danger" id="empty_phone"></span> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>Email :</b> </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc" 
                                                onblur="validateEmail(this);" 
                                                name="contact_email" id="contact_email"  value="{{!empty($getUserData->email) ? $getUserData->email : ''  }}" 
                                                placeholder="Email" type="text">
                                                <span class="text-danger" id="empty_email"></span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Website :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc" name="website" id="website" 
                                                placeholder="Website" type="text" 
                                                value="{{!empty($getUserData->website) ? $getUserData->website : ''  }}">
                                                <span class="text-danger" id="empty_website"></span> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"><b>GST No :</b> </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc"   name="gst_no" id="gst_no" 
                                                placeholder="GST No" type="text" value="{{!empty($getUserData->gst_no) ? $getUserData->gst_no : ''  }}">
                                                <span class="text-danger" id="emptygst_no"></span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Logo :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control borderred abc" name="logos" id="logo" 
                                                placeholder="Logo" type="file" onchange="previewFile(this);">
                                                <span class="text-danger" id=""></span> 
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label">
                                                <b>Preview :</b> 
                                            </label>
                                            <div class="col-md-8">
                                                <?php 
                                                    $photo = !empty($getUserData->logo) ? $getUserData->logo : '';
                                                    $url = URL::to('/').'/laravel/public/company_edit_profile_image/'.$photo;
                                                ?>
                                                @if(!empty($photo)) 
                                                    <img id="previewImg"  src="{{$url}}" 
                                                    alt="Placeholder" height="54px;" width="176px;">
                                                @else
                                                    <img id="previewImg" style="display: none;" src="{{$url}}" 
                                                    alt="Placeholder" height="54px;" width="176px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-4 col-form-label"></label>
                                            <div class="col-md-8">
                                                
                    <button type="submit" id="lorderIds" class="btn btn-primary mr-2">Save</button>
                    
                                        
                            <button type="button" onclick="resetChangePwdForm()" class="btn btn-dark">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>


@include('admin.common.footer')

</div>
</div>
</div>

@include('admin.common.script')

<script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
<script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script> 
        
    <script>
        
        function validateEmail(emailField)  {

            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var contact_email = $('#email').val();
            
            if (reg.test(emailField.value) == false && contact_email != '') 
            {   
                $('#empty_email').show();
                $('#empty_email').html('Please insert a valid email address.'); 
                $("#lorderId").attr("disabled", true);
                $('#contact_email').css('border-color', 'red');
                return false;
           
            } else if (reg.test(emailField.value) == false && contact_email == '') {   
                
                $('#empty_email').show();
                $('#empty_email').html('Please insert a valid email address.'); 
                $("#lorderId").attr("disabled", true);
                $('#contact_email').css('border-color', 'red');
                return false;

           
            }  else if (reg.test(emailField.value) == false &&  contact_email != '') {   
                
                $('#empty_email').show();
                $('#empty_email').html('Please insert a valid email address.'); 
                $("#lorderId").attr("disabled", true);
                $('#contact_email').css('border-color', 'red');
                return false;
                
            } else {

                $('#empty_email').hide();
                $("#lorderId").attr("disabled", false);
                $('#contact_email').css('border-color', '#E4E6EF');
                return true;
            }
        }


        $("#lorderId").click(function (e) {
                     
            e.preventDefault();
            var company_name = $('#company_name').val();   
            var address = $('#address').val();
            var phone = $('#phone').val();
            var contact_email = $('#contact_email').val();
            var website = $('#website').val();
            var gst_no = $('#gst_no').val();
            var _token = $('#_token').val();
            var files = $('#logo')[0].files[0];
            var company_edit_profile_id = $('#company_edit_profile_id').val();
            
                
            var data = new FormData();
            data.append("company_name", company_name);
            data.append("_token", _token);
            data.append("address", address);
            data.append("phone", phone);
            data.append("contact_email", contact_email);
            data.append("website", website);
            data.append("gst_no", gst_no);
            data.append('logos',files);
            data.append('company_edit_profile_id',company_edit_profile_id);
            
            if (company_name == '' ||  address == '' || phone == '' || contact_email == '' || website == '' || gst_no == '') {

                if (company_name == '') {
                    $('#empty_company_name').show();
                    $('#empty_company_name').html('Company Name is Required.');
                } else {
                    $('#empty_company_name').hide();
                }

                if (address == '') {
                    $('#empty_address').show();
                    $('#empty_address').html('Address field is Required.');
                } else {
                    $('#empty_address').hide();
                }   

                if (phone == '') {
                    $('#empty_phone').show();
                    $('#empty_phone').html('Phone field is Required.');
                } else {
                    $('#empty_phone').hide();
                }

                if (contact_email == '') {
                    $('#empty_email').show();
                    $('#empty_email').html('Email field is Required.');
                } else {
                    $('#empty_email').hide();
                }
                
                if (website == '') {
                    $('#empty_website').show();
                    $('#empty_website').html('Website field is Required.');
                } else {
                    $('#empty_website').hide();
                }

                if (gst_no == '') {
                    $('#emptygst_no').show();
                    $('#emptygst_no').html('GST No field is Required.');
                } else {
                    $('#emptygst_no').hide();
                }
                return false;

            } else {
                    
                $('#empty_company_name').hide();
                $('#empty_address').hide();
                $('#empty_phone').hide();
                $('#empty_email').hide();
                $('#empty_website').hide();
                $('#emptygst_no').hide();

                $.ajax({
                    url: "{{ route('angularUpdateProfile') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        
                       /* if (data.emailText == 'emailText' || data.mobileText == 'mobileText') {

                            if (data.emailText == 'emailText') {
                                $('#empty_email').show();
                                $('#empty_email').html('The Email has already been taken.');
                            } else {
                                $('#empty_email').hide();
                            }

                            if (data.mobileText == 'mobileText') {
                                $('#empty_phone').show();
                                $('#empty_phone').html('The Mobile has already been taken.');
                            } else {
                                $('#empty_phone').hide();
                            }

                        } else {*/

                           
                            setTimeout(function() {
                                toastr.success(
                                    data.message, 'Success!',
                                    { 
                                        "closeButton": true,
                                        timeOut: 3000 
                                    }
                                );
                            }, 1000);
                            
                            
                       // }
                    }
                  //  resetChangePwdForm();
                    
              //  window.location.href="{{route('dashboard')}}";
                
                       //  window.location.href="{{route('dashboard')}}";
                     

                });
            }
        });
    
    function resetChangePwdForm() {
            window.location.reload();
        }

    
   function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];

        if(file){
            var reader = new FileReader();
        
            reader.onload = function(){
                $("#previewImg").show();
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        } 
    }
    </script>

    </body>
</html>