<div class="py-12"> {{-- <--- THIS IS THE ONE ROOT ELEMENT --}}
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- PAGE HEADER --}}
        <div class="mb-8">
            <h2 class="font-serif font-semibold text-3xl text-neutral-900 dark:text-gray-100">
                Community Reviews
            </h2>
            <p class="font-sans text-slate-400 mt-2">See what others are saying about the latest products.</p>
        </div>

        {{-- CONTROLS AREA (Filters & Sort) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            
            {{-- Category Filters --}}
            <div class="flex gap-2">
                <button wire:click="setCategory('')" 
                        class="px-4 py-2 rounded-full font-sans font-bold text-sm transition
                        {{ $categoryFilter == '' ? 'bg-blue-900 text-white shadow-md' : 'bg-white text-slate-400 border border-slate-200 hover:border-blue-900 hover:text-blue-900' }}">
                    All
                </button>

                @foreach($categories as $category)
                    <button wire:click="setCategory({{ $category->id }})" 
                            class="px-4 py-2 rounded-full font-sans font-bold text-sm transition
                            {{ $categoryFilter == $category->id ? 'bg-blue-900 text-white shadow-md' : 'bg-white text-slate-400 border border-slate-200 hover:border-blue-900 hover:text-blue-900' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Sort Options --}}
            <div class="flex items-center gap-3">
                <span class="font-sans text-slate-400 text-sm font-bold uppercase tracking-wider">Sort By:</span>
                <button wire:click="setSort('desc')" 
                        class="font-sans text-sm font-bold {{ $sortOrder === 'desc' ? 'text-blue-900 underline decoration-2' : 'text-slate-400 hover:text-neutral-900' }}">
                    Newest
                </button>
                <button wire:click="setSort('asc')" 
                        class="font-sans text-sm font-bold {{ $sortOrder === 'asc' ? 'text-blue-900 underline decoration-2' : 'text-slate-400 hover:text-neutral-900' }}">
                    Oldest
                </button>
            </div>
        </div>

        {{-- REVIEWS LIST --}}
        <div class="space-y-6">
            @forelse($reviews as $review)
                {{-- Review Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-900 transition hover:shadow-md">
                    
                    {{-- Card Header --}}
                    <div class="mb-4">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="bg-slate-100 text-slate-500 text-xs font-sans font-bold px-2 py-1 rounded uppercase tracking-wide">
                                    {{ $review->category->name }}
                                </span>
                                <span class="font-sans text-slate-400 text-sm">
                                    {{ $review->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h3 class="font-serif font-semibold text-xl text-neutral-900">
                                {{ $review->product_name }}
                            </h3>
                        </div>

                    {{-- Card Body --}}
                    <p class="font-sans text-neutral-900 leading-relaxed mb-3">
                        {{ $review->review_text }}
                    </p>
                        
                        {{-- Interactive Voting Buttons --}}
                    <div class="flex items-center gap-1 mb-4">
                            @php
                                $userVote = $review->upvotes->where('user_id', auth()->id())->first();
                            @endphp

                        {{-- UPVOTE BUTTON --}}
                            <button wire:click="toggleVote({{ $review->id }}, true)" 
                                    class="transition hover:scale-110 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                 class="w-4 h-4 {{ $userVote && $userVote->vote == 1 ? 'text-blue-900' : 'text-slate-400 hover:text-blue-900' }}">
                                    <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 011.06 0l7.5 7.5a.75.75 0 11-1.06 1.06l-6.22-6.22V21a.75.75 0 01-1.5 0V4.81l-6.22 6.22a.75.75 0 11-1.06-1.06l7.5-7.5z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- SCORE COUNT --}}
                        <span class="font-sans font-semibold text-sm text-neutral-600 dark:text-neutral-400 px-1">
                                {{ $review->upvotes->where('vote', 1)->count() - $review->upvotes->where('vote', 0)->count() }}
                            </span>

                            {{-- DOWNVOTE BUTTON --}}
                            <button wire:click="toggleVote({{ $review->id }}, false)" 
                                    class="transition hover:scale-110 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                                 class="w-4 h-4 {{ $userVote && $userVote->vote === 0 ? 'text-blue-900' : 'text-slate-400 hover:text-blue-900' }}">
                                    <path fill-rule="evenodd" d="M12.53 21.53a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06l6.22 6.22V3a.75.75 0 011.5 0v16.19l6.22-6.22a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                                </svg>
                            </button>
                    </div>

                    {{-- Card Footer --}}
                    <div class="border-t border-gray-100 pt-4 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-blue-900 flex items-center justify-center text-white font-serif font-bold text-xs">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <span class="font-sans text-sm font-semibold text-neutral-900">
                            {{ $review->user->name }}
                        </span>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <p class="font-serif text-xl text-slate-400">No reviews found in this category.</p>
                </div>
            @endforelse

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>