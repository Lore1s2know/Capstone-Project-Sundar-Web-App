<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Card Container --}}

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">

            

            {{-- HEADER: Serif, Semibold, Neutral 900 --}}

            <h2 class="font-serif font-semibold text-3xl mb-8 text-neutral-900 dark:text-gray-100">

                Write a Review

            </h2>



            {{-- Success Message --}}

            @if (session()->has('message'))

                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6 font-sans">

                    {{ session('message') }}

                </div>

            @endif



            <form wire:submit="save">

                

                {{-- 1. Product Name Input --}}

                <div class="mb-6">

                    {{-- LABEL: Sans, Slate 400, Small --}}

                    <label class="block font-sans text-slate-400 text-sm font-bold mb-2">

                        PRODUCT NAME

                    </label>

                    {{-- INPUT: Sans, Neutral 900 --}}

                    <input type="text" wire:model="product_name" 

                           placeholder="e.g. Maybelline Lash Sensational"

                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-900 focus:ring-blue-900 font-sans text-neutral-900">

                    @error('product_name') <span class="font-sans text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                </div>



                {{-- 2. Category Dropdown --}}

                <div class="mb-6">

                    <label class="block font-sans text-slate-400 text-sm font-bold mb-2">

                        CATEGORY

                    </label>

                    <select wire:model="category_id" 

                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-900 focus:ring-blue-900 font-sans text-neutral-900">

                        <option value="">Select a Category</option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">{{ $category->name }}</option>

                        @endforeach

                    </select>

                    @error('category_id') <span class="font-sans text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                </div>



                {{-- 3. Review Text Area --}}

                <div class="mb-8">

                    <label class="block font-sans text-slate-400 text-sm font-bold mb-2">

                        YOUR REVIEW

                    </label>

                    <textarea wire:model="review_text" rows="5" 

                              placeholder="Tell us what you liked or disliked about this product..."

                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-900 focus:ring-blue-900 font-sans text-neutral-900"></textarea>

                    @error('review_text') <span class="font-sans text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                </div>



                {{-- SUBMIT BUTTON: Blue 900, Sans, Bold --}}

                <div class="flex items-center justify-end">

                    <button type="submit" 

                            class="bg-blue-900 hover:bg-blue-800 text-white font-sans font-bold py-3 px-6 rounded-lg transition duration-150 ease-in-out shadow-md">

                        Submit Review

                    </button>

                </div>



            </form>

        </div>

    </div>

</div>