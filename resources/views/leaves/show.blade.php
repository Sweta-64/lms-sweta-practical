@extends('layouts.app')

@section('title', 'Leave Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Leave Details Card -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-invoice"></i> Leave Details</span>
                    <span class="badge badge-{{ $leave->status }} fs-6">
                        @if($leave->isPending())
                            <i class="fas fa-clock"></i> Pending
                        @elseif($leave->isApproved())
                            <i class="fas fa-check"></i> Approved
                        @else
                            <i class="fas fa-times"></i> Rejected
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Employee Name</p>
                        <h5 class="mb-3">{{ $leave->user->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Email</p>
                        <h5 class="mb-3">{{ $leave->user->email }}</h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Leave Type</p>
                        <h5 class="mb-3">
                            <span class="badge" style="background: linear-gradient(90deg, #3b82f6, #2563eb);">
                                <i class="fas fa-tag"></i> {{ ucfirst($leave->type) }}
                            </span>
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Total Days</p>
                        <h5 class="mb-3">{{ $leave->getDaysCountAttribute() }} days</h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Start Date</p>
                        <h5 class="mb-3">{{ $leave->start_date->format('d M Y') }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">End Date</p>
                        <h5 class="mb-3">{{ $leave->end_date->format('d M Y') }}</h5>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="text-muted mb-1">Reason</p>
                    <p class="mb-0 bg-light p-3 rounded">{{ $leave->reason }}</p>
                </div>

                @if($leave->approver)
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Approved/Rejected By</p>
                            <h5 class="mb-3">{{ $leave->approver->name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Decision Date</p>
                            <h5 class="mb-3">{{ $leave->updated_at->format('d M Y, H:i A') }}</h5>
                        </div>
                    </div>
                @endif

                @if($leave->remarks)
                    <div class="mb-3">
                        <p class="text-muted mb-1">Admin Remarks</p>
                        <p class="mb-0 bg-light p-3 rounded alert alert-warning mb-0">{{ $leave->remarks }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Admin Actions -->
        @if(auth()->user()->isAdmin() && $leave->isPending())
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-gavel"></i> Admin Actions
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('leaves.approve', $leave) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Approve Leave
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times"></i> Reject Leave
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Leaves
            </a>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle"></i> Reject Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('leaves.reject', $leave) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Required)</label>
                        <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" 
                                  rows="4" placeholder="Please provide a reason for rejection..." required></textarea>
                        <small class="text-muted d-block mt-1">Minimum 5 characters</small>
                        @error('remarks')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
