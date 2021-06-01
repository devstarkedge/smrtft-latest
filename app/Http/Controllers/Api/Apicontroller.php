<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
Use App\Model\Category;
Use App\User;
use App\Model\AppLogin;
use App\Model\Role;
use Session;
use URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class Apicontroller extends Controller
{
    //
    public function createUser(Request $request)
    {

       $validator = Validator::make ($request->all (),['first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required',  'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile_number' => ['required', 'string', 'max:10', 'unique:users'],
            'device_token'=>['required','string'],
            'type'=>['required','string']
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $firstName=$request->first_name;
        $lastName=$request->last_name;
        $email=$request->email;
        $password= Hash::make($request->password);
        $mobile_number=$request->mobile_number;
        $device_token=$request->device_token;
        $device_type=$request->device_type;
        $type=$request->type;

        $user =new User();
        $user->first_name=$firstName;
        $user->email=$email;
        $user->last_name=$lastName;
        $user->password=$password;
        $user->mobile_number=$mobile_number;
         if ($user->save()) {

            if($type==config('constant.user_roles.user'))
            {
                 $roleUser = DB::table('roles')->where('name', config('constant.user_roles.user'))->first();
            }
            else
            {
                 $roleUser = DB::table('roles')->where('name', config('constant.user_roles.trainer'))->first();
            }
           
            $user->roles()->attach($roleUser->id);

            $userDetails=User::where('id',$user->id)->first();

            $userId=$userDetails->id;

           $session_key=Str::random(32);
           if($type==config('constant.user_roles.user'))
           {
            AppLogin::create(['user_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);



             $response=[
            'status'=>true,
            'message'=>"User Signup Successfully.",
            'data'=>$this->getUserProfile($userDetails),
            'session_id'=> $session_key
     
         ];
           }
           else
           {

                AppLogin::create(['owner_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);



             $response=[
            'status'=>true,
            'message'=>"Owner Signup Successfully.",
            'data'=>$this->getUserProfile($userDetails),
            'session_id'=> $session_key
     
         ];
           }

            
          $status_code=200;

             return response()->json($response,$status_code , $headers=[ ],

                 $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

         }

    }


    public function userLogin(Request $request)
    {
         $validator = Validator::make ($request->all (),[ 'email' => ['required'],
            'password' => ['required'],
             'device_token' => ['required'],
             'type'=>['required','string']
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        
        $password=$request->password;
        $checkUserEmail=User::where(['email'=>$request->email])->first();
        $checkUserPhone=User::where(['mobile_number'=>$request->email])->first();

        $device_token=$request->device_token;
        $device_type=$request->device_type;
        $type=$request->type;

        if(!empty($checkUserEmail))
        {
          $hashedPassword=$checkUserEmail->password;
          $id=$checkUserEmail->id;
        }
        if(!empty($checkUserPhone))
        {
          $hashedPassword=$checkUserPhone->password;
          $id=$checkUserPhone->id;
        }
        

            if(Hash::check($password, $hashedPassword))
             {
                    $userDetails=User::where('id',$id)->first();

                    $userId=$userDetails->id;

                    $session_key=Str::random(32);

                     if($type==config('constant.user_roles.user'))
                           {
                            AppLogin::create(['user_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);
                                     $response=[
                                    'status'=>true,
                                    'message'=>"User Login Successfully.",
                                    'data'=>$this->getUserProfile($userDetails),
                                    'session_id'=> $session_key
                             
                                 ];
                           }
                           if($type==config('constant.user_roles.owner'))
                           {
                            AppLogin::create(['owner_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);
                                     $response=[
                                    'status'=>true,
                                    'message'=>"Owner Login Successfully.",
                                    'data'=>$this->getUserProfile($userDetails),
                                    'session_id'=> $session_key
                             
                                 ];
                           }


                    
              }
              else
              {
                        $response=[
                    'status'=>false,
                    'message'=>"email/password  is incorrect.",
                    'data'=>""
             
                 ];
              }
       
         
          $status_code=200;

             return response()->json($response,$status_code , $headers=[ ],

                 $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);


    }

    public function categoryList(Request $request)
    {
      $categoryList=Category::select('category.id','category_name','category_desc',DB::raw("CONCAT('".URL::to('/')."','/category/',category_image) AS category_image"))->get();
      if(count($categoryList)>0)
      {
        $response=[
          'status'=>true,
          'message'=>"category list.",
          'categorylist'=>$categoryList
        ];
      }
      else
      {
        $response=[
          'status'=>false,
          'message'=>"No record Found.",
          'categorylist'=>""
        ];
      }
      $status_code=200;

      return response()->json($response,$status_code , $headers=[ ],

          $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

    }

    public function getUserProfile($user)
    {
      $image='default.jpg';
      if(!empty($user['profile_image']))
      {
        $image=$user['profile_image'];
      }
      $profile_image=url('user/'.$image);

        return[
            'name'=>$user['name'],
            'email'=>$user['email'],
            'phone'=>$user['mobile_number'],
            'image'=>$profile_image
            

        ];  
    }
}
