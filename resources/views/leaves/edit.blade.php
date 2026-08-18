@extends('layouts.app')

@section('title', 'Edit Leave Request')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Edit Leave Request
            </div>
            <div class="card-body">
                <form action="{{ route('leaves.update', $leave) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="type" class="form-label">Leave Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">-- Select Leave Type --</option>
                            <option value="sick" {{ $leave->type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="personal" {{ $leave->type == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                            <option value="vacation" {{ $leave->type == 'vacation' ? 'selected' : '' }}>Vacation</option>
                            <option value="other" {{ $leave->type == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" required value="{{ $leave->start_date->format('Y-m-d') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" required value="{{ $leave->end_date->format('Y-m-d') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="days-display" class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong id="days-count">{{ $leave->getDaysCountAttribute() }}</strong> days
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Leave</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" 
                                  rows="4" required>{{ $leave->reason }}</textarea>
                        <small class="text-muted d-block mt-1">Minimum 10 characters</small>
                        @error('reason')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('leaves.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const daysDisplay = document.getElementById('days-display');
        const daysCount = document.getElementById('days-count');

        function calculateDays() {
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;

                if (days > 0) {
                    daysCount.textContent = days;
                }
            }
        }

        startDateInput.addEventListener('change', calculateDays);
        endDateInput.addEventListener('change', calculateDays);
    </script>
@endsection
@endsection
