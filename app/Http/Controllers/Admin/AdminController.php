<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\Scholarship;
use App\Model\UserScholarship;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        $categoryDetails=Category::get();
        return view('admin.createSubCategory',compact('categoryDetails'));
    }

    public function saveSubCreateCategory(Request $request)
    {
        $categoryId=$request->category;
        $subCategoryName=$request->subcategoryname;
        $subCategoryDesc=$request->subcategorydesc;

        $file=$request->file('subcategoryimage');
           ///$path='/'.$categoryId;
            $fileName ="SubCat".rand(10,100).$request->file('subcategoryimage')->getClientOriginalName();
        // $filePath = $request->file('itemImage')->storeAs('category'.$path, $fileName, 'public');  
        $file->move(public_path().'/subcategory/',$fileName);
        SubCategory::create(['category_id'=>$categoryId,'subcategory_name'=>$subCategoryName,'subcategory_desc'=>$subCategoryDesc,'subcategory_image'=>$fileName]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'subCategory Added Successfully.');
        return redirect()->route('admin.subcategory.list');
    }

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

    public function showProfile(Request $request) {
        $user = Auth::user();
        return view('admin.profile', ['user' => $user]);
    }
}
