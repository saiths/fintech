<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin\UserModel;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Jenssegers\Agent\Agent;
use DateTime;
use Redirect;
use URL;
use DatePeriod;
use DateInterval;


class UserController extends Controller
{

   
   /**
     *  show Login View File 
     *
     * @return return Login View file    
     * @author <satishchauhan041@gmail.com>
     */
    public function showLoginForm()
    {
        return view('admin.login');

    }


   /**
     *  show Login View File 
     *
     * @return return Login View file    
     * @author <satishchauhan041@gmail.com>
     */
    public function showaddUserForm()
    {
        return view('admin.addUser');
    }
   
   /**
     *  User Login 
     *
     * @param Request $request
     * @return return Login View file     
     * @author <satishchauhan041@gmail.com>
     */
    public function checkUserLogin(Request $request)
    {   

        Session::forget('sessionUserData');
        $this->validate($request,[
            'username'  => 'required',
            'password'  => 'required',
            'captcha'   => 'required|captcha'
        ]);

        $newPassword  = base64_encode($request->input('password'));
        $userData = ['username'=> $request->input('username'),'password' => $newPassword];
        if (!empty($userData)) {
            $userModel = new UserModel();
            $loginResult = $userModel->userLogin($userData);

            if (!empty($loginResult)) {
                Session::push('sessionUserData',$loginResult);
                Session::flash('message','Login Successful');


                return redirect('dashboard');

            } else {

                Session::flash('messages','Invalid Email and Password.');
                
                return redirect('/');
            }
        }
        return view('admin.login',['loginPostData' => $request->all()]);

    }

    
   /**
     *  User Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function userDashboard() 
    { 
        return view('admin.dashboard');
    }

   /**
     *  User Dashboard
     *
     * @return admin Dashboard view file   
     * @author <satishchauhan041@gmail.com>
     */
    public function showAngularUserForm() 
    { 
        return view('admin.user');
    }

  /**
    *  get UserData using Angular
    *
    * @return userData    
    * @author <satishchauhan041@gmail.com>
    */
    public function angularUserView()
    {   
        

        $userModel = new UserModel();
        $getUserData = $userModel->selectUser();

        foreach ($getUserData as $key => $user) {


            $getUserData[$key]->username = !empty($user->username) ? $user->username : '';
            
            if ($user->user_type == 3) {

                $getUserData[$key]->name = !empty($user->party_name) ? $user->party_name : '';
                            $getUserData[$key]->mobile = !empty($user->contact_mobile_no) ? $user->contact_mobile_no : '';


            } else if ($user->user_type = 1) {

                $getUserData[$key]->name = !empty($user->name) ? $user->name : '';
                            $getUserData[$key]->mobile = !empty($user->mobile) ? $user->mobile : '';


            }  else {


                $getUserData[$key]->name = !empty($user->name) ? $user->name : '';
                            $getUserData[$key]->mobile = !empty($user->mobile) ? $user->mobile : '';
                            
            }  
        }
        
        return $getUserData;

    }

  /**
    *  add UserData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function userAngularAdd(Request $request)
    {
        

        $userType = !empty($request->input('user_type')) ? $request->input('user_type') : 0;
        
        if ($userType == 3) {
            
            /*$this->validate($request,[
                'uusername'             => 'required',
                'party_name'           => 'required|unique:user_master',
                'party_city'           => 'required',
                'contact_person'       => 'required',
                'contact_mobile_no'    => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'contact_whatsapp_no'  => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'password'             => 'required',
                'retype_password'      => 'required|same:password',    
            ]);
            */
            
        } else if ($userType == 1) {
            
            /*$this->validate($request,[
                'username'          => 'required|unique:user_master',
                'upassword'         => 'required',
                'uretype_password'  => 'required|same:upassword',
                'umobile'           => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'uname'             => 'required',
            ]);
            */

        } else {

            /*$this->validate($request,[
                'username'          => 'required|unique:user_master',
                'upassword'         => 'required',
                'uretype_password'  => 'required|same:upassword',
                'umobile'           => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'uname'             => 'required',
            ]);
            */
            

        }
        


        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
        $userIds = 0;

        $partyText = 0;
        $userText = 0;
        

      //  $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
      //  $userName = !empty($request->input('username')) ? $request->input('username') : 0;
        
        if ($userType == 3) {

            $userModel = new UserModel();
            $resultUserName = $userModel->userNameAlredyExists(trim($request->input('party_name')),$userIds,$userType);
            $partyText =  !empty($resultUserName) ? 'partyText' : '';
            
            //else {
                   
              //  $userModel = new UserModel();
             //   $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
              //  $userText =  !empty($resultUserName) ? 'userText' : 0;
                
           // }

            //if ($userText ==  'userText' || $partyText == 'partyText') { 

            if ($partyText == 'partyText') {

                //if ($userText == 'userText') { 
                  //  return ['success'=> true,'userText' => $userText];
                //} else {

                    return ['success'=> true,'partyText' => $partyText];
               // }


            } else {

                
                $name = !empty($request->input('name')) ? $request->input('name') : 0;
                $userName = !empty($request->input('uusername')) ? $request->input('uusername') : 0;
                $password = !empty($request->input('password')) ? $request->input('password') : 0;
                $mobile = !empty($request->input('mobile')) ? $request->input('mobile') : 0;

                $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                $partyCreditLimit = !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                $contactWhatsappNo = !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                $transportMobileNo = !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;
                $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                
                $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0

                ];

                $userModel = new UserModel();
                $userResult = $userModel->userInsert($userData);

              //  Session::flash('messages','User has been added.');

              //  return ['success'=> true,'message' => 'User has been added.'];
            
            }

            Session::flash('messages','Party has been added.');

            
        } else if ($userType == 1) {


            //else {
                   
                $userModel = new UserModel();
                $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
                $userText =  !empty($resultUserName) ? 'userText' : '';
                
           // }


            //if ($userText ==  'userText' || $partyText == 'partyText') { 

            if ($userText == 'userText') {


                //if ($userText == 'userText') { 
                  //  return ['success'=> true,'userText' => $userText];
                //} else {

                    return ['success'=> true,'userText' => $userText];
               // }


            } else {

                
                $name = !empty($request->input('uname')) ? $request->input('uname') : 0;
                $userName = !empty($request->input('username')) ? $request->input('username') : 0;
                $password = !empty($request->input('upassword')) ? $request->input('upassword') : 0;
                $mobile = !empty($request->input('umobile')) ? $request->input('umobile') : 0;

                $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                $partyCreditLimit = !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                $contactWhatsappNo = !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                $transportMobileNo = !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;
                $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                
                $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0
                ];

                $userModel = new UserModel();
                $userResult = $userModel->userInsert($userData);

                
              //  return ['success'=> true,'message' => 'User has been added.'];
                

            }    


            Session::flash('messages','Admin has been added.');


        } else {


            //else {
                   
                $userModel = new UserModel();
                $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
                $userText =  !empty($resultUserName) ? 'userText' : '';
                
           // }


                //if ($userText ==  'userText' || $partyText == 'partyText') { 

                if ($userText == 'userText') {


                    //if ($userText == 'userText') { 
                      //  return ['success'=> true,'userText' => $userText];
                    //} else {

                        return ['success'=> true,'userText' => $userText];
                   // }


                } else {

                    
                    $name = !empty($request->input('uname')) ? $request->input('uname') : 0;
                    $userName = !empty($request->input('username')) ? $request->input('username') : 0;
                    $password = !empty($request->input('upassword')) ? $request->input('upassword') : 0;
                    $mobile = !empty($request->input('umobile')) ? $request->input('umobile') : 0;

                    $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                    $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                    $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                    $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                    $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                    $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                    $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                    $partyCreditLimit = !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                    $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                    $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                    $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                    $contactWhatsappNo = !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                    $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                    $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                    $transportMobileNo = !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;
                    $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                    
                    $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0
                    ];

                    $userModel = new UserModel();
                    $userResult = $userModel->userInsert($userData);

                    
                  //  return ['success'=> true,'message' => 'User has been added.'];
                    

                }    

                Session::flash('messages','User has been added.');
        


        }
        
            
            


    }   


  /**
    *  update UserData using Angular
    *
    * @param  Request $request
    * @return success Msg    
    * @author <satishchauhan041@gmail.com>
    */
    public function userAngularEdit(Request $request)
    {
        
     
         
        $userType = !empty($request->input('user_type')) ? $request->input('user_type') : 0;
        
        if ($userType == 3) {
            
            /*$this->validate($request,[
                'uusername'             => 'required',
                'party_name'           => 'required|unique:user_master',
                'party_city'           => 'required',
                'contact_person'       => 'required',
                'contact_mobile_no'    => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'contact_whatsapp_no'  => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'password'             => 'required',
                'retype_password'      => 'required|same:password',    
            ]);
            */

        } else if ($userType == 1) {
            
            /*$this->validate($request,[
                'username'          => 'required|unique:user_master',
                'upassword'         => 'required',
                'uretype_password'  => 'required|same:upassword',
                'umobile'           => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'uname'             => 'required',
            ]);
            */
            
        } else {

            /*$this->validate($request,[
                'username'          => 'required|unique:user_master',
                'upassword'         => 'required',
                'uretype_password'  => 'required|same:upassword',
                'umobile'           => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'uname'             => 'required',
            ]);
            */

        }
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $status = 'N';
       
        $partyText = 0;
        $userText = 0;
        
        $userType = !empty($request->input('user_type')) ? $request->input('user_type') : 0;
        
        $userIds = !empty($request->input('userId')) ? $request->input('userId') : 0;
        




      //  $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
      //  $userName = !empty($request->input('username')) ? $request->input('username') : 0;

        
        if ($userType == 3) {

            $userModel = new UserModel();
            $resultUserName = $userModel->userNameAlredyExists(trim($request->input('party_name')),$userIds,$userType);
            $partyText =  !empty($resultUserName) ? 'partyText' : '';
            
            //else {
                   
              //  $userModel = new UserModel();
             //   $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
              //  $userText =  !empty($resultUserName) ? 'userText' : 0;
                
           // }

            //if ($userText ==  'userText' || $partyText == 'partyText') { 

            if ($partyText == 'partyText') {

                //if ($userText == 'userText') { 
                  //  return ['success'=> true,'userText' => $userText];
                //} else {

                //return ['success'=> true,'partyText' => $partyText];
                
                echo 'partyText';
                
                
               // }


            } else {

                
                $name = !empty($request->input('name')) ? $request->input('name') : 0;
                $userName = !empty($request->input('uusername')) ? $request->input('uusername') : 0;
                $password = !empty($request->input('password')) ? $request->input('password') : 0;
                $mobile = !empty($request->input('mobile')) ? $request->input('mobile') : 0;

                $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                $partyCreditLimit = 
                !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                $contactWhatsappNo = 
                !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                $transportMobileNo = 
                !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;

                $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                
                $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0

                ];



                $userModel = new UserModel();
                $userResult = $userModel->updateUser($userData,$userIds);
                //return ['success'=> true,'message' => 'User has been updated.'];
                Session::flash('message','User has been updated.');
                
               // return redirect('user');
                
            }

            Session::flash('message','Party has been updated.');


            
        } else if($userType == 1) {


            //else {
                   
                $userModel = new UserModel();
                $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
                $userText =  !empty($resultUserName) ? 'userText' : '';
                
           // }


            //if ($userText ==  'userText' || $partyText == 'partyText') { 

            if ($userText == 'userText') {


                //if ($userText == 'userText') { 
                  //  return ['success'=> true,'userText' => $userText];
                //} else {

                 //   return ['success'=> true,'userText' => $userText];
               // }
                    
                echo 'userText';

            } else {

                
                $name = !empty($request->input('uname')) ? $request->input('uname') : 0;
                $userName = !empty($request->input('username')) ? $request->input('username') : 0;
                $password = !empty($request->input('upassword')) ? $request->input('upassword') : 0;
                $mobile = !empty($request->input('umobile')) ? $request->input('umobile') : 0;

                $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                $partyCreditLimit = !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                $contactWhatsappNo = !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                $transportMobileNo = !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;
                $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                
                $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0

                ];
                
               // print_r($userData);die;
                

                $userModel = new UserModel();
                $userResult = $userModel->updateUser($userData,$userIds);
                //return ['success'=> true,'message' => 'User has been updated.'];
               // return redirect('user');
                

            } 

            Session::flash('message','Admin has been updated.');


        } else {

            //else {
                   
                $userModel = new UserModel();
                $resultUserName = $userModel->userNameAlredyExists(trim($request->input('username')),$userIds,$userType); 
                $userText =  !empty($resultUserName) ? 'userText' : '';
                
           // }


            //if ($userText ==  'userText' || $partyText == 'partyText') { 

            if ($userText == 'userText') {


                //if ($userText == 'userText') { 
                  //  return ['success'=> true,'userText' => $userText];
                //} else {

                 //   return ['success'=> true,'userText' => $userText];
               // }
                    
                echo 'userText';

            } else {

                
                $name = !empty($request->input('uname')) ? $request->input('uname') : 0;
                $userName = !empty($request->input('username')) ? $request->input('username') : 0;
                $password = !empty($request->input('upassword')) ? $request->input('upassword') : 0;
                $mobile = !empty($request->input('umobile')) ? $request->input('umobile') : 0;

                $partyName = !empty($request->input('party_name')) ? $request->input('party_name') : 0;
                $partyAddress = !empty($request->input('party_address')) ? $request->input('party_address') : 0;
                $partyCountry = !empty($request->input('party_country')) ? $request->input('party_country') : 0;
                $partyState = !empty($request->input('party_state')) ? $request->input('party_state') : 0;
                $partyCity = !empty($request->input('party_city')) ? $request->input('party_city') : 0;
                $partyPincode = !empty($request->input('party_pincode')) ? $request->input('party_pincode') : 0;
                $partyGstNo = !empty($request->input('party_gst_no')) ? $request->input('party_gst_no') : 0;
                $partyCreditLimit = !empty($request->input('party_credit_limit')) ? $request->input('party_credit_limit') : 0;

                $contactPerson = !empty($request->input('contact_person')) ? $request->input('contact_person') : 0;
                $contactEmail = !empty($request->input('contact_email')) ? $request->input('contact_email') : 0;
                $contactMobileNo = !empty($request->input('contact_mobile_no')) ? $request->input('contact_mobile_no') : 0;
                $contactWhatsappNo = !empty($request->input('contact_whatsapp_no')) ? $request->input('contact_whatsapp_no') : 0;

                $transportName = !empty($request->input('transport_name')) ? $request->input('transport_name') : 0;
                $transportAddress = !empty($request->input('transport_address')) ? $request->input('transport_address') : 0;
                $transportMobileNo = !empty($request->input('transport_mobile_no')) ? $request->input('transport_mobile_no') : 0;
                $transportEmail = !empty($request->input('transport_email')) ? $request->input('transport_email') : 0; 
                
                $userData = [ 
                    
                    'user_type'           => $userType,
                    'name'                => $name,
                    'username'            => $userName,
                    'password'            => base64_encode($password),
                    'mobile'              => $mobile,

                    'party_name'          => $partyName,
                    'party_address'       => $partyAddress,
                    'party_country'       => $partyCountry,
                    'party_state'         => $partyState,
                    'party_city'          => $partyCity,
                    'party_pincode'       => $partyPincode,
                    'party_gst_no'        => $partyGstNo,
                    'party_credit_limit'  => $partyCreditLimit,

                    'contact_person'      => $contactPerson,
                    'contact_email'       => $contactEmail,
                    'contact_mobile_no'   => $contactMobileNo,
                    'contact_whatsapp_no' => $contactWhatsappNo,
                  
                    'transport_name'      => $transportName,
                    'transport_address'   => $transportAddress,
                    'transport_mobile_no' => $transportMobileNo,
                    'transport_email'     => $transportEmail, 

                    'status'            => $status,
                    'created_at'        => $time,
                    'updated_at'        => $time,
                    'deleted_at'        => $time,

                    'created_by'        => 0,
                    'edited_by'         => 0,
                    'deleted_by'        => 0

                ];
                
               

                $userModel = new UserModel();
                $userResult = $userModel->updateUser($userData,$userIds);
                //return ['success'=> true,'message' => 'User has been updated.'];
               // return redirect('user');
                

            } 

            Session::flash('message','User has been updated.');

        }

        
    }

   /**
     *  delete User By id using angular
     *
     * @param  Request $request
     * @return success Msg    
     * @author <satishchauhan041@gmail.com>
     */
    public function removeAngularUser()
    {
       // $userId = $request->input('id');
        $userId = !empty($_GET['id']) ? $_GET['id'] : '';
        if (!empty($userId)) {
            $userModel = new UserModel();
            $result = $userModel->deleteUser($userId);
            if (!empty($result)) {

              echo 1;

            } else {
                
                echo 0;

            }

            //return ['success'=> true, 'message' => 'User has been deleted.'];
        }
    }


    /**
     *  User Logout
     *
     * @return admin view file    
     * @author <satishchauhan041@gmail.com>
     */
    public function userLogout() 
    {
        Session::flush();
        Session::forget('sessionUserData');
        unset($_SESSION['userRoleId']);
        session_destroy();
        Session::flash('message','Logout Successful');
        return redirect('/');
    }

       /**
     * Show user change password
     *
     * @return change Password view file
     * @author <satishchauhan041@gmail.com>
     */
    public function userChangePassword() 
    { 
        return view('admin.changePassword2');
    }


   /**
     *  update Change password  
     *
     * @param  Request $request
     * @return change Password view file    
     * @author <satishchauhan041@gmail.com>
     */
    public function userChangePasswordUpdate(Request $request) 
    { 
        
        
        
        $successMsg = '';
        $errorMsg = '';
        
        if (empty($request->input('currentpassword')) ||
            empty($request->input('newpassword'))  || empty($request->input('confirmpassword')))
        { 
        
            if (empty($request->input('currentpassword'))) {
                $data['emptyCurrentMsg'] = 'Current password Required.';
            } 

            if (empty($request->input('newpassword'))) {
                $data['emptyNewMsg'] = 'New Password Required.';
            }
          
            if (empty($request->input('confirmpassword'))) {
                $data['emptyConfirmMsg'] = 'Confirm Password Required.';
            }

            return view('admin.changePassword2', [
                'emptyErrorMsg' => $data,
            ]); 

        }

        if (trim($request->input('newpassword')) != trim($request->input('confirmpassword'))) {
            $data['emptyNewMsg'] = 'New password and Confirm password do not match.';
            return view('admin.changePassword2', [
                'emptyErrorMsg' => $data,
            ]); 
        }

        $checkCurPassword = 
        base64_encode(trim($request->input('currentpassword')));
        
        $sessionData = Session::get('sessionUserData');
        $sessionUserId = $sessionData[0][0]->id;
        $userModel = new UserModel();
        $getIdCurPassword = $userModel->getCurPasswordId($checkCurPassword,$sessionUserId);
        
        if (!empty($getIdCurPassword[0]->id)) {
            $newPassword = base64_encode(trim($request->input('newpassword')));
            $userModel = new UserModel();
            $checkCurPwdUpdateResult = $userModel->getCurPasswordUpdateBySessId($sessionUserId,$newPassword);
            
            Session::flash('message','Password has been updated.');
            return Redirect::to('changepassword'); 
            //return view('admin.changePassword2',['successMsg' => $successMsg]);
        } 
        
        $data['emptyCurrentMsg'] = 'Current Password do not match!';
        return view('admin.changePassword2', [
            'emptyErrorMsg' => $data,
        ]); 

    }


       /**
     * Show user change password with angular
     *
     * @return change Password view file angular
     * @author <satishchauhan041@gmail.com>
     */
    public function angularUserChangePassword() 
    { 
        return view('admin.angularchangePassword2');
    }

    /**  
     *  update Change password  with angulars
     *
     * @param  Request $request
     * @return change Password view file angular  
     * @author <satishchauhan041@gmail.com>
     */
    public function angularUserChangePasswordUpdate(Request $request) 
    { 
        
        $this->validate($request,[
            'currentpassword'  => 'required',
            'newpassword'      => 'required',
            'confirmpassword'  => 'required|same:newpassword'
        ]);
        
        $checkCurPassword = 
        base64_encode(trim($request->input('currentpassword')));
        
        $sessionData = Session::get('sessionUserData');
        $sessionUserId = $sessionData[0][0]->id;
        
        $userModel = new UserModel();
        $getIdCurPassword = $userModel->getCurPasswordId($checkCurPassword,$sessionUserId);
        
        if (!empty($getIdCurPassword)) {
            
            $newPassword = base64_encode(trim($request->input('newpassword')));
            $userModel = new UserModel();
            $checkCurPwdUpdateResult = 
            $userModel->getCurPasswordUpdateBySessId($sessionUserId,$newPassword);
            
            Session::flash('message','Password has been Updated.');
            return redirect('achangepassword');
            
        } else {
           
           Session::flash('messages','Current Password do not match.');
           return redirect('achangepassword');
        }
    }
    
    /**
     * Show profile Form
     *
     * @return edit profile view file with angular
     * @author <satishchauhan041@gmail.com>
     */
    public function angularShowFormProfile() 
    {   
        return view('admin.angularprofile2');
        //return redirect('aeditprofile');
        

    }

    
   /**
     * update Profile by session Id
     *
     * @param  Request $request
     * @return edit profile view file
     * @author <satishchauhan041@gmail.com>
     */
    public function angularUpdateProfile(Request $request) 
    {   
        
        $sessionUserData = Session::get('sessionUserData');
      //  $userId = !empty($sessionUserData[0][0]->id) ? $sessionUserData[0][0]->id : 0;
        
        $userTypeId = !empty($sessionUserData[0][0]->user_type) ? $sessionUserData[0][0]->user_type : 0;
        
        $company_edit_profile_id = 
        !empty($request->input('company_edit_profile_id')) ? $request->input('company_edit_profile_id') : 0;
        
        
        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A'); 


        $status = 'N';  
          
        if (!empty($request->input('company_name'))) {
            $company_name = $request->input('company_name');
        } else {
            $company_name = '';
        } 

        if (!empty($request->input('address'))) {
            $address = $request->input('address');
        } else {
            $address = '';
        }
        
        if (!empty($request->input('phone'))) {
            $phone = $request->input('phone');
        } else {
            $phone = '';
        }
        
        if (!empty($request->input('contact_email'))) {
            $email = $request->input('contact_email');
        } else {
            $email = '';
        }
            
        if (!empty($request->input('website'))) {
            $website = $request->input('website');
        } else {
            $website = '';
        }
        
        if (!empty($request->input('gst_no'))) {
            $gst_no = $request->input('gst_no');
        } else {
            $gst_no = '';
        }
        
        
        $getUserDataByID = DB::table('company_edit_profile')
            ->select('*')
            ->where('is_deleted_status','N')
            ->where('id',$company_edit_profile_id)
            //->where('user_type_id',$userTypeId)
            ->get()
            ->toArray();
            
        $current_logo = 
        !empty($getUserDataByID[0]->logo) ?  $getUserDataByID[0]->logo : ''; 

        error_reporting(0);
        $uploadPath = public_path('company_edit_profile_image');
        $allowedfileExtension=['pdf','jpg','png','docx'];
        $logos = $request->file('logos');
        
        if (!empty($logos)) {
            
            $logo = time().'_'.$logos->getClientOriginalName();
            $unlinkPath =  $_SERVER['DOCUMENT_ROOT'].'/fintech/laravel/public/company_edit_profile_image/';
            $result = unlink($unlinkPath.$current_logo);
            $resultPhoto = $logos->move($uploadPath, $logo);
            
        } 
    
/*        if (!empty($request->input('contact_email'))) {
            $userModel = new UserModel();
            $resultEmail = $userModel->userEmailAlredyExists(trim($request->input('contact_email')),
                $userId,$userTypeId,$company_edit_profile_id);
        } 
        
        if (!empty($request->input('phone'))) {
            $userModel = new UserModel();
            $resultMobile = $userModel->userPhoneAlredyExists(trim($request->input('phone')),
                $userId,$userTypeId,$company_edit_profile_id); 
        }   
*/

      //  $emailText  =  !empty($resultEmail) ? 'emailText'   : 0;
        //$mobileText =  !empty($resultMobile) ? 'mobileText' : 0;
            

        //if ($emailText == '' && $mobileText == '') { 
        
        if ($userTypeId == 1) { 
            
            $userData = [ 
                'user_type_id'      => 0,
                'user_id'           => 0,
                'company_name'      => $company_name,
                'address'           => $address,
                'phone'             => $phone,
                'email'             => $email,  
                'website'           => $website,  
                'gst_no'            => $gst_no,
                'logo'              => !empty($logo) ?  $logo : $current_logo,
                'address'           => $address,
                'status'            => $status,
                'created_by'        => 0,
                'edited_by'         => 0,
                'deleted_by'        => 0,
                'created_at'        => $time,
                'updated_at'        => $time,
                'deleted_at'        => $time
            ];
            
            if (!empty($getUserDataByID)) {
                
                $company_edit_profileId = !empty($getUserDataByID[0]->id) ? $getUserDataByID[0]->id : 0;
                
                $updateResult = DB::table('company_edit_profile')
                    ->where('id', $company_edit_profileId)
                    ->where('is_deleted_status', 'N')
                    
                   // ->where('user_id', $userId)
                   // ->where('user_type_id', $userTypeId)
                    ->update($userData);
                
                Session::flash('message','Edit Profile has been updated.');
                return redirect('aeditprofile');
                
                
                

            } else {
                
                $insertResult = 
                DB::table('company_edit_profile')
                ->insert($userData);
                
                /*return ['success'=> true,'message' => 'Edit Profile has been added.'];
                */
                
                Session::flash('message','Edit Profile has been added.');
                return redirect('aeditprofile');
                
                
            }
            
            /*return ['success'=> true,'message' => 'Edit Profile has been updated'];
            */
    
                
        } else {
            
            Session::flash('message','Edit Profile has been updated.');
                return redirect('aeditprofile');
                
            
         //   Session::flash('message','User has been updated.');

           // return ['success'=> true, 'emailText' => $emailText, 'mobileText' => $mobileText ];
        } 

    }

      
    /**
     * Show profile Form
     *
     * @return edit profile view file
     * @author <satishchauhan041@gmail.com>
     */
    public function showFormProfile() 
    { 
        return view('admin.profile2');
    }

    /**
     * update Profile by session Id
     *
     * @return edit profile view file
     * @author <satishchauhan041@gmail.com>
     */
    public function updateProfile(Request $request) 
    {   
      
        $this->validate($request,[
            'mobile'    => 'required|string|min:10|max:10',
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255',
            'username'  => 'required',
            //'client_id' => 'required',
            'role_id'   => 'required',
        ]);

        /*if (!empty($request->input('status')) == 'no') {
            $status = 'Yes';
        } else {
            $status = 'No';
        }*/

        $roleId = 0;
        $clientId = 0;
        if (!empty($request->input('role_id'))) {
            $roleId = $request->input('role_id');
            if  ($roleId == 4) {
              if (empty($request->input('client_id'))) {
                return view('admin.profile2',[
                    'emptyErrorMsgs'=> 'Please Select Client',
                    'registerUserPostData' => $request->input('role_id')
                ]);
              } else {
                $clientId = $request->input('client_id');
            }
          } 
        }

        $status = 'N';
          
        if (!empty($request->input('date_of_birth'))) {
            $dateOfBirth = $request->input('date_of_birth');
        } else {
            $dateOfBirth = 0;
        } 

        if (!empty($request->input('date_of_joining'))) {
            $dateOfJoining = $request->input('date_of_joining');
        } else {
            $dateOfJoining = 0;
        } 
        
        $userIds = $request->input('userId');
        
        if (!empty($request->input('email'))) {
            $userModel = new UserModel();
            $resultEmail = $userModel->userEmailAlredyExists(trim($request->input('email')),$userIds);
        } 

        if (!empty($request->input('mobile'))) {
            $userModel = new UserModel();
            $resultMobile = $userModel->userMobileAlredyExists(trim($request->input('mobile')),$userIds); 
        } 

        if (!empty($request->input('username'))) {
            $userModel = new UserModel();
            $resultUserName = $userModel->userUserNameAlredyExists(trim($request->input('username')),$userIds);
        }
        
        if ( !empty($resultEmail) || !empty($resultMobile) || !empty($resultUserName) ) {
            
            if (!empty($resultEmail)) {
              $data['checkEmailMsg'] = " '".$request->input('email')."' Email has already been taken.";
            }

            if (!empty($resultMobile)) {
              $data['checkMobileMsg'] = " '".$request->input('mobile')."' Mobile has already been taken.";
            }

            if (!empty($resultUserName)) {
              $data['checkUserNameMsg'] = " '".$request->input('username')."' UserName has already been taken.";
            }

            return view('admin.profile2',[
              'emptyErrorMsg'=> $data,
            ]);
        }

        date_default_timezone_set('Asia/Kolkata');   
        $time =  date('d-m-Y h:i:s A');
        
        $userData = [ 
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'mobile'      => $request->input('mobile'),
            'username'   =>  $request->input('username'),         
            'date_of_birth'  =>  $dateOfBirth,
            'date_of_joining' => $dateOfJoining,
            'role_id'    => $request->input('role_id'),
            'client_id'    => $clientId,
            'address'     => !empty($request->input('address'))? $request->input('address') : '' ,
            'status'     => $status,
            'updated_at' => $time
        ];
        
        $successMsg = '';
        $userModel = new UserModel();
        $userResult = $userModel->updateUser($userData,$userIds);
        $successMsg = "Profile Update Successfully.";
        Session::flush();
        Session::forget('sessionUserData');
        $userModel = new UserModel();
        $getUserDataByID = $userModel->selectUserDataByID($userIds);  
        $sessionUserData = Session::push('sessionUserData',$getUserDataByID); 
        Session::flash('message','Profile has been updated');
        return redirect('editprofile');
        //return view('admin.profile2',['successMsg' => $successMsg ]);
    }    


  /**
    *  get userTypeId Data By Date using ajax
    *
    * @param Request $request
    * @return userTypeId blude file    
    * @author <satishchauhan041@gmail.com>
    */
    public function getUserTypeIdById()
    {     
        
        $getUserData = [];

        if (!empty($_GET['userTypeId']))  {
                 
            $userTypeId = !empty($_GET['userTypeId']) ?  $_GET['userTypeId'] : 0;
            
            $getUserData = DB::table('user_master')
                ->select('*')
                ->where('is_deleted_status','N')
                ->where('user_type',$userTypeId)
                 ->orderBy('username', 'ASC')
                ->get()
                ->toArray();
                
            if (!empty($getUserData)) {
                
                $i = 1;
                foreach ($getUserData as $key => $user) {

/*                  if ($user->user_type == 1) {
                        $userType = $getUserData[$key]->userType = 'Party';
                    } else {
                        $userType = $getUserData[$key]->userType = 'User';
                    }
*/
                        $getAttendanceHtml =  "<tr id='getUserByDateId_".$user->id."'  style='background-color: white'>";
                        
                        $getAttendanceHtml .="<td>".$i."</td>";

                            if ($userTypeId == 3) {
                                $getAttendanceHtml .="<td>".$user->party_name."</td>";
                            } else if ($userTypeId == 2) {
                                $getAttendanceHtml .="<td>".$user->name."</td>";
                            } else {
                                $getAttendanceHtml .="<td>".$user->name."</td>";
                            }

                            $getAttendanceHtml .="<td>".$user->username."</td>";
                            
                            if ($userTypeId == 3) {
                                $getAttendanceHtml .="<td>".$user->contact_mobile_no."</td>";
                            } else if ($userTypeId == 2) {
                                $getAttendanceHtml .="<td>".$user->mobile."</td>";
                            } else {
                                $getAttendanceHtml .="<td>".$user->name."</td>";
                            }
                            
                            $getAttendanceHtml .="<td>
                            
                            <a href='#' onclick='showUserData(".$user->id.")'> 
                                <i class='text-dark-10 flaticon2-edit'></i>
                            </a>";
                            
                            if ($userTypeId == 3 || $userTypeId == 2) {

                                $getAttendanceHtml .=  "<a href='#' onclick='deleteUserData(".$user->id.")' >
                                    <i class='text-dark-10 flaticon2-trash'></i>
                                    </a>";

                            }

                            
                           $getAttendanceHtml .= "</td>";

                            
                                                
                        $getAttendanceHtml .= "</tr>";

                        echo $getAttendanceHtml;
                        
                    $i++;
                }
            
            } else {    

                $getAttendanceHtml = 
                "<tr class='odd'><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";

                echo $getAttendanceHtml;
                
            }

        }
    }

   /**
     *  get userData By userId and using angular
     *
     * @param  $userIds INT
     * @return userId blude file    
     * @author <satishchauhan041@gmail.com>
     */
    public function getAngularUserDataByID($userIds = null)
    {   
        $userId = base64_decode($userIds);
        if (!empty($userId)) {
            $purhaseModel = new UserModel();
            $getUserDataByID = $purhaseModel->getAngularUserDataByID($userId);
        }

        return view('admin.editUser', [
            'getUserDataByID' => $getUserDataByID, 
        ]);
    }
    
    
    




}