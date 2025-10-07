<?php

namespace App\Livewire\V2\Shop;

use App\Models\ProductReview;
use App\Models\MProduct;
use Livewire\Component;
use Livewire\WithPagination;

class ProductReviews extends Component
{
    use WithPagination;

    public $productId;
    public $sortBy = 'newest'; // newest, oldest, highest_rating, lowest_rating
    public $perPage = 5;

    protected $listeners = ['reviewSubmitted' => '$refresh'];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $product = MProduct::find($this->productId);
        
        if (!$product) {
            return view('livewire.v2.shop.product-reviews', ['reviews' => collect(), 'product' => null]);
        }

        $query = $product->approvedReviews()->with('user');

        // Apply sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest_rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest_rating':
                $query->orderBy('rating', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $reviews = $query->paginate($this->perPage);

        return view('livewire.v2.shop.product-reviews', compact('reviews', 'product'));
    }
}
