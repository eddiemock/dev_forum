<?php

namespace App\Http\Controllers;

use App\Models\SupportGroup;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SupportGroupController extends Controller
{
    // Display a listing of the support groups.
    public function index()
    {
        $supportGroups = SupportGroup::orderBy('scheduled_at', 'desc')->get();
        return view('support_groups.index', compact('supportGroups'));
    }

    // Show the form for creating a new support group.
    public function create()
    {
        return view('support_groups.create');
    }

    // Store a newly created support group in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ]);

        SupportGroup::create($request->all());

        return redirect()->route('support_groups.index')->with('success', 'Support group created successfully.');
    }

    public function register(Request $request, $groupId)
{
    $userId = auth()->id();
    $supportGroup = SupportGroup::findOrFail($groupId);

    // Directly check if the user is already registered using the relationship in the query
    $alreadyRegistered = DB::table('support_group_user')
                            ->where('support_group_id', $groupId)
                            ->where('user_id', $userId)
                            ->exists();

    if ($alreadyRegistered) {
        return back()->with('error', 'You are already registered for this support group.');
    }

    // Directly attach the user to the support group using the pivot table
    DB::table('support_group_user')->insert([
        'support_group_id' => $groupId,
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'You have successfully registered for the support group.');
}
public function leave(Request $request, $groupId)
{
    $userId = auth()->id();

    // Remove the user from the support group
    DB::table('support_group_user')
      ->where('support_group_id', $groupId)
      ->where('user_id', $userId)
      ->delete();

    return back()->with('success', 'You have successfully left the support group.');
}

}
