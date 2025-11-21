<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-yellow-600">pending_actions</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pending Requests</p>
                <span class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-green-600">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Approved</p>
                <span class="text-2xl font-bold text-green-600">{{ $approvedCount }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-red-600">cancel</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rejected</p>
                <span class="text-2xl font-bold text-red-600">{{ $rejectedCount }}</span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="material-icons text-gray-400 text-sm">filter_list</span>
                <span class="text-sm font-medium text-gray-700">Filter Status:</span>
                <select wire:model.live="filterStatus" class="bg-gray-50 border border-gray-200 text-sm rounded-md focus:ring-secondary focus:border-secondary p-2">
                    <option value="">All Requests</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Employee</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Duration</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Reason</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Date Requested</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($leaves as $leave)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-tertiary flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($leave->employee->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $leave->employee->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $leave->employee->job ? $leave->employee->job->name : 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d') }}</div>
                            <div class="text-xs text-gray-500">{{ $leave->duration }} Days</div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 truncate max-w-[200px]" title="{{ $leave->reason }}">
                                {{ $leave->reason }}
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @if($leave->status === 'pending')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($leave->status === 'approved')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $leave->created_at->diffForHumans() }}
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="openReview({{ $leave->id }})" class="text-gray-400 hover:text-primary cursor-pointer font-bold text-xs uppercase tracking-wider flex items-center">
                                <span class="material-icons text-sm mr-1">rate_review</span>
                                Review
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            No leave requests found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $leaves->links('components.pagination') }}
    </div>

    {{--  Review Slide-over Panel  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isReviewFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">

        <!-- Header -->
        <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Review Request</h2>
                <span class="text-xs text-gray-500 uppercase tracking-wide">ID: #{{ $leaveToReviewId }}</span>
            </div>
            <button wire:click="toggleReviewForm" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 overflow-y-auto flex-1 space-y-6">
            @if($leaveToReviewId && !empty($reviewData))

                <!-- Employee Context Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg">
                            {{ substr($reviewData['employee_name'] ?? 'U', 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">{{ $reviewData['employee_name'] }}</h3>
                            <p class="text-xs text-gray-500">EMP ID: {{ $reviewData['employee_id'] }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-y-3 gap-x-4 text-sm">
                        <div>
                            <span class="block text-xs text-gray-400 uppercase">Department</span>
                            <span class="font-medium text-gray-700">{{ $reviewData['department'] }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400 uppercase">Job Title</span>
                            <span class="font-medium text-gray-700">{{ $reviewData['job'] }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-xs text-gray-400 uppercase">Position</span>
                            <span class="font-medium text-gray-700">{{ $reviewData['position'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Leave Details -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-1">Request Details</h4>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="block text-xs text-gray-500">Start Date</span>
                                <span class="font-bold text-gray-800">{{ $reviewData['start_date'] }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="block text-xs text-gray-500">End Date</span>
                                <span class="font-bold text-gray-800">{{ $reviewData['end_date'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-blue-50 p-3 rounded border border-blue-100">
                            <span class="text-sm text-blue-800 font-medium">Total Duration</span>
                            <span class="text-lg font-bold text-blue-800">{{ $reviewData['duration'] }}</span>
                        </div>

                        <div>
                            <span class="block text-xs text-gray-500 mb-1">Reason</span>
                            <div class="bg-gray-50 p-4 rounded text-sm text-gray-700 italic border border-gray-200">
                                "{{ $reviewData['reason'] }}"
                            </div>
                        </div>

                        <div>
                            <span class="block text-xs text-gray-500 mb-1">Current Status</span>
                            @if($reviewData['status'] === 'pending')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold uppercase">Pending Approval</span>
                            @elseif($reviewData['status'] === 'approved')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold uppercase cursor-pointer">Approved</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold uppercase cursor-pointer">Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>

            @endif
        </div>

        <!-- Footer Actions -->
        <div class="p-6 border-t border-gray-200 bg-gray-50">
            @if(isset($reviewData['status']) && $reviewData['status'] === 'pending')
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="updateStatus('rejected')" class="flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none cursor-pointer">
                        <span class="material-icons text-base mr-2">thumb_down</span>
                        Reject
                    </button>
                    <button wire:click="updateStatus('approved')" class="flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none cursor-pointer">
                        <span class="material-icons text-base mr-2">thumb_up</span>
                        Approve
                    </button>
                </div>
            @else
                <div class="text-center text-gray-500 text-sm italic">
                    This request has already been processed.
                </div>
            @endif
        </div>

    </section>
</main>
