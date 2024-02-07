<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function new_discussion(){
        return view('pages.newdiscussion');
   }

   public function confirm_new_discussion(Request $request){
       $validated_data = $request->validate([
           'title' => 'required',
           'description' => 'required|max:150',
           'brief' => 'required',
       ]);

    //    return dd($request);

       $user = new Discussion;
       $user->post_title =$request->input('title');
       $user->user_id = session('id');
       $user->description =$request->input('description');
       $user->brief =$request->input('brief');
       $user->save();

       $message = "You have successfully created  new discussion";
       
       return redirect('/')->with('success', $message); 

   }

   public function dashboard(){

    $discussions = Discussion::where('user_id', session('id'))->get();
    //  return dd($discussion);

    return view('pages.dashboard', compact('discussions'));
}

public function detail($id){
    $discussion = Discussion::where('id',$id)->FirstorFail();
    // return var_dump($discussion);
    return view('pages.detail',compact('discussion'));
    
}
public function delete($id){
    // return dd($id);
    $data = Discussion::find($id);
    // return dd($data);
    $deleted = $data->delete();

    // return dd($deleted);
   
    return redirect('/dashboard');
}
public function edit_post($id){

    
    $discussion = Discussion::find($id);
    // return dd($data);
     return view('pages.edit_post',compact('discussion'));
}

public function update_post(Request $request){
    $validated_data = $request->validate([
        'title' => 'required',
        'description' => 'required|max:150',
        'brief' => 'required',
    ]);

    $id = $request->input('id');
    $title = $request->input('title');
    $description = $request->input('description');
    $brief = $request->input('brief');

    // return dd($description);

    $discussion = Discussion::find($id)->update([
        'post_title' => $title,
        'description' => $description,
        'brief' => $brief
    ]);

    // return dd($discussion);

    // $discussion->update([
    //     'post_title' => $title,
    //     'description' => $description,
    //     'brief' => $brief
    // ]);

    // return dd($discussion);

    $message = "Updated";
    
    return redirect('/dashboard')->with('success', $message); 

    

}

}


