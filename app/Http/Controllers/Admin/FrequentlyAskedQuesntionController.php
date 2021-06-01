<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\FrequentlyAskedQuestion;

class FrequentlyAskedQuesntionController extends Controller
{

    public function index(Request $request) {
        $questions = FrequentlyAskedQuestion::get();
        return view('admin.faq.index')->with(['questions' => $questions]);
    }

    public function create(Request $request) {
        return view('admin.faq.create');
    }

    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'question' => ['required'],
                    'answer' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $faq = new FrequentlyAskedQuestion();
        $faq->question = $data['question'];
        $faq->answer = $data['answer'];
        if ($faq->save()) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Question added Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while adding question');
        }
        return redirect()->route('faqs.index');
    }

    public function edit(Request $request, $id) {
        $question = FrequentlyAskedQuestion::where('id', $id)->first();
        return view('admin.faq.create')->with(['question' => $question]);
    }

    public function update(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
                    'question' => ['required'],
                    'answer' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $faq = FrequentlyAskedQuestion::where('id', $id)->update(['question' => $request['question'], 'answer' => $request['answer']]);
        if ($faq) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Question Updated Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while updating question.');
        }
        return redirect()->route('faqs.index');
    }

    public function destroy(Request $request, $id) {
        $faq = FrequentlyAskedQuestion::where('id', $id)->delete();
        if ($faq) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Question Deleted Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while deleting question.');
        }
        return redirect()->route('faqs.index');
    }

}
