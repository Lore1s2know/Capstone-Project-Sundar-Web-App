<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- 1. TOP ACTION AREA --}}
        <div class="flex justify-between items-center mb-6">
            
            <a href="{{ route('review.create') }}" wire:navigate 
               class="bg-blue-900 hover:bg-blue-800 text-white font-sans font-bold py-2 px-6 rounded-lg shadow-md transition">
                + New Review
            </a>
        </div>

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 font-sans">
                {{ session('message') }}
            </div>
        @endif

        {{-- 2. STATS OVERVIEW CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            {{-- Card 1: Total Reviews --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-900 flex items-center justify-between">
                <div>
                    <p class="font-sans text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        Total Reviews
                    </p>
                    <h3 class="font-serif font-bold text-3xl text-neutral-900 dark:text-gray-100">
                        {{ $statReviews }}
                    </h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
            </div>

            {{-- Card 2: Total Upvotes --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-900 flex items-center justify-between">
                <div>
                    <p class="font-sans text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        Upvotes
                    </p>
                    <h3 class="font-serif font-bold text-3xl text-neutral-900 dark:text-gray-100">
                        {{ $statUpvotes }}
                    </h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                </div>
            </div>

            {{-- Card 3: Total Downvotes --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-900 flex items-center justify-between">
                <div>
                    <p class="font-sans text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        Downvotes
                    </p>
                    <h3 class="font-serif font-bold text-3xl text-neutral-900 dark:text-gray-100">
                        {{ $statDownvotes }}
                    </h3>
                </div>
                <div class="p-3 bg-rose-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-rose-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>
                </div>
            </div>

        </div>

        
        {{-- 2. BIG WIDE CARD CONTAINER --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            
            {{-- A. UPPER BORDER AREA (Title Left, Sort Right) --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-900">
                {{-- Title --}}
                <h3 class="font-serif font-bold text-xl text-neutral-900 dark:text-gray-100">
                    My Reviews
                </h3>

                {{-- Sort Controls --}}
                <div class="flex items-center gap-3">
                    <span class="font-sans text-slate-400 text-xs font-bold uppercase tracking-wider">Sort By:</span>
                    <button wire:click="setSort('desc')" 
                            class="font-sans text-xs font-bold {{ $sortOrder === 'desc' ? 'text-blue-900 underline decoration-2' : 'text-slate-400 hover:text-neutral-900' }}">
                        Newest
                    </button>
                    <span class="text-slate-300">|</span>
                    <button wire:click="setSort('asc')" 
                            class="font-sans text-xs font-bold {{ $sortOrder === 'asc' ? 'text-blue-900 underline decoration-2' : 'text-slate-400 hover:text-neutral-900' }}">
                        Oldest
                    </button>
                </div>
            </div>

            {{-- B. MAIN BODY OF THE CARD --}}
            <div class="p-6">

                {{-- Filter Pill Group (Top Right) --}}
                <div class="flex justify-end mb-6">
                    <div class="inline-flex rounded-md shadow-sm isolate">
                        {{-- 'All' Button --}}
                        <button wire:click="setCategory('')" 
                            class="relative inline-flex items-center px-4 py-2 text-sm font-sans font-medium border border-gray-300 rounded-l-md focus:z-10 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 transition
                            {{ $categoryFilter == '' ? 'bg-blue-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            All
                        </button>
                        
                        {{-- Loop for Categories --}}
                        @foreach($categories as $index => $category)
                            <button wire:click="setCategory({{ $category->id }})" 
                                class="relative inline-flex items-center px-4 py-2 text-sm font-sans font-medium border-t border-b border-r border-gray-300 focus:z-10 focus:border-blue-900 focus:ring-1 focus:ring-blue-900 transition
                                {{ $loop->last ? 'rounded-r-md' : '' }}
                                {{ $categoryFilter == $category->id ? 'bg-blue-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- C. REVIEWS LIST --}}
                <div class="space-y-6">
                    @forelse($reviews as $review)
                        
                        {{-- Small Review Card (No Blue Border) --}}
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition relative">
                            
                            {{-- Content Header --}}
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="bg-slate-100 text-slate-500 text-xs font-sans font-bold px-2 py-1 rounded uppercase tracking-wide">
                                        {{ $review->category->name }}
                                    </span>
                                    <span class="font-sans text-slate-400 text-sm">
                                        {{ $review->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                {{-- Vote Count Display (Read Only) --}}
                                <div class="flex items-center gap-1">
                                    @php
                                        $userVote = $review->upvotes->where('user_id', auth()->id())->first();
                                    @endphp

                                    {{-- UPVOTE BUTTON (Read Only) --}}
                                    <div class="cursor-not-allowed opacity-60">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                             class="w-4 h-4 {{ $userVote && $userVote->vote == 1 ? 'text-blue-900' : 'text-slate-400' }}">
                                            <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 011.06 0l7.5 7.5a.75.75 0 11-1.06 1.06l-6.22-6.22V21a.75.75 0 01-1.5 0V4.81l-6.22 6.22a.75.75 0 11-1.06-1.06l7.5-7.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>

                                    {{-- SCORE COUNT --}}
                                    <span class="font-sans font-semibold text-sm text-neutral-600 dark:text-neutral-400 px-1">
                                        {{ $review->upvotes->where('vote', 1)->count() - $review->upvotes->where('vote', 0)->count() }}
                                    </span>

                                    {{-- DOWNVOTE BUTTON (Read Only) --}}
                                    <div class="cursor-not-allowed opacity-60">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                             class="w-4 h-4 {{ $userVote && $userVote->vote === 0 ? 'text-blue-900' : 'text-slate-400' }}">
                                            <path fill-rule="evenodd" d="M12.53 21.53a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06l6.22 6.22V3a.75.75 0 011.5 0v16.19l6.22-6.22a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <h4 class="font-serif font-bold text-lg text-neutral-900 mb-2">
                                {{ $review->product_name }}
                            </h4>
                            
                            <p class="font-sans text-neutral-900 text-sm leading-relaxed mb-8">
                                {{ $review->review_text }}
                            </p>

                            {{-- ACTION BUTTONS (Bottom Right) --}}
                            <div class="absolute bottom-6 right-6 flex gap-3">
                                
                                {{-- Edit Button (Blue 900) --}}
                                {{-- EDIT CATEGORY LOGIC --}}
                                <div class="relative">
                                    
                                    @if($editingReviewId === $review->id)
                                        {{-- 1. THE DROPDOWN MENU (Shows when editing) --}}
                                        <div class="absolute bottom-full right-0 mb-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                            <div class="py-1" role="menu">
                                                <div class="px-4 py-2 text-xs text-slate-400 font-bold uppercase border-b border-gray-100 dark:border-gray-600">
                                                    Select New Category
                                                </div>
                                                
                                                @foreach($categories as $category)
                                                    <button wire:click="updateCategory({{ $review->id }}, {{ $category->id }})"
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-blue-900 transition" 
                                                            role="menuitem">
                                                        {{ $category->name }}
                                                    </button>
                                                @endforeach

                                                {{-- Cancel Option --}}
                                                <button wire:click="cancelEdit" 
                                                        class="block w-full text-left px-4 py-2 text-xs text-rose-500 font-bold border-t border-gray-100 dark:border-gray-600 hover:bg-rose-50 transition">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        {{-- 2. THE TRIGGER BUTTON (Shows normally) --}}
                                        <button wire:click="editCategory({{ $review->id }})" 
                                                class="text-blue-900 hover:text-blue-700 font-sans font-bold text-sm border border-blue-900 hover:bg-blue-50 px-3 py-1 rounded transition">
                                            Edit Category
                                        </button>
                                    @endif

                                </div>

                                {{-- Delete Button (Rose 500) --}}
                                {{-- We add a confirmation dialog to prevent accidents --}}
                                <button wire:click="deleteReview({{ $review->id }})"
                                        wire:confirm="Are you sure you want to delete this review?"
                                        class="text-rose-500 hover:text-rose-700 font-sans font-bold text-sm border border-rose-500 hover:bg-rose-50 px-3 py-1 rounded transition">
                                    Delete
                                </button>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 font-sans">
                            You haven't written any reviews yet.
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>