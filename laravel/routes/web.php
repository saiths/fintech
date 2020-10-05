<?php

/*if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); exit();
}*/
    //error_reporting(0);
    

      
    session_start();

    

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    /*
    use Jenssegers\Agent\Agent;
  
  Session::forget('sessionDeviceSupport');
  deviceSupport();
  
  
  function deviceSupport() {

        $getdevSupportData =
        DB::select('SELECT * FROM `device_support` WHERE device_open_status = "N"');
      
      $agent = new Agent();
        if (!empty($getdevSupportData)) {
            foreach ($getdevSupportData as  $device) {

      if ($device->device_name == 'PC' && $device->device_open_status == 'N') {
              
              if ($agent->isDesktop()) 
              { 
                echo '<div id="main" style="margin-left:450px;margin-top:20px;" >
              <img class="irc_mi" src="https://peopleofcolorintech.com/wp-content/uploads/2016/01/NoTech.png" onload="typeof" width="348" height="353" style="margin-top: 0px;" data-iml="1557298172827" alt="Image result for pc not supported icon">
                <h4 style="font-family: Arial, Helvetica, sans-serif;margin-left:-45px">The Device from which you are trying to log in is not supported.</h4>
                </div>';
              die;  
            }
        
          } else if ($device->device_name == 'Mobile' && $device->device_open_status == 'N') {
                
              if ($agent->isMobile()) 
              {
          echo '<div id="main" style="margin-left:450px;margin-top:20px;" >
              <img class="irc_mi" src="http://clipart-library.com/images/ki8op7a4T.jpg"  width="327" height="353" style="margin-top: 0px;" data-iml="1557301237408" alt="Related image">
                <h4 style="font-family: Arial, Helvetica, sans-serif;margin-left:-45px">The Device from which you are trying to log in is not supported.</h4>
                </div>';
              die;
        }
        
      } else if ($device->device_name == 'Tab' && $device->device_open_status == 'N') {
              
              if ($agent->isTablet()) 
              {
          
          echo '<div id="main" style="margin-left:450px;margin-top:20px;" >
              <img class="irc_mi" src="http://cnpnews.net/wp-content/uploads/2017/03/tablette.jpg"  alt="Related image" width="485" height="353" style="margin-top: 0px;" data-iml="1557301965384">
                <h4 style="font-family: Arial, Helvetica, sans-serif;margin-left:-25px">The Device from which you are trying to log in is not supported.</h4>
                </div>';

                die;      

          }
              
            } 
        }
        } else {
        
            if ($agent->isDesktop()) {
                Session::push('sessionDeviceSupport',1);
            }

            if ($agent->isMobile()) {
                Session::push('sessionDeviceSupport',2); 
            }

            if ($agent->isMobile()) {
                Session::push('sessionDeviceSupport',3); 
            }
        }
  }
*/


Route::get('/clear-cache', function() {
  $laravelCacheClear = Artisan::call('cache:clear');
    echo 'Laravel Cache Clear Successfully...';die; 
});

Route::get('/config-cache', function() {
  $configCache = Artisan::call('config:cache');
    echo 'Laravel Config Cache Clear Successfully...';  
});
  
Route::get('/config-cache', function() {
  $routeCode = Artisan::call('route:cache');
    echo 'Laravel Route Cache Clear Successfully...'; 
});

Route::get('/config-cache', function() {
  $viewCode = Artisan::call('view:clear');
    echo 'Laravel View Cache Clear Successfully...';
});



/*
Route::get('/', function () {
    return view('welcome');
});*/



/* ----------------Start Without User Route -----------------*/

Route::get('/', 'Admin\UserController@showLoginForm');
Route::post('login', 'Admin\UserController@checkUserLogin')->name('login');
Route::get('forgot', 'Admin\UserController@showForgotForm')->name('forgot');
Route::POST('forgotpassword', 'Admin\UserController@userForgot')->name('forgotpassword');
Route::get('logout', 'Admin\UserController@userLogout')->name('logout');
Route::get('sendotpLorder', 'Admin\UserController@checkLoaderBylogin')->name('sendotpLorder');


/*----------------- Captcha Master -----------------*/

Route::get('createcaptcha', 'Admin\CaptchaController@create');
Route::post('captcha', 'Admin\CaptchaController@captchaValidate');
Route::get('refreshcaptcha', 'Admin\CaptchaController@refreshCaptcha');

/* ---------------- dashboard Route -----------------*/

Route::get('dashboard', 'Admin\UserController@userDashboard')->name('dashboard');
Route::get('editprofile', 'Admin\UserController@angularShowFormProfile')->name('aeditprofile');

Route::post('angularUpdateProfile', 'Admin\UserController@angularUpdateProfile')->name('angularUpdateProfile');  

Route::get('achangepassword', 'Admin\UserController@angularUserChangePassword')->name('achangepassword');
Route::post('angularchangepassword/update', 'Admin\UserController@angularUserChangePasswordUpdate')->name('angularchangepassword.update');
Route::get('achangepassword', 'Admin\UserController@angularUserChangePassword')->name('achangepassword');
Route::post('angularchangepassword/update', 'Admin\UserController@angularUserChangePasswordUpdate')->name('angularchangepassword.update');
Route::get('aeditprofile', 'Admin\UserController@angularShowFormProfile')->name('aeditprofile');
//Route::get('angularUpdateProfile', 'Admin\UserController@angularUpdateProfile')->name('angularUpdateProfile');  

/*-----------------Angular User Master -----------------*/

Route::get('user', 'Admin\UserController@showAngularUserForm')->name('user');
Route::get('user/view', 'Admin\UserController@angularUserView')->name('user.view');

Route::post('user/add', 'Admin\UserController@userAngularAdd')->name('user.add');
Route::post('user/edit', 'Admin\UserController@userAngularEdit')->name('user.edit');

Route::get('user/delete', 'Admin\UserController@removeAngularUser')->name('user.delete');
Route::get('addUser', 'Admin\UserController@showaddUserForm')->name('addUser');

Route::get('user/viewbyid/{id}', 'Admin\UserController@getAngularUserDataByID')->name('user.viewbyid');

  
Route::get('changepassword', 'Admin\UserController@userChangePassword')->name('changepassword');
Route::post('changepassword/update', 'Admin\UserController@userChangePasswordUpdate')->name('changepassword.update');
Route::get('editprofile', 'Admin\UserController@showFormProfile')->name('editprofile');
Route::post('updateprofile', 'Admin\UserController@updateProfile')->name('updateprofile');
Route::get('getUserByAjax', 'Admin\UserController@getUserTypeIdById')->name('getUserByAjax');


/*-----------------Angular Process Master -----------------*/

Route::get('process', 'Admin\ProcessController@showAngularProcessForm')->name('process');
Route::get('process/view', 'Admin\ProcessController@angularProcessView')->name('process.view');
Route::post('process/add', 'Admin\ProcessController@processAngularAdd')->name('process.add');
Route::post('process/edit', 'Admin\ProcessController@processAngularEdit')->name('process.edit');
Route::post('process/delete', 'Admin\ProcessController@removeAngularProcess')->name('process.delete');

Route::get('process/viewbyid/{id}', 'Admin\ProcessController@getAngularProcessDataByID')->name('process.viewbyid');
Route::get('process/deletes/{id}', 'Admin\ProcessController@removeAngularProcessById')->name('process.deletes');



/*-----------------Angular Machine Master -----------------*/

Route::get('machine', 
'Admin\MachineController@showAngularMachineForm')->name('machine');

Route::post('machine/add', 
'Admin\MachineController@machineAngularAdd')->name('machine.add');

Route::post('machine/edit', 
'Admin\MachineController@machineAngularEdit')->name('machine.edit');

Route::get('machine/deletes/{id}', 'Admin\MachineController@removeAngularMachineById')->name('machine.deletes');

Route::get('machine/viewbyid/{id}','Admin\MachineController@getAngularMachineDataByID')->name('machine.viewbyid');



/*-----------------Angular Item Category Master -----------------*/

Route::get('itemcategory', 
  'Admin\ItemCategoryController@showAngularItemCategoryForm')->name('itemcategory');

Route::get('itemcategory/view', 
  'Admin\ItemCategoryController@angularItemCategoryView')->name('itemcategory.view');

Route::post('itemcategory/add', 
  'Admin\ItemCategoryController@itemCategoryAngularAdd')->name('itemcategory.add');

Route::post('itemcategory/edit', 
  'Admin\ItemCategoryController@itemCategoryAngularEdit')->name('itemcategory.edit');

Route::post('itemcategory/delete', 
  'Admin\ItemCategoryController@removeAngularItemCategory')->name('itemcategory.delete');


Route::post('angularItemCategorySelect/roleSelected', 
  'Admin\ItemCategoryController@selectItemCategoryById')->name('angularItemCategorySelect.roleSelected');


Route::get('itemcategory/viewbyid/{id}', 
'Admin\ItemCategoryController@getAngularItemCategoryByID')->name('itemcategory.viewbyid');

Route::get('itemcategory/deletes/{id}', 
'Admin\ItemCategoryController@removeAngularItemCategoryById')->name('itemcategory.deletes');


/*-----------------Angular Item Category Master -----------------*/

Route::get('itemattribute', 'Admin\ItemAttributeController@showAngularItemAttributeForm')->name('itemattribute');
Route::get('itemattribute/view', 'Admin\ItemAttributeController@angularItemAttributeView')->name('itemattribute.view');
Route::post('itemattribute/add', 'Admin\ItemAttributeController@itemAttributeAngularAdd')->name('itemattribute.add');
Route::post('itemattribute/edit', 'Admin\ItemAttributeController@itemAttributeAngularEdit')->name('itemattribute.edit');
Route::post('itemattribute/delete', 
  'Admin\ItemAttributeController@removeAngularItemAttribute')->name('itemattribute.delete');

Route::get('itemattribute/viewbyid/{id}', 
'Admin\ItemAttributeController@getAngularItemAttByID')->name('itemattribute.viewbyid');

Route::get('itemattribute/deletes/{id}', 
'Admin\ItemAttributeController@removeAngularItemAttById')->name('itemattribute.deletes');



/*-----------------Angular Item Master -----------------*/

Route::get('item', 'Admin\ItemController@showAngularItemForm')->name('item');
Route::get('item/view', 'Admin\ItemController@angularItemView')->name('item.view');
Route::post('item/add', 'Admin\ItemController@itemAngularAdd')->name('item.add');
Route::post('item/edit', 'Admin\ItemController@itemAngularEdit')->name('item.edit');

Route::get('item_attribute_value/item_attribute_valueselected', 
  'Admin\ItemController@removeAngularItemsssss')->name('item_attribute_value.item_attribute_valueselected');

Route::get('itemssssss/value', 'Admin\ItemController@showAngularItemFormss')->name('itemsssss.value');

Route::get('itemssssss/valuessss', 'Admin\ItemController@showAngularItemFormsstttt')->name('itemsssss.valuessss');

Route::get('insertCylinderDetail/valuessss', 'Admin\ItemController@addAngularItemFormsstttt')
->name('insertCylinderDetail.valuessss');

Route::get('insertCylinderDetail/dislapy', 
'Admin\ItemController@addAngularItemFormssttttdisay')->name('insertCylinderDetail.dislapy');


Route::post('item/delete', 'Admin\ItemController@removeAngularItem')->name('item.delete');
Route::post('angularItemSelect/roleSelected', 'Admin\ItemController@selectItemAngularById')->name('angularItemSelect.roleSelected');
Route::post('angularProcessItemCategorySelect/roleSelected', 'Admin\ItemController@selectProcessItemCategoryAngularById')->name('angularProcessItemCategorySelect.roleSelected');

Route::get('itemType/itemselectd', 'Admin\ItemController@selectItemTypeSelectd')->name('itemType.itemselectd');

Route::post('itemTypess/roleSelected', 'Admin\ItemController@selectItemTypeSelectds')->name('itemTypess.roleSelected');
Route::post('units/roleSelected', 'Admin\ItemController@selecUnitdSelectds')->name('units.roleSelected');

Route::post('partyName/roleSelected', 'Admin\ItemController@selectPartyNameSelectds')->name('partyName.roleSelected');
Route::post('itemAtt/roleSelected', 'Admin\ItemController@selectItemAtttrubute')->name('itemAtt.roleSelected');

Route::post('editpartyName/roleSelected',
  'Admin\ItemController@selectEditPartyNameSelectds')->name('editpartyName.roleSelected');

Route::post('edititemAtt/roleSelected', 
  'Admin\ItemController@selectEditItemAtttrubute')->name('edititemAtt.roleSelected');

Route::post('getedititemAtt/roleSelected', 
  'Admin\ItemController@getselectItemAtttrubutess')->name('getedititemAtt.roleSelected');

Route::get('getValues/itemCayselectds', 
'Admin\ItemController@selectgetValueSelectd')->name('getValues.itemCayselectds');

Route::get('item/viewbyid/{id}', 'Admin\ItemController@getAngularItemByID')->name('item.viewbyid');
Route::get('item/deletes/{id}', 'Admin\ItemController@removeAngularItemById')->name('item.deletes');
Route::get('itemsssssss/value/{id}', 'Admin\ItemController@showAngularItemFormss')->name('itemsssssss.value');

//Route::get('itemssssss/value', 'Admin\ItemController@showAngularItemFormss')->name('itemsssss.value');
Route::get('itemssssssDetails/delete/{id}', 'Admin\ItemController@showAngularItemFormsstttt')->name('itemssssssDetails.delete');
Route::post('itemDetails/adds', 'Admin\ItemController@itemDetailsAngularAdd')->name('itemDetails.adds');


/*-----------------Angular Purchase Master -----------------*/

Route::get('addPurchase', 'Admin\ItemAttributeController@angularItemCategoryView')->name('addPurchase');
Route::post('purchase/add', 'Admin\ItemAttributeController@itemCategoryAngularAdd')->name('purchase.add');
Route::post('purchase/edit', 'Admin\ItemAttributeController@itemCategoryAngularEdit')->name('purchase.edit');
Route::post('purchase/delete', 'Admin\ItemAttributeController@removeAngularItemCategory')->name('purchase.delete');
Route::get('purchase/roleSelected','Admin\ItemAttributeController@selectItemCategoryById')->name('purchase.roleSelected');
Route::get('purchase/viewbyid/{id}','Admin\ItemAttributeController@getAngularPurhaseDataByID')->name('purchase.viewbyid');
Route::get('purchaseitem/roleSelected','Admin\ItemAttributeController@selectItemUnitAngularByIds')->name('purchaseitem.roleSelected');    
Route::get('purchaseitemId/roleSelected','Admin\ItemAttributeController@selectItemUnitAngularById')->name('purchaseitemId.roleSelected');
Route::get('purchasegstitemId/roleSelected','Admin\ItemAttributeController@selectItemGstAngularById')
->name('purchasegstitemId.roleSelected');

Route::get('purchase/deletes', 'Admin\ItemAttributeController@removePurchaseDetail')->name('purchase.deletes');
Route::get('otherCharge/otherCharges', 'Admin\ItemAttributeController@getOtherCharges')->name('otherCharge.otherCharges');


/*-----------------Angular Purchase Order Master -----------------*/


Route::get('purchaseorder/itemselectd', 'Admin\ItemAttributeController@getItemNamebyPartyId')->name('purchaseorder.itemselectd');
Route::get('purchaseorder/itemattselectd', 'Admin\ItemAttributeController@getItemNameAttbyPartyId')->name('purchaseorder.itemattselectd');

Route::post('purchaseorder/add', 'Admin\ItemAttributeController@purchaseOrderAngularAdd')->name('purchaseorder.add');
Route::post('purchaseorder/edit', 'Admin\ItemAttributeController@purchaseOrderAngularEdit')->name('purchaseorder.edit');

Route::get('addPurchaseOrder', 'Admin\ItemAttributeController@addPurchaseOrderView')->name('addPurchaseOrder');
Route::get('purchaseorder/view', 'Admin\ItemAttributeController@purchaseOrderViewData')->name('purchaseorder.view');
Route::get('purchaseorder', 'Admin\ItemAttributeController@purchaseOrderView')->name('purchaseorder');

Route::get('purchaseorder/viewbyid/{id}','Admin\ItemAttributeController@getPurhaseOrderDataByID')->name('purchaseorder.viewbyid');
Route::get('purchaseorder/delete', 'Admin\ItemAttributeController@removePurhaseOrderById')->name('purchaseorder.delete');
Route::get('attachment/remove', 'Admin\ItemAttributeController@removeAttachmentById')->name('attachment.remove');
Route::get('purchaseorder/pdf/{id}', 'Admin\ItemAttributeController@getPoReport')->name('purchaseorder.pdf');
Route::post('jobcard/add', 'Admin\ItemAttributeController@jobCardAngularAdd')->name('jobcard.add');


//Route::post('purchaseorder/edit', 'Admin\ItemAttributeController@purchaseOrderAngularEdit')->name('purchaseorder.edit');



/*-----------------Angular Purchase Master -----------------*/          

Route::get('purchases', 'Admin\ItemAttributeController@showAngularPurhaseForm')->name('purchases');

Route::get('purchase/view', 'Admin\ItemAttributeController@showAngularPurhaseForm')->name('purchase.view');

Route::get('addPurchase', 'Admin\ItemAttributeController@showaddPurchaseForm')->name('addPurchase');
Route::post('purchase/add', 'Admin\ItemAttributeController@purchaseAngularAdd')->name('purchase.add');

Route::post('purchase/edit', 'Admin\ItemAttributeController@purhaseAngularEdit')->name('purchase.edit');
Route::post('purchase/delete', 'Admin\ItemAttributeController@removeAngularPurhase')->name('purchase.delete');


Route::get('purchase/roleSelected','Admin\ItemAttributeController@selectPurhaseAngularById')->name('purchase.roleSelected');

Route::get('purchase/itemselectds','Admin\ItemAttributeController@selectItemNamedAngularById')
->name('purchase.itemselectds');

Route::get('purchase/itemgstselectds','Admin\ItemAttributeController@selectItemNameGstudAngularById')
->name('purchase.itemgstselectds');



Route::get('purchase/itemunitselectd','Admin\ItemAttributeController@selectItemNameUnitAngularById')
->name('purchase.itemunitselectd');

Route::get('purchase/itemselectd','Admin\ItemAttributeController@selectItemNamesAngularById')->name('purchase.itemselectd');


Route::get('purchase/viewbyid/{id}','Admin\ItemAttributeController@getAngularPurhaseDataByID')->name('purchase.viewbyid');

Route::get('purchaseitem/roleSelected','Admin\ItemAttributeController@selectItemUnitAngularByIds')
->name('purchaseitem.roleSelected');    

Route::get('purchaseitemId/roleSelected','Admin\ItemAttributeController@selectItemUnitAngularById')->name('purchaseitemId.roleSelected');

Route::get('purchasegstitemId/roleSelected','Admin\ItemAttributeController@selectItemGstAngularById')
->name('purchasegstitemId.roleSelected');

Route::get('purchaseser', 'Admin\ItemAttributeController@showAngularPurhaseForm')->name('purchaseser');

Route::get('purchasesers', 'Admin\ItemAttributeController@showAngularPurhasesForm')->name('purchasesers');

Route::get('addPurchase', 'Admin\ItemAttributeController@showaddPurchaseForm')->name('addPurchase');

