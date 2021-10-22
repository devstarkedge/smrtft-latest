<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\Role;
use App\Model\UserDetails;
use App\Model\Workout;
use App\Model\Scholarship;
use App\Model\UserScholarship;
use App\Model\Program;
use App\Model\SubProgram;
use App\Model\Nutrition;
use App\Model\Exercises;
use App\Model\ProgramWeekDescription;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCredentailsToUser;
use App\Mail\ApprovedMail;
use DB;


class AdminController extends Controller
{

    public function index(Request $request) {

        $categoryDetails=Category::get();
        return view('admin.dashboard',compact('categoryDetails'));
    }

    public function createCategory(Request $request)
    {

        return view('admin.createCategory');
    }

    public function saveCreateCategory(Request $request)
    {
        $categoryName=$request->categoryname;
        $categoryDesc=$request->categorydesc;

        $file=$request->file('categoryimage');
           ///$path='/'.$categoryId;
            $fileName ="Cat".rand(10,100).$request->file('categoryimage')->getClientOriginalName();
        // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
        $file->move(public_path().'/category/',$fileName);
        Category::create(['category_name'=>$categoryName,'category_desc'=>$categoryDesc,'category_image'=>$fileName]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Category Added Successfully.');
        return redirect()->route('admin.dashboard');
    }

    public function subCategoryList(Request $request)
    {
        $subcategoryDetails=SubCategory::get();
        return view('admin.subcategoryList',compact('subcategoryDetails'));
    }
    public function createSubCategory(Request $request)
    {
        $categoryDetails=Category::where('id','>',0)->first();
        return view('admin.createSubCategory',compact('categoryDetails'));
    }

    public function saveSubCreateCategory(Request $request)
    {
        $categoryId=$request->category;
        $subCategoryName=$request->subcategoryname;
        $subCategoryDesc=$request->subcategorydesc;
        $fileName ="default.jpg";
        if(!empty($request->file('subcategoryimage')))
        {
            $file=$request->file('subcategoryimage');
            ///$path='/'.$categoryId;
             $fileName ="SubCat".rand(10,100).$request->file('subcategoryimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/subcategory/',$fileName);
        }
       
        SubCategory::create(['category_id'=>$categoryId,'subcategory_name'=>$subCategoryName,'subcategory_desc'=>$subCategoryDesc,'subcategory_image'=>$fileName]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'subCategory Added Successfully.');
        return redirect()->route('admin.subcategory.list');
    }

    public function trainerList(Request $request)
    {
        //  $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->whereHas('roles', function($q){
        //         $q->where('name', 'Trainer');
        // })->get();
        
        $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','is_active')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->get();
        return view('admin.trainerlist',compact('trainerList'));
    }

    public function createTrainer(Request $request)
    {
        
        return view('admin.createTrainer');
    }

    public function saveTrainer(Request $request)
    {
        $name=$request->name;
        $email=$request->email;
        $description=$request->description;
        $address=$request->address;
        $fileName ="default.jpg";
        if(!empty($request->file('profileimage')))
        {
            $file=$request->file('profileimage');
            ///$path='/'.$categoryId;
             $fileName ="tran".rand(10,100).$request->file('profileimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/user/',$fileName);
        }
       
        $roleTrainer = Role::where('name', config('constant.user_roles.trainer'))->first();
        $trainer = new User();
        $trainer->first_name = 'trainer';  
        $trainer->email = $email;
        $trainer->password = Hash::make('Qwerty@123');
        $trainer->profile_image=$fileName;
        $trainer->save();
        $trainer->roles()->attach($roleTrainer->id);
        $trainerId=$trainer->id;

        $trainerDetails= new UserDetails();
        $trainerDetails->user_id=$trainerId;
        $trainerDetails->user_desc=$description;
        $trainerDetails->address=$address;
        $trainerDetails->save();

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Trainer Added Successfully.');
        return redirect()->route('admin.trainer.list');
    }


    public function editTrainer(Request $request,$id)
    {

        $trainerDetails=User::leftjoin('user_details','users.id','user_details.user_id')->where(['users.id'=>$id])->select('users.id','users.first_name','profile_image','users.email','user_desc','address','is_active')->first();
        return view('admin.editTrainer',compact('trainerDetails'));
    }

    public function deleteTrainer(Request $request,$id)
    {
        User::where(['id'=>$id])->update(['is_active'=>0]);
        User::where(['id'=>$id])->delete();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Trainer Deleted Successfully.');
        return redirect()->route('admin.trainer.list');

    }

        public function updateTrainer(Request $request,$id)
    {
        $trainerDetails=User::where(['id'=>$id])->first();

        $name=$request->name;
        $email=$request->email;
        $description=$request->description;
        $address=$request->address;
        $fileName =$trainerDetails->profile_image;
        $status=$request->status;
        if(!empty($request->file('profileimage')))
        {
            $file=$request->file('profileimage');
            ///$path='/'.$categoryId;
             $fileName ="tran".rand(10,100).$request->file('profileimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/user/',$fileName);
        }
       
        User::where(['id'=>$id])->update(['first_name'=>$name,'email'=>$email,'profile_image'=>$fileName,'is_active'=>$status]);

        UserDetails::where(['user_id'=>$id])->update(['address'=>$address,'user_desc'=>$description]);


        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Trainer Updated Successfully.');
        return redirect()->route('admin.trainer.list');
    }

    public function trainerWorkouts(Request $request,$id)
    {
         $trainerDetails=User::where(['id'=>$id])->first();
        $trainerName=$trainerDetails->first_name;
        $workoutList=Workout::leftjoin('users','users.id','workouts.user_id')->leftjoin('subcategory','subcategory.id','workouts.subcategory_id')->where(['workouts.user_id'=>$id])->select('workouts.id','subcategory.subcategory_name','users.first_name','workout_name','workout_desc','workout_image','workout_url','workout_time','workout_status','position')->orderBy('workouts.position','asc')->get();
        return view('admin.workoutList',compact('workoutList','trainerName'));
    }

    public function workoutList(Request $request )
    {
        
        $workoutList=Workout::leftjoin('users','users.id','workouts.user_id')->leftjoin('subcategory','subcategory.id','workouts.subcategory_id')->select('workouts.id','subcategory.subcategory_name','users.first_name','workout_name','workout_desc','workout_image','workout_url','workout_time','workout_status')->get();
        return view('admin.workoutList',compact('workoutList'));
    } 

    public function createWorkout(Request $request)
    {
        $categoryDetails=Category::first();
        $subcategoryDetails=SubCategory::get();
        $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','users.last_name')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->get();

        return view('admin.createWorkout',compact('categoryDetails','subcategoryDetails','trainerList'));
    }

    public function saveWorkout(Request $request)
    {
       $userId=$request->trainer;
        $subCategoryId=$request->subcategory;
        $workoutName=$request->workoutname;
        $address=$request->address;
        $workoutTime=$request->workouttime;
        $workoutDesc=$request->workoutdesc;
        $videoStaticUrl=$request->videourl;
        $fileName ="default.jpg";
        $videoUrl="";
        if(!empty($request->file('workoutimage')))
        {
            $file=$request->file('workoutimage');
            ///$path='/'.$categoryId;
             $fileName ="work".rand(10,100).$request->file('workoutimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/workoutimage/',$fileName);
        }
        // if(!empty($request->file('workoutvideo')))
        // {
        //     $file=$request->file('workoutvideo');
        //     ///$path='/'.$categoryId;
        //      $videoUrl ="workvideo".rand(10,100).$request->file('workoutvideo')->getClientOriginalName();
        //     // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
        //     $file->move(public_path().'/workoutvideo/',$fileName);
        // }
        if(count($subCategoryId)>0)
        {
            $position= Workout::max('position');

            foreach($subCategoryId as $det)
            {
                $position=$position+1;
                $workout = new Workout();
                $workout->user_id = $userId;  
                $workout->subcategory_id = $det;
                $workout->workout_name =$workoutName;
                $workout->workout_image=$fileName;
                $workout->workout_url=$videoUrl;
                $workout->video_url=$videoStaticUrl;
                $workout->workout_time=$workoutTime;
                $workout->workout_desc=$workoutDesc;
                $workout->position=$position;
                $workout->save();
            }

        }
      
        
        
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'WorkOut Added Successfully.');
        return redirect()->route('admin.trainer.workout.list',$userId); 

    }
         public function editWorkout(Request $request,$id)
    {
        $categoryDetails=Category::first();
        $subcategoryDetails=SubCategory::get();
        $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','users.last_name')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->get();
        $workoutDetails=Workout::leftjoin('users','users.id','workouts.user_id')->where(['workouts.id'=>$id])->select('workouts.id','users.first_name as trainer','workout_image','workout_name','users.email','workout_url','workout_desc','workouts.user_id','workouts.subcategory_id','workout_time','workout_status','video_url')->first();
        return view('admin.editWorkout',compact('workoutDetails','subcategoryDetails','categoryDetails','trainerList'));
    }

    public function updateWorkout(Request $request,$id)
    {
        $workoutDetails=Workout::where(['id'=>$id])->first();

        $userId=$request->trainer;
        $subCategoryId=$request->subcategory;
        $workoutName=$request->workoutname;
        $workoutTime=$request->workouttime;
        $workoutDesc=$request->workoutdesc;
        $fileName =$workoutDetails->workout_image;
        $videoUrl=$workoutDetails->workout_url;
        $videoStaticUrl=$request->videourl;
        $status=$request->status;
        if(!empty($request->file('workoutimage')))
        {
            $file=$request->file('workoutimage');
            ///$path='/'.$categoryId;
             $fileName ="work".rand(10,100).$request->file('workoutimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/workoutimage/',$fileName);
        }
        // if(!empty($request->file('workoutvideo')))
        // {
        //     $file=$request->file('workoutvideo');
        //     ///$path='/'.$categoryId;
        //      $videoUrl ="workvideo".rand(10,100).$request->file('workoutvideo')->getClientOriginalName();
        //     // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
        //     $file->move(public_path().'/workoutvideo/',$fileName);
        // }
         
        Workout::where(['id'=>$id])->update(['user_id'=>$userId,'subcategory_id'=>$subCategoryId,'workout_name'=>$workoutName,'workout_image'=>$fileName,'workout_url'=>$videoUrl,'workout_time'=>$workoutTime,'workout_desc'=>$workoutDesc,'workout_status'=>$status,'video_url'=>$videoStaticUrl]);
      
               

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'WorkOut Updated Successfully.');
        return redirect()->route('admin.trainer.workout.list',$userId); 
        
    }

    public function trainerWorkoutList(Request $request)
    {

        $trainerlist = DB::table('workouts')->leftjoin('users','users.id','workouts.user_id')->where('users.deleted_at','=',NULL)->select(DB::raw('DISTINCT user_id, COUNT(*) AS count_userid'),'users.first_name')->groupBy('user_id')->orderBy('count_userid', 'desc')->get();
        // print_r($trainerlist);
        // die();
        
        
        return view('admin.trainerWorkoutList',compact('trainerlist')); 
    }

     public function trainerProgramList(Request $request)
    {

        $trainerlist = DB::table('program')->leftjoin('users','users.id','program.user_id')->where('users.deleted_at','=',NULL)->select(DB::raw('DISTINCT user_id, COUNT(*) AS count_userid'),'users.first_name')->groupBy('user_id')->orderBy('count_userid', 'desc')->get();
        
   
        return view('admin.trainerProgramList',compact('trainerlist')); 
    }

    public function trainerPrograms(Request $request,$id)
    {
        $trainerDetails=User::where(['id'=>$id])->first();
        $trainerName=$trainerDetails->first_name;
       $programList=Program::leftjoin('users','users.id','program.user_id')->leftjoin('category','category.id','program.category_id')->where(['program.user_id'=>$id])->select('program.id','category.category_name','users.first_name','program_name','program_desc','program_image','number_of_weeks','program_time','program_status')->get();
        return view('admin.programList',compact('programList','trainerName'));
    }

    public function trainerProgramDetails(Request $request, $id)
    {
        $programDetails=Program::where(['id'=>$id])->first();
        $subProgramDetail=SubProgram::leftjoin('program','program.id','subprogram.program_id')->where(['program_id'=>$id])->select('subprogram.id','subprogram.program_id','program.program_name','subprogram.subprogram_name','subprogram_desc','subprogram_image','nutrition_image','nutrition_desc','subprogram.program_time','subprogram_workouts','week','program.user_id')->get();
        $trainerDetails=User::where(['id'=>$programDetails->user_id])->first();
        $trainerName=$trainerDetails->first_name;
        if(count($subProgramDetail)>0)
        {
        
        foreach($subProgramDetail as $details)
        {
          $data=explode(',',$details->subprogram_workouts);
          $count=count($data);
            $workoutList=Workout::whereIn('id',$data)->select('workout_name')->get();
            $workout_name="";
            if(count($workoutList)>0)
            {
                foreach($workoutList as $data)
                {
                    if(empty($workout_name))
                    {
                         $workout_name=$data->workout_name;
                    }
                    else
                    {
                        $workout_name.=",".$data->workout_name;
                    }
                   
                }
            }
            $details->workoutlist=$workout_name;
            $details->count= $count;
        }
        return view('admin.subprogramList',compact('subProgramDetail','id','trainerName'));
    }
    else
    {
       //  $request->session()->flash('message.level', 'success');
       //  $request->session()->flash('message.content', 'selected  Program does not have Details .');
       // return redirect()->back(); 
        return view('admin.subprogramList',compact('subProgramDetail','id','trainerName'));

    }
        

    }

    public function addProgramDetails(Request $request,$id)
    {
        $programDetails=Program::where(['id'=>$id])->first();
        $userId=$programDetails->user_id;
        $workoutDetails=Workout::where(['user_id'=>$userId])->get();
        return view('admin.addprogramDetails',compact('programDetails','workoutDetails','id'));
    }
    public function saveProgramDetails(Request $request,$id)
    {
        $userId=$request->userId;
        $week=$request->week;
        $subProgram=$request->subprogramname;
        $workoutslist=implode(",",$request->workouts);
        $programtime=$request->programtime;
        $subprogramDesc=$request->programdesc;
           $subprogram = new SubProgram();
           $subprogram->program_id=$id;
           $subprogram->subprogram_name=$subProgram;
           $subprogram->subprogram_desc=$subprogramDesc;
           $subprogram->subprogram_workouts=$workoutslist;
           $subprogram->program_time=$programtime;
           $subprogram->week=$week;
           $subprogram->save();
           $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Sub Program saved Successfully.');
        return redirect()->route('admin.trainer.program.details',$id); 

    }

    public function editProgramdetails(Request $request,$id)
    {
        $subProgramDetail=SubProgram::leftjoin('program','program.id','subprogram.program_id')->where(['subprogram.id'=>$id])->select('subprogram.id','subprogram.program_id','program.program_name','subprogram.subprogram_name','subprogram_desc','subprogram_image','nutrition_image','nutrition_desc','subprogram.program_time','subprogram_workouts','week')->first();

       $programDetails=Program::where(['id'=>$subProgramDetail->program_id])->first();
        $userId=$programDetails->user_id;
        $workoutDetails=Workout::where(['user_id'=>$userId])->get(); 
        return view('admin.editProgramDetails',compact('programDetails','workoutDetails','id','subProgramDetail'));
    }

    Public function updateProgramDetails(Request $request,$id)
    {
    	$programId=$request->programId;
    	$userId=$request->userId;
        $week=$request->week;
        $subProgram=$request->subprogramname;
        $workoutslist=implode(",",$request->workouts);
        $programtime=$request->programtime;
        $subprogramDesc=$request->programdesc;
        SubProgram::where(['id'=>$id])->update(['subprogram_name'=>$subProgram,'subprogram_desc'=>$subprogramDesc,'subprogram_workouts'=>$workoutslist,'program_time'=>$programtime]);
           // $subprogram = new SubProgram();
           // $subprogram->program_id=$id;
           // $subprogram->subprogram_name=$subProgram;
           // $subprogram->subprogram_desc=$subprogramDesc;
           // $subprogram->subprogram_workouts=$workoutslist;
           // $subprogram->program_time=$programtime;
           // $subprogram->save();
           $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Sub Program updated Successfully.');
        return redirect()->route('admin.trainer.program.details',$programId); 
    }


    public function programList(Request $request)
    {
         $programList=Program::leftjoin('users','users.id','program.user_id')->leftjoin('category','category.id','program.category_id')->select('program.id','category.category_name','users.first_name','program_name','program_desc','program_image','number_of_weeks','program_time','program_status')->get();
        return view('admin.programList',compact('programList')); 
    }

    public function workoutExercises(Request $request,$id)
    {
       
         $workoutDetails=Workout::where(['id'=>$id])->first();
         $exerciseList= Exercises::where(['workout_id'=>$id])->get();
         $trainerDetails=User::where(['id'=>$workoutDetails->user_id])->first();
         $trainerName=$trainerDetails->first_name;
         $workoutName=$workoutDetails->workout_name;
         return view('admin.exercisesList',compact('workoutDetails','exerciseList','trainerName','workoutName','trainerDetails')); 
    }

    public function addExercises(Request $request,$id)
    {
        $workoutDetails=Workout::where(['id'=>$id])->first();
        $trainerDetails=User::where(['id'=>$workoutDetails->user_id])->first();
        return view('admin.addExercises',compact('workoutDetails','trainerDetails'));

    }

    public function saveExercises(Request $request,$id)
    {

        $videoUrl=$request->exercisevideo;
        $exerciseName=$request->exercisename;
        $exerciseDesc=$request->exercisedesc;
        $exerciseDuration=$request->exerciseduration;
        // if(!empty($request->file('exercisevideo')))
        // {
        //     $file=$request->file('exercisevideo');
        //      $videoUrl ="exsvid".rand(10,100).$request->file('exercisevideo')->getClientOriginalName();
        //     $file->move(public_path().'/exercisevideo/',$videoUrl);
        // }
        $exercise=new Exercises();
        $exercise->workout_id=$id;
        $exercise->exercise_name=$exerciseName;
        $exercise->exercise_desc=$exerciseDesc;
        $exercise->exercise_video=$videoUrl;
        $exercise->exercise_duration=$exerciseDuration;
        $exercise->save();
         // $subprogram->save();
           $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Exercises Added Successfully.');
        return redirect()->route('admin.workout.exercises',$id);
    }

    public function editExercises(Request $request,$id)
    {
        $exerciseDetails=Exercises::where(['id'=>$id])->first();
        $workoutDetails=Workout::where(['id'=>$exerciseDetails->workout_id])->first();
        return view('admin.editExercises',compact('exerciseDetails','workoutDetails'));
    }

    public function updateExercises(Request $request,$id)
    {
        $videoUrl=$request->exercisevideo;
        $exerciseName=$request->exercisename;
        $exerciseDesc=$request->exercisedesc;
        $exerciseDuration=$request->exerciseduration;
        $workoutId=$request->workoutid;
        $exerciseDetails=Exercises::where(['id'=>$id])->update(['exercise_name'=>$exerciseName,'exercise_desc'=>$exerciseDesc,'exercise_video'=>$videoUrl,'exercise_duration'=>$exerciseDuration]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Exercises Updated Successfully.');
        return redirect()->route('admin.workout.exercises',$workoutId);
    }

     public function createProgram(Request $request)
    {
        $categoryDetails=Category::where('category_name','program')->first();
        $subcategoryDetails=SubCategory::get();
        $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','users.last_name')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->get();
        $nutritionList=Nutrition::get();
        return view('admin.createProgram',compact('categoryDetails','trainerList','nutritionList'));
    }

    public function workoutIndexUpdate(Request $request)
    {
       $workoutId=$request->workout_id;
       $workoutId1=$request->workout_id1;
       $position=$request->position_id;
       $position1=$request->position_id1;

       WorkOut::where(['id'=>$workoutId])->update(['position'=>$position1]);
       WorkOut::where(['id'=>$workoutId1])->update(['position'=>$position]);

       return true;
    }

     public function saveProgram(Request $request)
    {
      
       $userId=$request->trainer;
        $categoryId=$request->category;
        $programName=$request->programname;
        
        $programTime=$request->programtime;
        $programDesc=$request->programdesc;
        $number_of_weeks=$request->numberofweeks;
        $programLevel=$request->programlevel;
        $nutritionId=$request->nutrition;
        $fileName ="default.jpg";
        $videoUrl="";
        if(!empty($request->file('programimage')))
        {
            $file=$request->file('programimage');
            ///$path='/'.$categoryId;
             $fileName ="prm".rand(10,100).$request->file('programimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/programimage/',$fileName);
        }
        if(!empty($request->file('programintro')))
        {
            $file=$request->file('programintro');
            ///$path='/'.$categoryId;
             $videoUrl ="prmvid".rand(10,100).$request->file('programintro')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/programintro/',$videoUrl);
        }
      
        $program = new Program();
        $program->user_id = $userId;  
        $program->category_id = $categoryId;
        $program->program_name =$programName;
        $program->program_image=$fileName;
        $program->number_of_weeks=$number_of_weeks;
        $program->program_level=$programLevel;
        $program->program_intro=$videoUrl;
        $program->nutrition_id=implode(',',$nutritionId);
        $program->program_time=$programTime;
        $program->program_desc=$programDesc;
        $program->save();
        $programId=$program->id;

        for($i=0;$i<$number_of_weeks;$i++)
        {
            $weekDesc=!empty($request->weekdesc[$i])?$request->weekdesc[$i]:"";
            ProgramWeekDescription::create(['program_id'=>$programId,'week'=>$i+1,'week_description'=>$weekDesc]);
        }

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Program Added Successfully.');
        return redirect()->route('admin.trainer.program.list',$userId);

    }

    public function editProgram(Request $request,$id)
    {
        $categoryDetails=Category::where('category_name','program')->first();
        $subcategoryDetails=SubCategory::get();
        $trainerList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','users.last_name')->whereHas('roles', function($q){
                $q->where('name', 'Trainer');
        })->get();
        $nutritionList=Nutrition::get();
        $programDetails=Program::where(['id'=>$id])->first();
        $weekDesc=ProgramWeekDescription::where(['program_id'=>$id])->get();
        return view('admin.editProgram',compact('categoryDetails','trainerList','nutritionList','programDetails','weekDesc'));
    }
    public function updateProgram(Request $request,$id)
    {
        $programDetails=Program::where(['id'=>$id])->first();
       $userId=$request->trainer;
        $categoryId=$request->category;
        $programName=$request->programname;
        
        $programTime=$request->programtime;
        $programDesc=$request->programdesc;
        $number_of_weeks=$request->numberofweeks;
        $programLevel=$request->programlevel;
        $nutritionId=$request->nutrition;
        $fileName =$programDetails->program_image;
        $status=$request->status;
        $videoUrl=$programDetails->program_intro;
        if(!empty($request->file('programimage')))
        {
            $file=$request->file('programimage');
            ///$path='/'.$categoryId;
             $fileName ="prm".rand(10,100).$request->file('programimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/programimage/',$fileName);
        }
        if(!empty($request->file('programintro')))
        {
            $file=$request->file('programintro');
            ///$path='/'.$categoryId;
             $videoUrl ="prmvid".rand(10,100).$request->file('programintro')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/programintro/',$videoUrl);
        }
        $nutrition_id=implode(',',$nutritionId);
        Program::where(['id'=>$id])->update(['user_id'=>$userId,'category_id'=>$categoryId,'program_name'=>$programName,'program_image'=>$fileName,'number_of_weeks'=>$number_of_weeks,'program_level'=>$programLevel,'nutrition_id'=>$nutrition_id,'program_time'=>$programTime,'program_desc'=>$programDesc,'program_status'=>$status,'program_intro'=>$videoUrl]);
        for($i=0;$i<$number_of_weeks;$i++)
        {
            $weekDesc=!empty($request->weekdesc[$i])?$request->weekdesc[$i]:"";
            ProgramWeekDescription::where(['program_id'=>$id,'week'=>$i+1])->update(['week_description'=>$weekDesc]);
            
        }

        

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Program Updated Successfully.');
        return redirect()->route('admin.trainer.program.list',$userId);

    }

    public function createUser(Request $request)
    {
        
        return view('admin.createUser');
    }

    public function saveUser(Request $request)
    {
         $name=$request->name;
        $email=$request->email;
        $mobileNumber=$request->mobile_number;
        $fileName ="default.jpg";
        if(!empty($request->file('profileimage')))
        {
            $file=$request->file('profileimage');
            ///$path='/'.$categoryId;
             $fileName ="user".rand(10,100).$request->file('profileimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/user/',$fileName);
        }
       
        $roleTrainer = Role::where('name', config('constant.user_roles.user'))->first();
        $password=Str::random(10);
        $user = new User();
        $user->first_name = $name;  
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->mobile_number=$mobileNumber;
        $user->profile_image=$fileName;
        $user->save();
        $user->roles()->attach($roleTrainer->id);
        $userId=$user->id;

         $data=array('email'=>$email,'password'=>$password);

        Mail::to($email)->send(new SendCredentailsToUser($data));

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'User Added Successfully.');
        return redirect()->route('admin.user.list');
    }

    public function userList(Request $request)
    {
        $userList=User::leftjoin('user_details','users.id','user_details.user_id')->select('users.id','users.first_name','profile_image','users.email','user_desc','address','is_active')->whereHas('roles', function($q){
                $q->where('name', 'User');
        })->get();
        return view('admin.userList',compact('userList'));

    }

    public function editUser(Request $request,$id)
    {

        $userDetails=User::where(['users.id'=>$id])->select('users.id','users.first_name','profile_image','users.email','is_active')->first();
        return view('admin.editUser',compact('userDetails'));
    }

      public function updateUser(Request $request,$id)
    {
        $userDetails=User::where(['id'=>$id])->first();

        $name=$request->name;
        $email=$request->email;
        $status=$request->status;
        $fileName =$userDetails->profile_image;
        if(!empty($request->file('profileimage')))
        {
            $file=$request->file('profileimage');
            ///$path='/'.$categoryId;
             $fileName ="tran".rand(10,100).$request->file('profileimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/user/',$fileName);
        }
       
        User::where(['id'=>$id])->update(['first_name'=>$name,'email'=>$email,'profile_image'=>$fileName,'is_active'=>$status]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'User Updated Successfully.');
        return redirect()->route('admin.user.list');
    }


         public function showProfile(Request $request) {
        $user = Auth::user();
        return view('admin.profile', ['user' => $user]);
    }

        public function profileUpdate(Request $request)
        {
            $user = User::where('id', Auth::user()->id)->first();
        $validator = \Validator::make($request->all(), [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'mobile_number' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $update = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'mobile_number' => $request['mobile_number'],

        ];
       
        $updated = $user->update($update);

        if ($updated) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User Profle updated successfully.');
            return redirect()->back()->withInput()->withSuccess('User Profle updated successfully.');
        }
        return redirect()->back()->withInput()->withErrors('Error while updating the User Profle.'); 
        }


        public function signupUserList(Request $request)
        {
            $userList=User::where('is_shopify_user',false)->whereHas('roles', function($q){
                $q->where('name', 'User');
        })->get();
            
             return view('admin.signupuserlist',compact('userList'));
        }

         public function  approveUser(Request $request,$id)
        {
            
            User::where('id',$id)->update(['is_shopify_user'=>1]);
            $userDetails=User::where('id',$id)->first();
            $useremail=$userDetails->email;
            $firstName=$userDetails->first_name;
            $data=array('mail'=>$useremail,'name'=>$firstName);

            Mail::to($useremail)->send(new ApprovedMail($data));
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User Updated Successfully.');
            return redirect()->route('admin.signup.user.list'); 

        }
        public function  rejectUser(Request $request,$id)
        {
            
            User::where('id',$id)->update(['is_shopify_user'=>2]);
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User Updated Successfully.');
            return redirect()->route('admin.signup.user.list'); 

        }


        public function nutritionList(Request $request)
    {
             
        $nutritionList=Nutrition::get();
        return view('admin.nutritionList',compact('nutritionList'));
    }

    public function createNutrition(Request $request)
    {
        
        return view('admin.addNutrition');
    }

    public function saveNutrition(Request $request)
    {
        $name=$request->nutritionname;
        $description=$request->nutritiondesc;     
        $fileName ="default.jpg";
        $videourl="";
        if(!empty($request->file('nutritionimage')))
        {
            $file=$request->file('nutritionimage');
            ///$path='/'.$categoryId;
             $fileName ="nut".rand(10,100).$request->file('nutritionimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/nutrition/',$fileName);
        }
       if(!empty($request->file('nutritionvideo')))
        {
            $file=$request->file('nutritionvideo');
             $videoUrl ="nutritionvideo".rand(10,100).$request->file('nutritionvideo')->getClientOriginalName();    
            $file->move(public_path().'/nutritionvideo/',$videoUrl);
        }

        
        $nutrition = new Nutrition();
        $nutrition->nutrition_title = $name;  
        $nutrition->nutrition_image = $fileName;
        $nutrition->nutrition_desc  = $description;
        $nutrition->nutrition_video = $videourl;
        
        $nutrition->save();
        

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Nutrition Added Successfully.');
        return redirect()->route('admin.nutrition.list');
    }

    public function  editNutrition(Request $request,$id)
    {
    	$nutritionDetails=Nutrition::where(['id'=>$id])->first();
    	 return view('admin.editNutrition',compact('nutritionDetails'));

    }


    public function  updateNutrition(Request $request,$id)
    {
    	$nutritionDetails=Nutrition::where(['id'=>$id])->first();

        $name=$request->nutritionname;
        $description=$request->nutritiondesc;
        $status=$request->status;
        $fileName =$nutritionDetails->nutrition_image;
        $videoUrl=$nutritionDetails->nutrition_video;
        if(!empty($request->file('nutritionimage')))
        {
            $file=$request->file('nutritionimage');
            ///$path='/'.$categoryId;
            $fileName ="nut".rand(10,100).$request->file('nutritionimage')->getClientOriginalName();
            // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
            $file->move(public_path().'/nutrition/',$fileName);
        }
        if(!empty($request->file('nutritionvideo')))
        {
            $file=$request->file('nutritionvideo');
             $videoUrl ="nutritionvideo".rand(10,100).$request->file('nutritionvideo')->getClientOriginalName();    
            $file->move(public_path().'/nutritionvideo/',$videoUrl);
        }
       Nutrition::where(['id'=>$id])->update(['nutrition_title'=>$name,'nutrition_desc'=>$description,'nutrition_status'=>$status,'nutrition_image'=>$fileName,'nutrition_video'=>$videoUrl]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Nutrition Updated Successfully.');
        return redirect()->route('admin.nutrition.list');

    }



/*
        above code related to the latest api's

*/




    public function approveScholarship(Request $request, $scholarship_id) {
        $scholarships = Scholarship::where('id', $scholarship_id)->first();
        if (!empty($scholarships)) {
            $scholarships->is_active = 1;
            if ($scholarships->save()) {
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Scholarship Approved Successfully.');
            }
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while approving scholarship.');
        }
        return redirect()->route('admin.dashboard');
    }

     public function declineScholarship(Request $request, $scholarship_id) {
        $scholarships = Scholarship::where('id', $scholarship_id)->first();
        $checkActive=($scholarships->is_active==1)?1:0;
        if (!empty($scholarships)) {
            $scholarships->is_active = 2;
            if ($scholarships->save()) {
                if(!empty($checkActive))
                {
                    $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Scholarship Inactive Successfully.');
                }
                else
                {
                   $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Scholarship Rejected Successfully.'); 
                }
                
            }
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while approving scholarship.');
        }

        return redirect()->back();
       // return redirect()->route('admin.dashboard');
    }

    public function activeScholarships(Request $request) {
        $scholarships = Scholarship::where('is_active', 1)->with('user')->orderby('scholarships.id','desc')->get();
        return view('admin.scholaship_index')->with(['scholarships' => $scholarships]);
    }

    public function userScholarshipApplications(Request $request) {
        $userApplication = UserScholarship::has('user')->with(['scholarship', 'user'])->get();
        return view('admin.user_applications')->with(['userApplication' => $userApplication]);
    }

   
}
