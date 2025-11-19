<div class="p-4 flex justify-between items-center border-t border-gray-200">
    @if($paginator->hasPages())
    <div class="text-sm text-gray-600">
        Showing <span class="font-medium">{{ $paginator->firstItem() }}</span> - <span class="font-medium">{{ $paginator->lastItem() }}</span> of <span
            class="font-medium">{{ $paginator->total() }}</span>
    </div>

    <nav class="flex items-center space-x-1">
        @if(!$paginator->onFirstPage())
            <p class="px-3 py-1.5 rounded-md text-gray-400 bg-gray-100 hover:bg-gray-200 hover:cursor-pointer" wire:click="previousPage">
                <span class="material-icons">chevron_left</span>
            </p>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3.5 py-1.5 rounded-md text-sm font-medium text-gray-400 bg-gray-100 hover:bg-gray-200 hover:cursor-pointer">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3.5 py-1.5 rounded-md text-sm font-medium bg-primary text-white hover:cursor-pointer">{{ $page }}</span>
                    @else
                        <button type="button" wire:click="gotoPage({{ $page }})" class="px-3.5 py-1.5 rounded-md text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 hover:cursor-pointer">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if($paginator->hasMorePages())
            <p wire:click="nextPage" class="px-3 py-1.5 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 hover:cursor-pointer">
                <span class="material-icons">chevron_right</span>
            </p>
        @else

        @endif

    </nav>
    @endif
</div>
