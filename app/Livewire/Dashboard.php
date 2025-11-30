<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    use WithPagination;
    public $editingReviewId = null;
    public $categoryFilter = '';
    public $sortOrder = 'desc';

    // 1. Filter Logic
    public function setCategory($id)
    {
        $this->categoryFilter = $id;
        $this->resetPage();
    }

    // 2. Sort Logic
    public function setSort($order)
    {
        $this->sortOrder = $order;
        $this->resetPage();
    }

    // 3. Delete Logic (New!)
    public function deleteReview($reviewId)
    {
        $review = Review::find($reviewId);

        // Security Check: Ensure only the owner can delete
        if ($review && $review->user_id === Auth::id()) {
            $review->delete();
            session()->flash('message', 'Review deleted successfully.');
        }
    }

    //Dropdown Edit Category Button
    // 1. Open the dropdown for a specific review
    public function editCategory($reviewId)
    {
        $this->editingReviewId = $reviewId;
    }

    // 2. Close the dropdown without saving
    public function cancelEdit()
    {
        $this->editingReviewId = null;
    }

    // 3. Save the new category
    public function updateCategory($reviewId, $newCategoryId)
    {
        $review = Review::find($reviewId);

        // Security Check
        if ($review && $review->user_id === Auth::id()) {
            $review->update(['category_id' => $newCategoryId]);

            $this->editingReviewId = null; // Close the dropdown
            session()->flash('message', 'Category updated successfully.');
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $userReviews = Review::with(['category', 'upvotes'])
            ->where('user_id', Auth::id()) // <--- KEY DIFFERENCE: Only My Reviews
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy('created_at', $this->sortOrder)
            ->paginate(5);

        return view('livewire.dashboard', [
            'reviews' => $userReviews,
            'categories' => Category::all()
        ]);
    }
}
