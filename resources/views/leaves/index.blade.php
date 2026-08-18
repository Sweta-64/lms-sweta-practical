@extends('layouts.app')

@section('title', 'My Leaves')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="section-title">
            <i class="fas fa-list"></i> Leave Requests
        </h1>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->user()->isEmployee())
            <a href="{{ route('leaves.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Apply for Leave
            </a>
        @endif
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    @php
        $pendingCount = auth()->user()->leaves()->where('status', 'pending')->count();
        $approvedCount = auth()->user()->leaves()->where('status', 'approved')->count();
        $rejectedCount = auth()->user()->leaves()->where('status', 'rejected')->count();
    @endphp

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Pending Requests</p>
                        <h2 class="text-warning mb-0">{{ $pendingCount }}</h2>
                    </div>
                    <i class="fas fa-clock text-warning" style="font-size: 2.5rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Approved Leaves</p>
                        <h2 class="text-success mb-0">{{ $approvedCount }}</h2>
                    </div>
                    <i class="fas fa-check-circle text-success" style="font-size: 2.5rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Rejected Requests</p>
                        <h2 class="text-danger mb-0">{{ $rejectedCount }}</h2>
                    </div>
                    <i class="fas fa-times-circle text-danger" style="font-size: 2.5rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaves Table -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Leave Applications
    </div>
    <div class="card-body p-0">
        @if($leaves->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                            <tr>
                                <td>
                                    <strong>{{ $leave->user->name }}</strong>
                                    @if(auth()->user()->isAdmin())
                                        <br><small class="text-muted">{{ $leave->user->email }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(90deg, #3b82f6, #2563eb);">
                                        <i class="fas fa-tag"></i> {{ ucfirst($leave->type) }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $leave->start_date->format('d M Y') }} to {{ $leave->end_date->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <strong>{{ $leave->getDaysCountAttribute() }} days</strong>
                                </td>
                                <td>
                                    @if($leave->isPending())
                                        <span class="badge badge-pending">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @elseif($leave->isApproved())
                                        <span class="badge badge-approved">
                                            <i class="fas fa-check"></i> Approved
                                        </span>
                                    @else
                                        <span class="badge badge-rejected">
                                            <i class="fas fa-times"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ Str::limit($leave->reason, 30) }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('leaves.show', $leave) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($leave->isPending() && (auth()->user()->isEmployee() && $leave->user_id == auth()->id()))
                                        <a href="{{ route('leaves.edit', $leave) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('leaves.destroy', $leave) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $leaves->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #cbd5e1;"></i>
                <p class="text-muted mt-3">No leave requests found.</p>
                @if(auth()->user()->isEmployee())
                    <a href="{{ route('leaves.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Apply for Your First Leave
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
