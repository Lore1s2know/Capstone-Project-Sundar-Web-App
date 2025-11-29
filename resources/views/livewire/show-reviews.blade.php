--!-Adding the face of the component! resources/views/livewire/show-reviews.blade.php -->
<div class="py-12">
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
                {{-- "All" Button --}}
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
                    <div class="flex justify-between items-start mb-4">
                        <div>
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
                        
                        {{-- Upvote Badge (Visual Only for now) --}}
                        <div class="flex flex-col items-center">
                            <span class="font-sans font-bold text-neutral-900 text-lg">
                                {{ $review->upvotes->where('vote', 1)->count() }}
                            </span>
                            <span class="font-sans text-slate-400 text-xs uppercase">Votes</span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <p class="font-sans text-neutral-900 leading-relaxed mb-4">
                        {{ $review->review_text }}
                    </p>

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