<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
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
        'tags' => 'nullable|string',
    ]);

    $discussion = new Discussion;
    $discussion->post_title = $request->input('title');
    $discussion->user_id = session('id');
    $discussion->description = $request->input('description');
    $discussion->brief = $request->input('brief');
    $discussion->save();

    // Handle tags if provided
    if ($request->filled('tags')) {
        $tagNames = array_map('trim', explode(',', $request->input('tags')));
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        // Attach tags to the discussion
        $discussion->tags()->sync($tagIds);
    }

    $message = "You have successfully created a new discussion";
    
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

public function addTagToDiscussion(Request $request, Discussion $discussion)
    {
        // Assuming you're receiving tag IDs as an array from the request
        $tagIds = $request->input('tag_ids');

        // Attach tags to the discussion
        $discussion->tags()->sync($tagIds);

        return back()->with('message', 'Tags added successfully.');
    }

}


