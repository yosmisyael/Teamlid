<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Daily Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">calendar_today</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Selected Date</p>
                <span class="text-lg font-bold text-primary">{{ \Carbon\Carbon::parse($filterDate)->format('M d, Y') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Present</p>
                <span class="text-2xl font-bold text-primary">{{ $dailyStats->present }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">schedule</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Late Arrivals</p>
                <span class="text-2xl font-bold text-primary">{{ $dailyStats->late }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">cancel</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Absent</p>
                <span class="text-2xl font-bold text-primary">{{ $dailyStats->absent }}</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <!-- Date Filter -->
            <div class="relative">
                <label class="block text-xs font-medium text-gray-500 mb-1">Filter Date</label>
                <input type="date" wire:model.live="filterDate" class="bg-gray-50 rounded-md py-2 px-3 w-full border border-gray-200 focus:ring-secondary">
            </div>

            <!-- Text Search -->
            <div class="relative">
                <label class="block text-xs font-medium text-gray-500 mb-1">Search Employee</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-icons text-gray-400 text-sm">search</span>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="searchQuery"
                           class="bg-gray-50 rounded-md py-2 pl-9 pr-4 w-full border border-gray-200 focus:ring-secondary"
                           placeholder="Name or ID...">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="relative flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select wire:model.live="filterStatus" class="bg-gray-50 rounded-md py-2 px-3 w-full border border-gray-200 focus:ring-secondary">
                        <option value="">All Statuses</option>
                        <option value="attended">Attended</option>
                        <option value="late">Late</option>
                        <option value="early exit">Early Exit</option>
                        <option value="absent">Absent</option>
                        <option value="leave">Leave</option>
                        <option value="sick leave">Sick Leave</option>
                        <option value="annual leave">Annual Leave</option>
                    </select>
                </div>
                <button wire:click="toggleForm" class="button-primary h-[42px] flex items-center justify-center px-4">
                    <span class="material-icons text-lg mr-1">add_circle</span>
                    Record
                </button>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Date</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Employee</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Check In</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Check Out</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Work Duration</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Edit</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($attendances as $attendance)
                    @php
                        // Determine if this record should show times
                        $showTimes = in_array($attendance->status, ['attended', 'late', 'early exit']);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $attendance->date->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ $attendance->date->format('l') }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-tertiary flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($attendance->employee->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $attendance->employee->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $attendance->employee->job ? $attendance->employee->job->name : 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-mono text-gray-700">
                            @if($showTimes && $attendance->check_in_at)
                                {{ \Carbon\Carbon::parse($attendance->check_in_at)->format('H:i') }}
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-mono text-gray-700">
                            @if($showTimes && $attendance->check_out_at)
                                {{ \Carbon\Carbon::parse($attendance->check_out_at)->format('H:i') }}
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                            @if($showTimes && $attendance->check_in_at && $attendance->check_out_at)
                                @php
                                    $start = \Carbon\Carbon::parse($attendance->check_in_at);
                                    $end = \Carbon\Carbon::parse($attendance->check_out_at);
                                    $diff = $start->diff($end);
                                @endphp
                                {{ $diff->h }}h {{ $diff->i }}m
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @php
                                $colors = [
                                    'attended' => 'bg-green-100 text-green-800',
                                    'late' => 'bg-yellow-100 text-yellow-800',
                                    'early exit' => 'bg-yellow-100 text-yellow-800',
                                    'absent' => 'bg-red-100 text-red-800',
                                    'leave' => 'bg-purple-100 text-purple-800',
                                    'sick leave' => 'bg-pink-100 text-pink-800',
                                    'annual leave' => 'bg-blue-100 text-blue-800',
                                ];
                                $class = $colors[$attendance->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }} uppercase">
                                {{ $attendance->status }}
                            </span>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="editAttendance({{ $attendance->id }})" class="text-gray-400 hover:text-secondary">
                                <span class="material-icons">edit</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">
                            No attendance records found for this date/filter.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $attendances->links('components.pagination') }}
    </div>

    {{--  Slide-over Form  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary">
                {{ $attendanceToEditId ? 'Edit Attendance' : 'Record Attendance' }}
            </h2>
            <button wire:click="toggleForm" class="text-gray-500 hover:text-red-500">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveAttendance" class="flex flex-col gap-5">

                <!-- Employee Selection Logic -->
                @if($attendanceToEditId)
                    <div class="bg-gray-50 p-4 rounded border border-gray-200">
                        <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Employee</div>
                        <div class="font-bold text-gray-800">{{ $employee_name_display }}</div>
                    </div>
                @else
                    <div class="input-group">
                        <label class="input-label">Select Employee</label>
                        <select wire:model="employee_id" class="input-select">
                            <option value="">Choose an employee...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="input-group">
                    <label class="input-label">Date</label>
                    <input wire:model="date" type="date" class="input-field">
                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Status</label>
                    <!-- wire:model.live allows us to disable time inputs reactively -->
                    <select wire:model.live="status" class="input-select">
                        <option value="">Select Status...</option>
                        <optgroup label="Present">
                            <option value="attended">Attended (Present)</option>
                            <option value="late">Late</option>
                            <option value="early exit">Early Exit</option>
                        </optgroup>
                        <optgroup label="Absent/Leave">
                            <option value="absent">Absent</option>
                            <option value="leave">Leave (General)</option>
                            <option value="sick leave">Sick Leave</option>
                            <option value="annual leave">Annual Leave</option>
                        </optgroup>
                    </select>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Logic to check if time inputs should be enabled --}}
                @php
                    $disableTimeInputs = !in_array($status, ['attended', 'late', 'early exit']);
                @endphp

                <div class="grid grid-cols-2 gap-4">
                    <div class="input-group">
                        <label class="input-label {{ $disableTimeInputs ? 'text-gray-400' : '' }}">Check In</label>
                        <input wire:model="check_in_at" type="time"
                               class="input-field {{ $disableTimeInputs ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                            {{ $disableTimeInputs ? 'disabled' : '' }}>
                        @error('check_in_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group">
                        <label class="input-label {{ $disableTimeInputs ? 'text-gray-400' : '' }}">Check Out</label>
                        <input wire:model="check_out_at" type="time"
                               class="input-field {{ $disableTimeInputs ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                            {{ $disableTimeInputs ? 'disabled' : '' }}>
                        @error('check_out_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleForm" type="button" class="button-secondary w-32">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary w-40">
                        {{ $attendanceToEditId ? 'Save Correction' : 'Record Entry' }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
