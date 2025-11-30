<?php
//Creating the Brain/Logic of the component. Telling the component how to handle reviews actions: fetch reviews, clicking a category filter, sorting by date
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Allows us to use page numbers if we have too many reviews
use App\Models\Review;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Upvote;

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

    public function toggleVote($reviewId, $isUpvote)
    {
        $userId = Auth::id();

        // 1. Check if a vote already exists for this user + review
        $existingVote = Upvote::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->first();

        if ($existingVote) {
            // 2. Logic: If they click the exact same button again, delete it (toggle off)
            if ($existingVote->vote == $isUpvote) {
                $existingVote->delete();
            } else {
                // 3. Logic: If they click the other button, switch the vote
                $existingVote->update(['vote' => $isUpvote]);
            }
        } else {
            // 4. Logic: New vote
            Upvote::create([
                'user_id' => $userId,
                'review_id' => $reviewId,
                'vote' => $isUpvote
            ]);
        }
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
