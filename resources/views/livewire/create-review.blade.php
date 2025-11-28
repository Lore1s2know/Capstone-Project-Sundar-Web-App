<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Write a Review</h2>

            {{-- Success Message --}}
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit="save">
                
                {{-- 1. Product Name Input --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Product Name</label>
                    <input type="text" wire:model="product_name" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('product_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- 2. Category Dropdown --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Category</label>
                    <select wire:model="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">Select a Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- 3. Review Text Area --}}
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Your Review</label>
                    <textarea wire:model="review_text" rows="4" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    @error('review_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit Review
                </button>

            </form>
        </div>
    </div>
</div>