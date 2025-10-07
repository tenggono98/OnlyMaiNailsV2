<div class="bg-white border border-gray-200 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        @if($hasExistingReview)
            Update Your Review
        @else
            Write a Review
        @endif
    </h3>

    @if(!Auth::check())
        <div class="text-center py-8">
            <p class="text-gray-600 mb-4">Please login to write a review.</p>
            <a href="{{ route('login') }}" class="btn-primary">
                Login to Review
            </a>
        </div>
    @else
        <form wire:submit.prevent="submitReview">
            <!-- Rating Stars -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                wire:click="setRating({{ $i }})"
                                class="focus:outline-none transition-colors duration-200">
                            @if($i <= $rating)
                                <svg class="w-8 h-8 text-yellow-400 hover:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        </button>
                    @endfor
                    @if($rating > 0)
                        <span class="ml-2 text-sm text-gray-600">
                            {{ $rating }} star{{ $rating > 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>
                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Review Text -->
            <div class="mb-4">
                <label for="reviewText" class="block text-sm font-medium text-gray-700 mb-2">Review (Optional)</label>
                <textarea wire:model="reviewText" 
                          id="reviewText"
                          rows="4" 
                          placeholder="Share your experience with this product..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-accent-light focus:border-brand-accent-light resize-none"></textarea>
                @error('reviewText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Verified Purchase -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input wire:model="isVerifiedPurchase" 
                           type="checkbox" 
                           class="h-4 w-4 text-brand-accent-light focus:ring-brand-accent-light border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">I purchased this product</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="btn-primary">
                    @if($hasExistingReview)
                        Update Review
                    @else
                        Submit Review
                    @endif
                </button>
            </div>
        </form>
    @endif
</div>