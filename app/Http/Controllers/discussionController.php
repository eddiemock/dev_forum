<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Models\Discussion;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
class DiscussionController extends Controller
{

    public function dashboard()
{
    $discussions = Discussion::all(); // Or any other query to get the discussions data
    return view('pages.dashboard', compact('discussions'));
}
    public function new_discussion(){
        return view('pages.newdiscussion');
   }

   public function store(Request $request, Category $category)
{
    Log::info('Authenticated user ID:', ['user_id' => auth()->id()]);

    $validatedData = $request->validate([
        'post_title' => 'required',
        'description' => 'required|max:150',
        'brief' => 'required',
        // other fields as necessary
    ]);

    $discussion = new Discussion($validatedData);
    $discussion->user_id = auth()->id(); // Ensure this is not null
    $discussion->category_id = $category->id;

    Log::info('Discussion before saving:', ['discussion' => $discussion->toArray()]);

    $discussion->save();

    // Handle tags if provided
    if (!empty($validatedData['tags'])) {
        $tagNames = array_map('trim', explode(',', $validatedData['tags']));
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $discussion->tags()->attach($tag->id);
        }
    }

    return redirect()->route('categories.show', $category->id)->with('success', 'Discussion created successfully.');
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

    public function category()
{
    return $this->belongsTo(Category::class);
}
}




