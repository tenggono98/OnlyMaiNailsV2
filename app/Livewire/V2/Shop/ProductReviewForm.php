<?php

namespace App\Livewire\V2\Shop;

use App\Models\ProductReview;
use App\Models\MProduct;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductReviewForm extends Component
{
    use LivewireAlert;

    public $productId;
    public $rating = 0;
    public $reviewText = '';
    public $isVerifiedPurchase = false;
    public $hasExistingReview = false;
    public $existingReview = null;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'reviewText' => 'nullable|string|max:1000',
        'isVerifiedPurchase' => 'boolean',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;
        
        // Check if user has existing review
        if (Auth::check()) {
            $this->existingReview = ProductReview::where('m_product_id', $productId)
                ->where('user_id', Auth::id())
                ->first();
            
            if ($this->existingReview) {
                $this->hasExistingReview = true;
                $this->rating = $this->existingReview->rating;
                $this->reviewText = $this->existingReview->review_text;
                $this->isVerifiedPurchase = $this->existingReview->is_verified_purchase;
            }
        }
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            $this->alert('error', 'Please login to submit a review.');
            return;
        }

        $this->validate();

        $product = MProduct::find($this->productId);
        if (!$product) {
            $this->alert('error', 'Product not found.');
            return;
        }

        try {
            if ($this->hasExistingReview) {
                // Update existing review
                $this->existingReview->update([
                    'rating' => $this->rating,
                    'review_text' => $this->reviewText,
                    'is_verified_purchase' => $this->isVerifiedPurchase,
                ]);
                $this->alert('success', 'Your review has been updated successfully!');
            } else {
                // Create new review
                ProductReview::create([
                    'm_product_id' => $this->productId,
                    'user_id' => Auth::id(),
                    'rating' => $this->rating,
                    'review_text' => $this->reviewText,
                    'is_verified_purchase' => $this->isVerifiedPurchase,
                    'is_approved' => false, // Requires admin approval
                ]);
                $this->alert('success', 'Your review has been submitted successfully! It will be visible after admin approval.');
            }

            // Reset form
            $this->reviewText = '';
            $this->isVerifiedPurchase = false;
            
            // Emit event to refresh parent component
            $this->dispatch('reviewSubmitted');
            
        } catch (\Exception $e) {
            $this->alert('error', 'Something went wrong. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.v2.shop.product-review-form');
    }
}
