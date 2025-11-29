<main class="flex-1 h-full bg-surface-low flex flex-col overflow-hidden relative">
    <!-- Mobile Header / Greeting -->
    <div class="bg-tertiary p-6 pb-8 shadow-md z-10 rounded-3xl m-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-700 text-xs uppercase tracking-wider font-bold mb-1">{{ \Carbon\Carbon::now()->format('l, d M Y') }}</p>
                <h1 class="text-2xl font-bold text-primary">Hello, {{ $employee->name }}</h1>
                <p class="text-sm text-gray-700">
                    @if(now()->isWeekend())
                        Enjoy your weekend. Time to rest and recover!
                    @else
                        Ready for today?
                    @endif
                </p>
            </div>
            <!-- Profile Avatar -->
            <div wire:click="toggleMenu" class="cursor-pointer w-10 h-10 rounded-full bg-surface-high border-2 border-white shadow-md flex items-center justify-center text-primary font-bold relative">
                {{ \Illuminate\Support\Str::substr($employee->name, 0, 2) }}
                @if($isMenuOpened)
                    <ul class="absolute p-2 top-10 bg-highest shadow-md right-0 bg-white rounded-md">
                        <li>
                            <form action="/employees/{{ $companyParam }}/logout" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer inline-flex gap-2 items-center rounded-md text-red-600 hover:bg-red-500 hover:text-white p-2">
                                    <span class="material-icons">logout</span>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                @endif
            </div>

        </div>
    </div>

    <!-- Main Content Scrollable -->
    <div class="flex-1 overflow-y-auto p-4 space-y-6 -mt-4">

        <!-- Attendance Card (Hero) -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all active:scale-[0.98]">
            <div class="p-6 flex flex-col items-center justify-center text-center space-y-4">
                @if(now()->isWeekend())
                    <div class="w-20 h-20 rounded-full bg-tertiary flex items-center justify-center mb-2">
                        <span class="material-icons text-4xl text-primary">event_busy</span>
                    </div>
                    <h1 class="text-2xl font-semibold text-primary py-4">No work for today</h1>
                @else
                    @if($attendanceState === 'completed')
                        <div class="w-20 h-20 rounded-full bg-tertiary flex items-center justify-center mb-2">
                            <span class="material-icons text-4xl text-primary">task_alt</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">You're all set!</h3>
                            <p class="text-sm text-gray-500">Shift completed for today.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-8 w-full mt-2">
                            <div class="shadow-md py-4 border border-gray-200 rounded-lg">
                                <span class="block text-xs text-gray-400 uppercase">In</span>
                                <span class=" font-bold text-gray-700 text-lg">{{ \Carbon\Carbon::parse($checkInTime)->format('H:i') }}</span>
                            </div>
                            <div class="shadow-md py-4 border border-gray-200 rounded-lg">
                                <span class="block text-xs text-gray-400 uppercase">Out</span>
                                <span class=" font-bold text-gray-700 text-lg">{{ \Carbon\Carbon::parse($checkOutTime)->format('H:i') }}</span>
                            </div>
                        </div>
                    @elseif($attendanceState === 'checked_in')
                        <div class="w-20 h-20 rounded-full bg-blue-50 flex items-center justify-center mb-2 animate-pulse">
                            <span class="material-icons text-4xl text-blue-600">timer</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">On Duty</h3>
                            <p class="text-sm text-gray-500">Checked in at {{ \Carbon\Carbon::parse($checkInTime)->format('H:i') }}</p>
                        </div>
                        <button wire:click="recordAttendance" class="cursor-pointer w-full py-4 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-100 flex items-center justify-center gap-2 mt-2">
                            <span class="material-icons">exit_to_app</span>
                            Clock Out Now
                        </button>
                    @else
                        <div wire:click="recordAttendance" class="cursor-pointer w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-2">
                            <span class="material-icons text-8xl text-primary">touch_app</span>
                        </div>
                        <div wire:click="recordAttendance" class="cursor-pointer">
                            <h3 class="text-lg font-bold text-gray-800">Start Shift</h3>
                            <p class="text-sm text-gray-500">Record your attendance now.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-2 gap-4">
            <button wire:click="toggleLeaveForm" class="cursor-pointer bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 hover:bg-gray-50">
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                    <span class="material-icons">event_note</span>
                </div>
                <span class="text-sm font-semibold text-gray-700">Request Leave</span>
            </button>

            <button wire:click="togglePayslipList" class="cursor-pointer bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 hover:bg-gray-50">
                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                    <span class="material-icons">receipt_long</span>
                </div>
                <span class="text-sm font-semibold text-gray-700">Payslips</span>
            </button>
        </div>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Attendance History -->
            <div class="col-span-1">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Attendance History</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-50 p-4 flex flex-col gap-4">
                    @forelse($recentActivity as $log)
                        <div class="p-4 rounded-md hover:cursor-pointer border border-gray-200 shadow-md flex items-center justify-between hover:bg-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $log->status == 'late' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-500' }} flex items-center justify-center">
                                    <span class="material-icons text-sm">
                                        {{ in_array($log->status, ['sick leave', 'annual leave', 'leave']) ? 'flight_takeoff' : 'schedule' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $log->date->format('d M') }}</p>
                                    <p class="text-xs text-gray-400 capitalize">{{ $log->status }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs  font-bold text-gray-700">
                                    <span class="text-[10px] text-gray-400">In</span>
                                    {{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i') : '-' }}
                                </p>
                                <p class="text-xs  font-bold text-gray-700">
                                    <span class="text-[10px] text-gray-400">Out</span>
                                    {{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-400">No recent activity.</div>
                    @endforelse
                </div>
                {{ $recentActivity->links('components.pagination') }}
            </div>

            <!-- Leave Request -->
            <div class="col-span-1">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Leave Request</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-50 flex flex-col p-4 gap-4">
                    @forelse($leaveRequest as $leave)
                        <div wire:click="showLeaveDetail({{$leave->id}})" class="flex items-center justify-between p-4 rounded-md hover:cursor-pointer border border-gray-200 shadow-md hover:bg-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $leave->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-600'
                                        : ( $leave->status == 'approved'
                                            ? 'bg-tertiary text-primary'
                                            : 'bg-red-100 text-red-600'
                                          )
                                    }} flex items-center justify-center">
                                    <span class="material-icons text-sm">
                                        @switch($leave->status)
                                            @case('pending')
                                                schedule
                                                @break('pending')
                                            @case('rejected')
                                                close
                                                @break('rejected')
                                            @case('approved')
                                                check
                                                @break('approved')
                                        @endswitch

                                    </span>
                                </div>
                                <div>
                                    <p>{{ $leave->reason }}</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M') }}</p>
                                    <p class="text-xs text-gray-400 capitalize">{{ $leave->status }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-400">You have not submitted any leave request yet.</div>
                    @endforelse
                </div>
                {{ $leaveRequest->links('components.pagination') }}
            </div>
        </section>

        <div class="h-12"></div>
    </div>

    {{-- Leave Request Slide-over Form --}}
    <div class="fixed inset-0 z-50 pointer-events-none flex justify-end">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity duration-300 {{ $isLeaveFormOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0' }}" wire:click="toggleLeaveForm"></div>

        <!-- Panel -->
        <div class="relative w-full max-w-md bg-surface-high h-full shadow-2xl transform transition-transform duration-300 ease-out flex flex-col {{ $isLeaveFormOpen ? 'translate-x-0 pointer-events-auto' : 'translate-x-full' }}">

            <!-- Header -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="form-title">
                    New Leave Request
                </h2>
                <button wire:click="toggleLeaveForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <form wire:submit.prevent="submitLeave" class="flex flex-col gap-5">

                    <!-- Leave Type -->
                    <div class="input-group">
                        <label class="input-label">Leave Type</label>
                        <div class="grid grid-cols-2 gap-3 mt-1">
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="leave_type" value="Annual Leave" class="peer sr-only">
                                <div class="p-3 rounded-lg border border-gray-200 text-center hover:bg-gray-50 peer-checked:bg-primary/5 peer-checked:border-primary peer-checked:text-primary transition-all">
                                    <span class="material-icons">calendar_view_day</span>
                                    <span class="block text-sm font-medium">Annual</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="leave_type" value="Sick Leave" class="peer sr-only">
                                <div class="p-3 rounded-lg border border-gray-200 text-center hover:bg-gray-50 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-600 transition-all">
                                    <span class="material-icons">sick</span>
                                    <span class="block text-sm font-medium">Sick</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group">
                            <label class="input-label">From</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">date_range</span>
                                <input id="name" wire:model.live="start_date" type="date" class="input-field">
                            </div>
                            @error('start_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="input-group">
                            <label class="input-label">To</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">date_range</span>
                                <input wire:model.live="end_date" type="date" class="input-field w-full">
                            </div>
                            @error('end_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="input-group">
                        <label class="input-label">Reason</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">article</span>
                            <textarea wire:model="reason" rows="3" class="input-field w-full py-2" placeholder="Brief explanation..."></textarea>
                        </div>
                        @error('reason') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex gap-4 justify-end">
                        <button wire:click="toggleLeaveForm" type="button" class="button-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="button-primary">
                            <span class="material-icons">send</span>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Payslip Slide-over List --}}
    <div class="fixed inset-0 z-50 pointer-events-none flex justify-end">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity duration-300 {{ $isPayslipListOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0' }}" wire:click="togglePayslipList"></div>

        <!-- Panel -->
        <div class="relative w-full max-w-md bg-surface-high h-full shadow-2xl transform transition-transform duration-300 ease-out flex flex-col {{ $isPayslipListOpen ? 'translate-x-0 pointer-events-auto' : 'translate-x-full' }}">

            <!-- Header -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="form-title">
                    Payslip Records
                </h2>
                <button wire:click="togglePayslipList" class="text-gray-500 hover:text-red-500 cursor-pointer">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 flex-col gap-4">
                @foreach($payslips as $payslip)
                    <div class="rounded-md shadow-sm border border-gray-300 hover:bg-gray-100 px-4 py-2 flex flex-col">
                        <div>
                            <h3 class="text-lg font-medium">Period: {{ \Carbon\Carbon::createFromFormat('Y-m', $payslip->period_month)->monthName }}</h3>
                            <h3 class="text-base font-medium text-gray-500">{{ \Carbon\Carbon::createFromFormat('Y-m', $payslip->period_month)->year }}</h3>
                        </div>
                        <a href="{{ route('employee.payroll', [ 'company' => $companyParam,'id' => $payslip->id ]) }}" class="button-primary ml-auto">
                            <span class="material-icons text-white">download</span>
                            Download
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Request Detail Modal --}}
    @if($isDetailLeaveOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50 p-4">
            <div class="bg-surface-high p-4 w-full max-w-lg rounded-xl shadow-2xl transform transition-all">

                {{-- Modal Header --}}
                <div class="sm:flex sm:items-center border-b pb-3 mb-4">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-tertiary sm:mx-0 sm:h-10 sm:w-10">
                        <span class="material-icons text-primary text-xl">history</span>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-primary font-bold text-xl" id="modal-title">
                            Leave Request Detail (ID: {{ optional($selectedLeave)->id }})
                        </h3>
                    </div>
                </div>

                {{-- Modal Body --}}
                @if($selectedLeave)
                    <div class="space-y-3">
                        @php
                            $statusClass = [
                                'approved' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ][$selectedLeave->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp

                        <div class="p-3 rounded-lg flex justify-between items-center {{ $statusClass }}">
                            <span class="font-semibold uppercase text-sm">Current Status:</span>
                            <span class="font-extrabold uppercase">{{ $selectedLeave->status }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                            <p class="text-sm font-semibold text-gray-600">Leave Start:</p>
                            <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($selectedLeave->start_date)->format('d M Y') }}</p>

                            <p class="text-sm font-semibold text-gray-600">Leave end:</p>
                            <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($selectedLeave->end_date)->format('d M Y') }}</p>

                            <p class="text-sm font-semibold text-gray-600">Submitted on:</p>
                            <p class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($selectedLeave->created_at)->format('d M Y H:i') }}</p>
                        </div>

                        {{-- Alasan --}}
                        <div class="pt-3">
                            <h4 class="font-semibold text-gray-700 border-t pt-2">Reason:</h4>
                            <p class="text-gray-900 mt-1 p-2 bg-gray-50 rounded border text-sm">
                                {{ $selectedLeave->reason }}
                            </p>
                        </div>

                    </div>
                @else
                    <p class="text-red-500">Leave request not found.</p>
                @endif

                {{-- Footer Aksi --}}
                <div class="sm:flex sm:flex-row-reverse gap-3 border-t pt-4 mt-4">
                    <button wire:click="$set('isDetailLeaveOpen', false)" type="button" class="w-full sm:w-auto button-primary bg-gray-300 text-gray-800 hover:bg-gray-400 transition-colors duration-150">
                        Close
                    </button>
                </div>
            </div>
        </section>
    @endif
</main>
