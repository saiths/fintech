<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>

<script>
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
</script>

<script src="{{ URL::asset('public/admin/dist/assets/plugins/global/plugins.bundle.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/js/scripts.bundle.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/js/pages/crud/datatables/basic/headers.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/toastr/dist/build/toastr.min.js')}}"></script>


<script type="text/javascript">
	$('#kt_select2_3_modal').select2({
  		placeholder: "Select Process(s)",
	});

	$('#kt_select2_3_modal_1').select2({
  		placeholder: "Select Process(s)",
	});
	
	$('#kt_select2_3_modal_2').select2({
      placeholder: "Select Item Category Name",
	});

	$('#kt_select2_3_modal_3').select2({
  		placeholder: "Select Process(s)",
	});	

    $('#kt_select2_3_modal_1').select2({
        placeholder: "Select Party Name",
    }); 
        
    
    $('#kt_select2_3_modal_1_item').select2({
        placeholder: "Select Party Name",
    });
    
    
    $('#kt_select2_3_modal_3_item').select2({
        placeholder: "Select Item Attribute",
    }); 
    
    $('#item_type').select2({
        placeholder: "Select Process(s)",
    }); 

    $('#item_type_idsssddd').select2({
        placeholder: "Select Item Name",
    }); 
    
    
    $('#item_id').select2({
        placeholder: "Select Item Name",
    });     

    
    
</script>

<script src="{{ URL::asset('public/admin/dist/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.5')}}"></script>
<script src="{{ URL::asset('public/admin/dist/assets/js/pages/widgets.js?v=7.0.5')}}"></script>

<script type="text/javascript">
	
	@if(\Session::has('message'))
        toastr.success(
            '{{session()->get('message')}}', 'Success!',
            {   
                "closeButton": true,
                timeOut: 3000 ,
            }
        );
    @endif

    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    


    function fun_AllowOnlyAmountAndDot(elementRef) {  
  
        var keyCodeEntered = (event.which) ? event.which : (window.event.keyCode) ?    window.event.keyCode : -1;  
  
        if ((keyCodeEntered >= 48) && (keyCodeEntered <= 57)) {  
  
    return true;  
  
}  
  
// '.' decimal point...  
  
else if (keyCodeEntered == 46) {  
  
// Allow only 1 decimal point ('.')...  
  
if ((elementRef.value) && (elementRef.value.indexOf('.') >= 0))  
  
    return false;  
  
else  
  
    return true;  
  
}  
  
    return false;  
  
}  


</script>


 
 

