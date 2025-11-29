<?php
//Creating the Brain/Logic of the component. Telling the component how to handle reviews actions: fetch reviews, clicking a category filter, sorting by date
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Allows us to use page numbers if we have too many reviews
use App\Models\Review;
use App\Models\Category;
use Livewire\Attributes\Layout;

class ShowReviews extends Component
{
    use WithPagination;

    // 1. Variables to control the view
    public $categoryFilter = ''; // Stores the ID of the selected category (empty = all)
    public $sortOrder = 'desc';  // 'desc' (Recent) or 'asc' (Oldest)

    // 2. Function to switch the Category
    public function setCategory($id)
    {
        $this->categoryFilter = $id;
        $this->resetPage(); // Go back to page 1 when filtering
    }

    // 3. Function to switch Sort Order
    public function setSort($order)
    {
        $this->sortOrder = $order;
        $this->resetPage();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        // Start building the query
        $reviews = Review::with(['user', 'category', 'upvotes']) // Eager load data to be fast
            ->when($this->categoryFilter, function ($query) {
                // If a category is selected, filter by it
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy('created_at', $this->sortOrder) // Apply sorting
            ->paginate(10); // Show 10 per page

        return view('livewire.show-reviews', [
            'reviews' => $reviews,
            'categories' => Category::all(), // Send categories for the filter buttons
        ]);
    }
}
