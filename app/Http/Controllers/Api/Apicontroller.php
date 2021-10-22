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
use App\Model\SubCategory;
Use App\User;
use App\Model\AppLogin;
use App\Model\Role;
use App\Model\Workout;
use App\Model\UserFavouriteWorkout;
use App\Model\Program;
use App\Model\SubProgram;
use App\Model\ShopifyUser;
use App\Model\UserViewWorkout;
use App\Model\UserRecordHistory;
use App\Model\Nutrition;
use App\Model\ProgramWeekDescription;
use App\Model\Exercises;
use App\Model\ExercisesLike;
use App\Mail\ForgetPassword;
use Session;
use URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\SignupMail;

class Apicontroller extends Controller
{
    //
    public function createUser(Request $request)
    {

       $validator = Validator::make ($request->all (),['first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required',  'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $lastName=!empty($request->last_name)?$request->last_name:"";
        $email=$request->email;
        $password= Hash::make($request->password);
        $mobile_number=!empty($request->mobile_number)?$request->mobile_number:"";
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

            $checkShopifyUser=ShopifyUser::where(['email'=>$email])->first();


           if($type==config('constant.user_roles.user') )
           {
                if(!empty($checkShopifyUser))
                {
                  User::where('id',$userId)->update(['is_shopify_user'=>1]);
                  AppLogin::create(['user_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);
                   $data=array('mail'=>$email,'name'=>$firstName,'status'=>'1');

                 Mail::to($email)->send(new SignupMail($data));
                   $response=[
                      'status'=>true,
                      'message'=>"User Signup Successfully.",
                      'data'=>$this->getUserProfile($userDetails),
                      'session_id'=> $session_key,
                      'is_shopify_user'=>true
               
                   ];
                }
                else
                {
                   $data=array('mail'=>$email,'name'=>$firstName,'status'=>'0');

                      Mail::to($email)->send(new SignupMail($data));
                   $response=[
                      'status'=>false,
                      'message'=>"Thanks for signing up. Admin will review your account and will confirm to your registered email.",
                      'data'=>$this->getUserProfile($userDetails),
                      'session_id'=> $session_key,
                      'is_shopify_user'=>false
               
                   ];
                }                              
           }
           else
           {

                AppLogin::create(['owner_id'=>$userId,'session_id'=>$session_key,'device_type'=>$device_type,'device_token'=>$device_token]);
                $data=array('mail'=>$email,'name'=>$firstName,'status'=>'0');

                 Mail::to($email)->send(new ApprovedMail($data));

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
        $checkUserEmail=User::where(['email'=>$request->email])->whereHas('roles', function($q){
                $q->where('name', 'User');
        })->first();
        if(empty($checkUserEmail))
        {
          $response=[
                    'status'=>false,
                    'message'=>"email/password  is incorrect.",
                    'data'=>""
             
                 ];
                 $status_code=200;

             return response()->json($response,$status_code , $headers=[ ],

                 $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

                  
        }
        

        $device_token=$request->device_token;
        $device_type=$request->device_type;
        $type=$request->type;      
        $hashedPassword=$checkUserEmail->password;
        $id=$checkUserEmail->id;
       
            if(Hash::check($password, $hashedPassword))
             {
                    $userDetails=User::where('id',$id)->first();

                    $userId=$userDetails->id;

                    $session_key=Str::random(32);
                    if($userDetails->is_active==0)
                            {
                              $response=[
                                    'status'=>false,
                                    'message'=>"Your Account is Disabled, Please contact with Admin.",
                                    
                             
                                 ];
                            }
                            elseif ($userDetails->is_shopify_user==0) {
                              $response=[
                                    'status'=>false,
                                    'message'=>"You account is not yet approved. Please try again after approval.",
                                      
                                 ];
                            }
                            elseif ($userDetails->is_shopify_user==2) {
                              $response=[
                                    'status'=>false,
                                    'message'=>"You account is rejected by admin. Please contact with admin.",
                                      
                                 ];
                            }
                            else
                            {

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
                           if($type==config('constant.user_roles.trainer'))
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
      $categoryList=Category::select('category.id','category_name','category_desc',DB::raw("CONCAT('".asset('')."','category/',category_image) AS category_image"))->get();
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

     public function subCategoryList(Request $request)
    {
      $subCategoryList=SubCategory::where(['category_id'=>1])->select('subcategory.id','subcategory_name','subcategory_desc')->get();
      if(count($subCategoryList)>0)
      {
        $response=[
          'status'=>true,
          'message'=>"subcategory list.",
          'subcategorylist'=>$subCategoryList
        ];
      }
      else
      {
        $response=[
          'status'=>false,
          'message'=>"No record Found.",
          'subcategorylist'=>""
        ];
      }
      $status_code=200;

      return response()->json($response,$status_code , $headers=[ ],

          $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

    }

    public function trainerList(Request $request)
    {
        $trainerList=User::where(['is_active'=>1])->leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name',DB::raw("CONCAT('".asset('')."','user/',profile_image) AS user_image"),'users.email','user_desc','address')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->orderby('users.first_name','asc')->get();
        if(count($trainerList)>0)
        {
          $response=[
            'status'=>true,
            'message'=>"Trainer list.",
            'trainerlist'=>$trainerList
          ];
        }
        else
        {
          $response=[
            'status'=>true,
            'message'=>"No record Found.",
            'trainerlist'=>""
          ];
        }
        $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

    }

    public function workoutList(Request $request)
    {
         $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'trainer_id'=>'required'
            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $trainerId=$request->trainer_id;
          $subcategoryId=$request->subcategory_id;
          if(!empty( $subcategoryId))
          {
             $workOutDetails=Workout::where(['user_id'=>$trainerId,'subcategory_id'=>$subcategoryId,'workout_status'=>1])->select('workouts.id','workout_name','workout_equipments',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','workout_desc','video_url')->orderby('workouts.position','asc')->get();
          }
          else
          {
             $workOutDetails=Workout::where(['user_id'=>$trainerId,'workout_status'=>1])->select('workouts.id','workout_name','workout_equipments',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','workout_desc','video_url')->orderby('workouts.position','asc')->get();
          }
         
          if(count($workOutDetails)>0)
          {
            foreach($workOutDetails as $Details)
            {
              $workoutId=$Details->id;
              $Details->is_favourite=$this->checkFavouriteWorkout($userId,$workoutId);
              $Details->is_view=$this->checkWorkoutDone($userId,$workoutId);
            }
            
                  $response=[
              'status'=>true,
              'message'=>"workout list.",
              'workOutDetails'=>$workOutDetails
            ];
          }
          else
          {
            $response=[
              'status'=>true,
          'message'=>"No record Found.",
              'workOutDetails'=>$workOutDetails
            ];
          }
             $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }

    }

    public function workoutListBySubCategory(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $trainerId=$request->trainer_id;
          $subcategoryId=$request->subcategory_id;
          if(!empty($subcategoryId))
          {
            $workOutDetails=Workout::leftjoin('users','users.id','workouts.user_id')->leftjoin('subcategory','subcategory.id','workouts.subcategory_id')->where(['workouts.subcategory_id'=>$subcategoryId,'users.is_active'=>1,'workout_status'=>1])->select('workouts.id','subcategory.subcategory_name','users.first_name as TrainerName','workout_name','workout_equipments','workout_desc',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','video_url')->get();
          }
          else
          {
            $workOutDetails=Workout::leftjoin('users','users.id','workouts.user_id')->leftjoin('subcategory','subcategory.id','workouts.subcategory_id')->where(['users.is_active'=>1])->select('workouts.id','subcategory.subcategory_name','users.first_name as TrainerName','workout_name','workout_equipments','workout_desc',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time')->get();
          }
          
          if(count($workOutDetails)>0)
          {
            foreach($workOutDetails as $Details)
            {
              $workoutId=$Details->id;
              $Details->is_favourite=$this->checkFavouriteWorkout($userId,$workoutId);
              $Details->is_view=$this->checkWorkoutDone($userId,$workoutId);

            }
            
                  $response=[
              'status'=>true,
              'message'=>"workout list.",
              'workOutDetails'=>$workOutDetails
            ];
          }
          else
          {
            $response=[
              'status'=>true,
          'message'=>"No record Found.",
              'workOutDetails'=>$workOutDetails
            ];
          }
             $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }

    public function programList(Request $request)
    {
      
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required'

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $programDetails=Program::leftjoin('users','users.id','program.user_id')->leftjoin('category','category.id','program.category_id')->where(['users.is_active'=>1,'program.program_status'=>1])->select('program.id','category.category_name','users.first_name as TrainerName','program_name','program_desc',DB::raw("CONCAT('".asset('')."','programimage/',program_image) AS program_image"),DB::raw("CONCAT('".asset('')."','programintro/',program_intro) AS program_intro"),'program.number_of_weeks','program_time','program.program_level','program.user_id','nutrition_id','program_status')->get();
          if(count($programDetails)>0)
          {
            foreach($programDetails as $details)
            {
              $userDetails=User::leftjoin('user_details','users.id','user_details.user_id')->where(['users.id'=>$details->user_id])->select('users.id','users.first_name as name',DB::raw("CONCAT('".asset('')."','user/',profile_image) AS user_image"),'user_details.address','user_details.user_desc')->first();
              $nutritionId=$details->nutrition_id;

              $nutritionArray=explode(',',$nutritionId);
              $nutritionDetails=Nutrition::whereIn('id',$nutritionArray)->select('nutrition_title',DB::raw("CONCAT('".asset('')."','nutrition/',nutrition_image) AS nutrition_image"),DB::raw("CONCAT('".asset('')."','nutritionvideo/',nutrition_video) AS nutrition_url"),'nutrition_desc','id')->get();
              $weekDetails=ProgramWeekDescription::where(['program_id'=>$details->id])->get();
              $details->trainer_details=$userDetails;
              $details->nutrition_plans=$nutritionDetails;
              $details->week_description=$weekDetails;

            }
            
                  $response=[
              'status'=>true,
              'message'=>"program list.",
              'programDetails'=>$programDetails
            ];
          }
          else
          {
            $response=[
              'status'=>true,
          'message'=>"No record Found.",
              'programDetails'=>$programDetails
            ];
          }
             $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);


        }
    }

    public function programListByTrainer(Request $request)
    {
      
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'trainer_id'=>'required'

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $trainerId=$request->trainer_id;
          $programDetails=Program::leftjoin('users','users.id','program.user_id')->leftjoin('category','category.id','program.category_id')->where(['program.user_id'=>$trainerId,'program_status'=>1])->select('program.id','category.category_name','users.first_name as TrainerName','program_name','program_desc',DB::raw("CONCAT('".asset('')."','programimage/',program_image) AS program_image"),'program.number_of_weeks','program_time','program.program_level','nutrition_id')->get();
          if(count($programDetails)>0)
          {
             foreach($programDetails as $details)
            {
              
              $nutritionId=$details->nutrition_id;

              $nutritionArray=explode(',',$nutritionId);
              $nutritionDetails=Nutrition::whereIn('id',$nutritionArray)->select('nutrition_title',DB::raw("CONCAT('".asset('')."','nutrition/',nutrition_image) AS nutrition_image"),'nutrition_desc','id')->get();
               $weekDetails=ProgramWeekDescription::where(['program_id'=>$details->id])->get();
              // $details->trainer_details=$userDetails;
              $details->nutrition_plans=$nutritionDetails;
              $details->week_description=$weekDetails;

            }
            
                  $response=[
              'status'=>true,
              'message'=>"program list.",
              'programDetails'=>$programDetails
            ];
          }
          else
          {
            $response=[
              'status'=>true,
          'message'=>"No record Found.",
              'programDetails'=>$programDetails
            ];
          }
             $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);


        }
    }

    public function programDetails(Request $request)
    {
       $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'program_id' => 'required',

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $programId=$request->program_id;
          $week=$request->week;
          $subProgramDetails=SubProgram::where(['program_id'=>$programId,'week'=>$week])->get();
          $viewCount=0;
          $runingWorkoutPosition=0;
          if(count($subProgramDetails)>0)
          {
            $weekDetails=$weekDetails=ProgramWeekDescription::where(['program_id'=>$programId,'week'=>$week])->first();
            foreach($subProgramDetails as $details)
            {
              
              $subprogramworkouts=$details->subprogram_workouts;
              $workoutsArray=explode(',',$subprogramworkouts);
              $workoutDetails=Workout::whereIn('id',$workoutsArray)->where(['workout_status'=>1])->select('*',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"))->get();
              if(count($workoutDetails)>0)
              {         
                foreach($workoutDetails as $det)
                {
                  $workoutId=$det->id;
                  $det->is_favourite=$this->checkFavouriteWorkout($userId,$workoutId);
                  $det->is_view=$this->checkWorkoutDone($userId,$workoutId);
                  if(!empty($det->is_view))
                  {
                    $viewCount++;
                  }
                  if(empty($runingWorkoutPosition) && empty($det->is_view))
                  {
                    $runingWorkoutPosition=$viewCount;
                  }
                }
              }
              $details->workouts=$workoutDetails;
            }
             $response=[
                   'status'=>true,
                   'message'=>"Program Details. ",
                   'data'=>$subProgramDetails,
                   'workout_view_count'=>$viewCount,
                   'runing_workout_position'=>$runingWorkoutPosition,
                   'week_details'=>$weekDetails
                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
          }
          else
          {
             $response=[
                   'status'=>false,
                   'message'=>"No Record Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            
          }




        }
    }

    public function addWorkoutRecord(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'program_id' => 'required',

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $programId=$request->program_id;
          $subProgramDetails=SubProgram::where(['program_id'=>$programId])->get();

          if(count($subProgramDetails)>0)
          {
            
            foreach($subProgramDetails as $details)
            {
              
              $subprogramworkouts=$details->subprogram_workouts;
              $workoutsArray=explode(',',$subprogramworkouts);
              $week=$details->week;
              $workoutDetails=Workout::whereIn('id',$workoutsArray)->where(['workout_status'=>1])->select('*',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"))->get();
              if(count($workoutDetails)>0)
              {
                
                foreach($workoutDetails as $det)
                {
                  $workoutId=$det->id;
                  $checkWorkout=$this->checkWorkoutDone($userId,$workoutId);
                  $det->is_view=$checkWorkout;
                  $isSeen=1;
                  $isComplete=1;
                  if(!empty($checkWorkout))
                  {
                     $userRecord=UserRecordHistory::where(['customer_id'=>$userId,'program_id'=>$programId,'week'=>$week,'workout_id'=>$workoutId])->first();
                     if(empty($userRecord))
                     {
                        UserRecordHistory::create(['customer_id'=>$userId,'program_id'=>$programId,'week'=>$week,'workout_id'=>$workoutId,'is_seen'=>$isSeen,'is_complete'=>$isComplete]);
                     }
                  }

                }
              }
              $details->workouts=$workoutDetails;
            }
             $response=[
                   'status'=>true,
                   'message'=>"User record is updated. ",
                   //'data'=>$subProgramDetails

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
          }
          else
          {
             $response=[
                   'status'=>false,
                   'message'=>"No Record Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            
          }




        }
    }

    public function addProgramRecord(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'program_id' => 'required',
            'week' => 'required',
            'workout_id'=>'required'

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $programId=$request->program_id;
          $week=$request->week;
          $workoutId=$request->workout_id;
          $isSeen=1;
          $isComplete=0;
          $currentDate=date('Y-m-d');
          $userRecord=UserRecordHistory::where(['customer_id'=>$userId,'program_id'=>$programId,'week'=>$week,'workout_id'=>$workoutId])->first();
          $checkWorkout=UserViewWorkout::where(['user_id'=>$userId,'workout_id'=>$workoutId])->first();
          if(empty($userRecord))
          {
            UserRecordHistory::create(['customer_id'=>$userId,'program_id'=>$programId,'week'=>$week,'workout_id'=>$workoutId,'is_seen'=>$isSeen,'is_complete'=>$isComplete]);
          }
          if(empty($checkWorkout))
          {
            UserViewWorkout::create(['user_id'=>$userId,'workout_id'=>$workoutId]);
          }

           $response=[
                   'status'=>true,
                   'message'=>"Record is addded to user account. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
      
    }

    public function profileUpdate(Request $request)
    {
         $validator = Validator::make ($request->all (),[
            'session_id' => 'required'

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $userDetails=User::where(['id'=>$userId])->first();

          $name=!empty($request->name)?$request->name:$userDetails->first_name;
          $email=!empty($request->email)?$request->email:$userDetails->email;
          $image=$userDetails->profile_image;
          $password=$userDetails->password;
              if(!empty($request->file('image')))
            {
                $file=$request->file('image');
                ///$path='/'.$categoryId;
                 $image ="user".rand(10,100).$request->file('image')->getClientOriginalName();
                // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
                $file->move(public_path().'/user/',$image);
            }
            if(!empty($request->password))
            {
                $password=Hash::make($request->password);

            }

            User::where(['id'=>$userId])->update(['first_name'=>$name,'email'=>$email,'profile_image'=>$image,'password'=>$password]);

            $updateUserDetails= User::where(['id'=>$userId])->first();


            $response=[
              'status'=>true,
              'message'=>"profile updated Successfully.",
              'data'=>$this->getUserProfile($updateUserDetails),
             
            ];
            $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }

    }

    public function addFavouriteWorkout(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'workout_id'=>'required',

            ]);

             if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();
         if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $workoutId=$request->workout_id;
          $checkWorkout=UserFavouriteWorkout::where(['user_id'=>$userId,'workout_id'=>$workoutId])->first();
          if(!empty($checkWorkout))
          {
            UserFavouriteWorkout::where(['user_id'=>$userId,'workout_id'=>$workoutId])->delete();
            $msg="Removed From Favorite";
          }
          else
          {
            UserFavouriteWorkout::create(['user_id'=>$userId,'workout_id'=>$workoutId]);
             $msg="Added To Favorite";
          }

          $response=[
              'status'=>true,
              'message'=>$msg,
              
             
            ];
            $status_code=200;

        return response()->json($response,$status_code , $headers=[ ],

            $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }

    public function favouriteWorkoutList(Request $request)
    {
      
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $favouriteWorkoutList= UserFavouriteWorkout::leftjoin('workouts','workouts.id','user_favourite_workouts.workout_id')->leftjoin('users','users.id','workouts.user_id')->leftjoin('subcategory','subcategory.id','workouts.subcategory_id')->where(['user_favourite_workouts.user_id'=>$userId])->select('user_favourite_workouts.id','user_favourite_workouts.workout_id','subcategory.subcategory_name','users.first_name as trainer_name','workout_name','workout_equipments','workout_desc',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','video_url')->get();

          if(count($favouriteWorkoutList)>0)
          {
            foreach($favouriteWorkoutList as $Details)
            {
              $workoutId=$Details->workout_id;
              $Details->is_favourite=$this->checkFavouriteWorkout($userId,$workoutId);
              $Details->is_view=$this->checkWorkoutDone($userId,$workoutId);
            }
             $response=[
              'status'=>true,
              'message'=>"Favourite workout list.",
              'workOutDetails'=>$favouriteWorkoutList
            ];
          }
          else
          {
            $response=[
              'status'=>true,
              'message'=>"No Record Found.",
              
            ];
          }
            $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }

    public function forgetPassword(Request $request)
    {

      $validator = Validator::make ($request->all (),[
            'email' => 'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }
       $email= $request->email;
       $userDetails=User::where(['email'=>$email])->first();
       if(empty($userDetails))
       {
          $response=[
              'status'=>false,
              'message'=>"Invalid email.",
              
            ];
            $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);       
       }
       else
       {
        $randomNumber=mt_rand(0000,9999);
        $useremail=$email;
          User::where(['email'=>$email])->update(['remember_token'=>$randomNumber]);
          $data=array('token'=>$randomNumber);

        Mail::to($useremail)->send(new ForgetPassword($data));
          $response=[
              'status'=>true,
              'message'=>"Reset code is send to your register  mail.",
              
            ];
            $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);   


       }
    }

    public function resetPassword(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'token' => 'required',
            'password'=>'required'
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }
       $token= $request->token;
       $userDetails=User::where(['remember_token'=>$token])->first();
       $password= Hash::make($request->password);
       if(empty($userDetails))
       {
          $response=[
              'status'=>false,
              'message'=>"Invalid token.",
              
            ];
            $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);       
       }
       else
       {
        $updatePassword=User::where(['id'=>$userDetails->id])->update(['password'=>$password,'remember_token'=>null]);


             $response=[
              'status'=>true,
              'message'=>"password is reset successfully..",
              
            ];
            $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
      }
    }

    public function progressReport(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'program_id'=>'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }
        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $programId=$request->program_id;
          $weeks=DB::table('user_records_history')->where(['customer_id'=>$userId,'program_id'=>$programId])->distinct('week')->get(['week']);
         
          $programDetails=Program::leftjoin('users','users.id','program.user_id')->where(['program.id'=>$programId])->first();
          $totalweeks=$programDetails->number_of_weeks;
          $completedweeks=0;
          $totalWorkoutCount=0;
          $exerciseDone=0;
          $trainerName=$programDetails->first_name;
          if($totalweeks>0)
          {
            for( $i=1;$i<=$totalweeks;$i++)
            {
              $weekId=$i;

              $subprograDetails=SubProgram::where(['program_id'=>$programId,'week'=>$weekId])->first();
              if(!empty($subprograDetails))
              {
                    $workoutcount=count(explode(',',$subprograDetails->subprogram_workouts));
                   //echo $workoutcount;
                  
                  $totalWorkoutCount=$totalWorkoutCount+$workoutcount;
                  $userWorkout=DB::table('user_records_history')->where(['customer_id'=>$userId,'program_id'=>$programId,'week'=>$weekId])->count();
                  $exerciseDone=$exerciseDone+$userWorkout;
                  if($workoutcount==$userWorkout)
                  {
                    $completedweeks=$completedweeks+1;
                   
                  }
              }
              

            }
              //die();
            $percentage=round((($exerciseDone/$totalWorkoutCount)* 100),2);

            $response=[
                   'status'=>true,
                   'message'=>"Progress Report. ",
                   'totalweeks'=>$totalweeks,
                   'completedweeks'=>$completedweeks,
                   'totalworkoutcount'=>$totalWorkoutCount,
                   'totalworkoutdone'=>$exerciseDone,
                   'percentage'=>$percentage,
                   'trainer_name'=>$trainerName

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
          }
          else
          {

            $subProgramDetails=SubProgram::where(['program_id'=>$programId])->get();
            if(count($subProgramDetails))
            {
              foreach($subProgramDetails as $details)
              {

                  $workoutcount=count(explode(',',$details->subprogram_workouts));
                 //echo $workoutcount;
                
                $totalWorkoutCount=$totalWorkoutCount+$workoutcount;
              }
            }
            $response=[
            'status'=>true,
                   'message'=>"Progress Report. ",
                   'totalweeks'=>$totalweeks,
                   'completedweeks'=>$completedweeks,
                   'totalworkoutcount'=>$totalWorkoutCount,
                   'totalworkoutdone'=>$exerciseDone,
                   'percentage'=>0,
                   'trainer_name'=>$trainerName];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
          }
          

          UserRecordHistory::where(['customer_id'=>$userId,'program_id'=>$program_id])->get();

        }
    }


    public function addShopifyUser(Request $request)
    {
       $data=$request->data;
       if(count($data)>0)
       {
          foreach($data as $details)
          {
            $checkEmailExist=ShopifyUser::where(['email'=>$details])->first();
            if(empty($checkEmailExist))
            {
              ShopifyUser::create(['email'=>$details]);
            }
          }
          $response=[
            'status'=>true,
                   'message'=>"Data Processed Successfully. ",
                   ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
       }
       else
       {
          $response=[
                   'status'=>false,
                   'message'=>"Invalid data. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
       }


    }

    public function exercisesList(Request $request)
    {
       $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'workout_id' => 'required'
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $workoutId=$request->workout_id;

          $workOutDetails=Workout::where(['id'=>$workoutId])->select('workouts.id','workout_name','workout_equipments',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','workout_desc','video_url','user_id')->first();
          $userDetails=User::where(['id'=>$workOutDetails->user_id])->first();
          $trainerName=$userDetails->first_name;

          $exercisesList=Exercises::where(['workout_id'=>$workoutId])->get();
          if(count($exercisesList)>0)
          {
            foreach ($exercisesList as $list) {
              $exerciseId=$list->id;
              $list->is_favorite =$this->checkFavouriteExercise($userId,$exerciseId);
              }      
          }
          
          $response=[
            'status'=>true,
                   'message'=>"Exercise List ",
                   'data' => $exercisesList,
                   'trainer_name'=>$trainerName,
                   'workout_details'=>$workOutDetails
                   ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }

    public function exercisesAddToLike(Request $request)
    {
       $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            'workout_id' => 'required',
            'exercise_id'=> 'required'
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $workoutId=$request->workout_id;
          $exerciseId=$request->exercise_id;

          $checkExercise=ExercisesLike::where(['workout_id'=>$workoutId,'user_id'=>$userId,'exercise_id'=>$exerciseId])->first();
          if(empty($checkExercise))
          {
            ExercisesLike::create(['workout_id'=>$workoutId,'user_id'=>$userId,'exercise_id'=>$exerciseId]);
            $message=" Exercise  saved successfully.";
          }
          else
          {
            ExercisesLike::where(['workout_id'=>$workoutId,'user_id'=>$userId,'exercise_id'=>$exerciseId])->delete();
            $message=" Exercise Removed successfully.";
          }

          $response=[
            'status'=>true,
                   'message'=>$message,
                   ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }

    public function exercisesLikeList(Request $request)
    {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $exerciseDetails=ExercisesLike::leftjoin('exercises','exercises.id','exercise_id')->select('exercises.id','exercises.workout_id','exercises.exercise_name','exercise_desc','exercise_video','exercise_duration',DB::raw("1 as is_favorite"))->get();
         
          // $workOutDetails=Workout::where(['id'=>$workoutId])->select('workouts.id','workout_name',DB::raw("CONCAT('".asset('')."','workoutimage/',workout_image) AS workout_image"),DB::raw("CONCAT('".asset('')."','workoutvideo/',workout_url) AS workout_url"),'workout_time','workout_desc','video_url','user_id')->first();
          // $userDetails=User::where(['id'=>$workOutDetails->user_id])->first();
          // $trainerName=$userDetails->first_name;
          
          
          $response=[
            'status'=>true,
                   'message'=>"Exercise  List ",
                   'data' => $exerciseDetails,
                   
                   ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }


    }
    public function viewWorkout(Request $request)
    {

        $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          $userId=$appLoginDetails->user_id;
          $workoutId=$request->workout_id;

          $checkWorkout=UserViewWorkout::where(['workout_id'=>$workoutId,'user_id'=>$userId])->first();
          if(empty($checkWorkout))
          {
            UserViewWorkout::create(['workout_id'=>$workoutId,'user_id'=>$userId]);
          }

          $response=[
            'status'=>true,
                   'message'=>"Workout View Successfully. ",
                   ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        }
    }


      public function logout(Request $request) 
  {
      $validator = Validator::make ($request->all (),[
            'session_id' => 'required',
            ]);

        if ($validator->fails ()) 
        {                        
            return response ()->json (['status' => false,

                'message' =>$validator->getMessageBag ()

                ->first () ],200);
        }

        $appLoginDetails=AppLogin::where('session_id',$request->session_id)->first();

        if(empty($appLoginDetails))
        {
          $response=[
                   'status'=>false,
                   'message'=>"Session Not Found. "

                ];
                $status_code=200;
                return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
        else
        {
          AppLogin::where('session_id',$request->session_id)->delete();
           $response=[
                   'status'=>true,
                   'message'=>"Logout Successfully.",
                   
                ];

                $status_code=200;
               return response()->json($response,$status_code , $headers=[ ],

                        $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE); 


        }

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
            'name'=>$user['first_name'],
            'email'=>$user['email'],
            'phone'=>$user['mobile_number'],
            'image'=>$profile_image
            

        ];  
    }

    public function checkFavouriteWorkout($userId,$workoutId)
    {
      $value=0;
      $checkWorkout=UserFavouriteWorkout::where(['user_id'=>$userId,'workout_id'=>$workoutId])->first();
      if(!empty($checkWorkout))
      {
        $value=1;
      }
      return $value;
    }
     public function checkFavouriteExercise($userId,$exerciseId)
    {
      $value=0;
      $checkExercise=ExercisesLike::where(['user_id'=>$userId,'exercise_id'=>$exerciseId])->first();
      if(!empty($checkExercise))
      {
        $value=1;
      }
      return $value;
    }

    public function checkWorkoutDone($userId,$workoutId)
    {
      $value=0;
      $checkWorkout=UserViewWorkout::where(['user_id'=>$userId,'workout_id'=>$workoutId])->first();
      if(!empty($checkWorkout))
      {
        $value=1;
      }
      return $value;
    }
}
