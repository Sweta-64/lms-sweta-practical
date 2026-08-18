@extends('layouts.app')

@section('title', 'Apply for Leave')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus"></i> Apply for Leave
            </div>
            <div class="card-body">
                <form action="{{ route('leaves.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="type" class="form-label">Leave Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">-- Select Leave Type --</option>
                            <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="personal" {{ old('type') == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                            <option value="vacation" {{ old('type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
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
                                       id="start_date" name="start_date" required value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" required value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="days-display" class="alert alert-info d-none">
                        <i class="fas fa-info-circle"></i> <strong id="days-count">0</strong> days
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Leave</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" 
                                  rows="4" placeholder="Please provide a brief reason for your leave..." required>{{ old('reason') }}</textarea>
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
                            <i class="fas fa-paper-plane"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-lightbulb"></i> Tips
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>You cannot apply for a leave date that is in the past.</li>
                    <li>You cannot have overlapping leave requests.</li>
                    <li>Your leave will be in <strong>Pending</strong> status until an admin approves or rejects it.</li>
                    <li>You can edit or cancel your leave request only if it's in Pending status.</li>
                </ul>
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
                    daysDisplay.classList.remove('d-none');
                } else {
                    daysDisplay.classList.add('d-none');
                }
            }
        }

        startDateInput.addEventListener('change', calculateDays);
        endDateInput.addEventListener('change', calculateDays);
    </script>
@endsection
@endsection
