<?php

namespace App\Http\Controllers;

use App\Models\SupportGroup;
use Illuminate\Http\Request;

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
}
