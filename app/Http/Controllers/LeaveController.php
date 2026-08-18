<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of leaves
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all leaves
            $leaves = Leave::with(['user', 'approver'])->latest()->paginate(10);
        } else {
            // Employee sees only their leaves
            $leaves = $user->leaves()->with(['approver'])->latest()->paginate(10);
        }

        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created leave
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:sick,personal,vacation,other',
            'reason' => 'required|string|min:10|max:500',
        ]);

        // Check for overlapping leaves
        if (Leave::hasOverlappingLeave(auth()->id(), $request->start_date, $request->end_date)) {
            return back()->withErrors(['overlap' => 'You already have a leave request for these dates.']);
        }

        $leave = auth()->user()->leaves()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave application submitted successfully!');
    }

    /**
     * Display the specified leave
     */
    public function show(Leave $leave)
    {
        // Check authorization
        if (auth()->user()->isEmployee() && $leave->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing a leave
     */
    public function edit(Leave $leave)
    {
        // Only allow editing pending leaves
        if ($leave->status !== 'pending') {
            return back()->withErrors(['edit' => 'You can only edit pending leave requests.']);
        }

        if (auth()->user()->isEmployee() && $leave->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('leaves.edit', compact('leave'));
    }

    /**
     * Update the specified leave
     */
    public function update(Request $request, Leave $leave)
    {
        // Only allow updating pending leaves
        if ($leave->status !== 'pending') {
            return back()->withErrors(['edit' => 'You can only edit pending leave requests.']);
        }

        if (auth()->user()->isEmployee() && $leave->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:sick,personal,vacation,other',
            'reason' => 'required|string|min:10|max:500',
        ]);

        // Check for overlapping leaves (excluding current leave)
        if (Leave::hasOverlappingLeave(auth()->id(), $request->start_date, $request->end_date, $leave->id)) {
            return back()->withErrors(['overlap' => 'You already have a leave request for these dates.']);
        }

        $leave->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully!');
    }

    /**
     * Remove the specified leave
     */
    public function destroy(Leave $leave)
    {
        // Only allow deleting pending leaves
        if ($leave->status !== 'pending') {
            return back()->withErrors(['delete' => 'You can only delete pending leave requests.']);
        }

        if (auth()->user()->isEmployee() && $leave->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request deleted successfully!');
    }

    /**
     * Approve a leave (Admin only)
     */
    public function approve(Leave $leave)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('leaves.show', $leave)->with('success', 'Leave approved successfully!');
    }

    /**
     * Reject a leave (Admin only)
     */
    public function reject(Request $request, Leave $leave)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'remarks' => 'required|string|min:5|max:500',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('leaves.show', $leave)->with('success', 'Leave rejected successfully!');
    }

    /**
     * API: Get all leaves for the logged-in user
     */
    public function apiMyLeaves()
    {
        $leaves = auth()->user()->leaves()->with(['approver'])->get();
        return response()->json(['data' => $leaves], 200);
    }

    /**
     * API: Get all leaves (Admin only)
     */
    public function apiAllLeaves()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $leaves = Leave::with(['user', 'approver'])->get();
        return response()->json(['data' => $leaves], 200);
    }

    /**
     * API: Get pending leaves (Admin only)
     */
    public function apiPendingLeaves()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $leaves = Leave::where('status', 'pending')->with(['user'])->get();
        return response()->json(['data' => $leaves], 200);
    }

    /**
     * API: Create a new leave
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:sick,personal,vacation,other',
            'reason' => 'required|string|min:10|max:500',
        ]);

        if (Leave::hasOverlappingLeave(auth()->id(), $request->start_date, $request->end_date)) {
            return response()->json([
                'message' => 'Overlapping leave request already exists',
                'error' => 'overlap'
            ], 409);
        }

        $leave = auth()->user()->leaves()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json(['data' => $leave], 201);
    }

    /**
     * API: Approve leave (Admin only)
     */
    public function apiApprove(Leave $leave)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return response()->json(['data' => $leave, 'message' => 'Leave approved'], 200);
    }

    /**
     * API: Reject leave (Admin only)
     */
    public function apiReject(Request $request, Leave $leave)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'remarks' => 'required|string|min:5|max:500',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'remarks' => $request->remarks,
        ]);

        return response()->json(['data' => $leave, 'message' => 'Leave rejected'], 200);
    }
}

