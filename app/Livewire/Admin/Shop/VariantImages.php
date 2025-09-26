<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use App\Models\MProductVariantImage;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Layout('components.layouts.app-admin')]
class VariantImages extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $products;
    public $selectedProductId = null;

    public $variants;
    public $selectedVariantId = null;

    public $images = [];

    // Multiple images upload
    public $newImages = [];
    
    // Image cropping options
    public $useCropper = true;
    public $cropAspectRatio = [1, 1]; // Square aspect ratio for variant images
    public $outputWidth = 600;
    public $outputHeight = 600;
    public $cropOptions = [];
    
    // Loading states
    public $isProcessingImage = false;
    public $processingMessage = 'Processing image...';
    public $croppedImages = []; // Array to store multiple cropped images
    public $currentCroppingIndex = null; // Track which image is being cropped

    public function saveImages()
    {
        $this->validate([
            'selectedProductId' => 'required|integer|exists:m_products,id',
            'selectedVariantId' => 'required|integer|exists:m_product_variants,id',
            'newImages' => 'required|array',
            'newImages.*' => 'image|max:6144',
        ]);

        $variant = MProductVariant::where('m_product_id', $this->selectedProductId)->find($this->selectedVariantId);
        if (!$variant) return;

        // Append images preserving order
        $nextOrder = (int) MProductVariantImage::where('m_product_variant_id', $variant->id)->max('sort_order');

        foreach ($this->newImages as $file) {
            $nextOrder++;
            $path = $file->store('shop/variants', 'public');
            MProductVariantImage::create([
                'm_product_variant_id' => $variant->id,
                'image_path' => $path,
                'sort_order' => $nextOrder,
            ]);
        }

        $this->newImages = [];
        $this->refreshImages();
    }

    public function mount()
    {
        $this->products = MProduct::orderBy('name_service')->get();
        $this->variants = collect();
        $this->refreshImages();
        $this->setupCropOptions();
    }

    protected function setupCropOptions()
    {
        $this->cropOptions = [
            'aspectRatio' => $this->cropAspectRatio[0] / $this->cropAspectRatio[1],
            'viewMode' => 1,
            'dragMode' => 'move',
            'autoCropArea' => 0.8,
            'background' => true,
            'responsive' => true,
            'restore' => false,
            'checkCrossOrigin' => true,
            'checkOrientation' => true,
            'modal' => true,
            'guides' => true,
            'center' => true,
            'highlight' => true,
            'cropBoxMovable' => true,
            'cropBoxResizable' => true,
            'toggleDragModeOnDblclick' => true,
            'minWidth' => 100,
            'minHeight' => 100,
            'maxWidth' => $this->outputWidth * 2,
            'maxHeight' => $this->outputHeight * 2,
        ];
    }

    public function updatedSelectedProductId()
    {
        $this->loadVariants();
        $this->selectedVariantId = null; // wait for explicit selection
        $this->refreshImages();
    }

    public function updatedSelectedVariantId()
    {
        $this->refreshImages();
    }

    public function handleCroppedImage($imageData = null)
    {
        // Debug: Log the received data structure
        \Log::info('VariantImages handleCroppedImage received:', ['data' => $imageData]);
        
        if (!$imageData) {
            $this->addError('newImages', 'No image data received.');
            return;
        }

        // Handle different data structures
        $imageDataString = null;
        $filename = 'cropped-variant-image.jpg';
        
        if (is_array($imageData)) {
            if (isset($imageData['data'])) {
                $imageDataString = $imageData['data'];
                $filename = $imageData['filename'] ?? 'cropped-variant-image.jpg';
            } else {
                $this->addError('newImages', 'Invalid image data structure received.');
                return;
            }
        } else {
            // If it's a string, treat it as base64 data
            $imageDataString = $imageData;
        }

        // Store the cropped image data
        $this->croppedImages[] = [
            'data' => $imageDataString,
            'filename' => $filename,
            'preview' => $imageDataString
        ];
        
        $this->alert('success', 'Variant image cropped successfully! You can add more images or save all.');
    }

    public function saveAllCroppedImages()
    {
        if (empty($this->croppedImages)) {
            $this->addError('croppedImages', 'No cropped images to save.');
            return;
        }

        $this->validate([
            'selectedProductId' => 'required|integer|exists:m_products,id',
            'selectedVariantId' => 'required|integer|exists:m_product_variants,id',
        ]);

        $variant = MProductVariant::where('m_product_id', $this->selectedProductId)->find($this->selectedVariantId);
        if (!$variant) {
            $this->addError('selectedVariantId', 'Selected variant not found.');
            return;
        }

        $this->isProcessingImage = true;
        $this->processingMessage = 'Saving cropped variant images...';

        try {
            $imageService = new ImageUploadService();
            
            // Get next sort order
            $nextOrder = (int) MProductVariantImage::where('m_product_variant_id', $variant->id)->max('sort_order');

            foreach ($this->croppedImages as $croppedImage) {
                $nextOrder++;
                
                // Create a temporary file from the cropped image data
                $croppedImagePath = $this->createTempFileFromBase64($croppedImage['data']);
                
                // Create UploadedFile instance from the cropped image
                $croppedFile = new \Illuminate\Http\UploadedFile(
                    $croppedImagePath,
                    $croppedImage['filename'],
                    'image/jpeg',
                    null,
                    true
                );

                // Upload the cropped image
                $result = $imageService->uploadImage($croppedFile, [
                    'width' => $this->outputWidth,
                    'height' => $this->outputHeight,
                    'quality' => 90,
                    'format' => 'jpg',
                    'path' => 'shop/variants',
                ]);

                // Clean up temporary file
                unlink($croppedImagePath);

                // Create database record
                MProductVariantImage::create([
                    'm_product_variant_id' => $variant->id,
                    'image_path' => $result['path'],
                    'sort_order' => $nextOrder,
                ]);
                
                \Log::info('VariantImage created:', ['path' => $result['path'], 'variant_id' => $variant->id, 'sort_order' => $nextOrder]);
            }

            // Clear cropped images
            $this->croppedImages = [];
            $this->refreshImages();
            $this->alert('success', 'All variant images cropped and saved successfully!');
            
        } catch (\Exception $e) {
            $this->addError('croppedImages', 'Error saving cropped images: ' . $e->getMessage());
        } finally {
            $this->isProcessingImage = false;
        }
    }

    public function removeCroppedImage($index)
    {
        if (isset($this->croppedImages[$index])) {
            unset($this->croppedImages[$index]);
            $this->croppedImages = array_values($this->croppedImages); // Re-index array
            $this->alert('info', 'Cropped image removed.');
        }
    }

    public function clearAllCroppedImages()
    {
        $this->croppedImages = [];
        $this->alert('info', 'All cropped images cleared. You can start over.');
    }

    protected function createTempFileFromBase64($base64Data)
    {
        // Remove data URL prefix if present
        if (strpos($base64Data, 'data:') === 0) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }

        $imageData = base64_decode($base64Data);
        $tempPath = tempnam(sys_get_temp_dir(), 'cropped_variant_image_');
        file_put_contents($tempPath, $imageData);

        return $tempPath;
    }

    // Add this method to handle the event from the child component
    public function getListeners()
    {
        return [
            'imageCropped' => 'handleCroppedImage',
        ];
    }

    private function loadVariants(): void
    {
        if ($this->selectedProductId) {
            $this->variants = MProductVariant::where('m_product_id', $this->selectedProductId)
                ->orderBy('name')->get();
        } else {
            $this->variants = collect();
        }
    }

    private function refreshImages(): void
    {
        if ($this->selectedVariantId) {
            $variant = MProductVariant::with('images')->find($this->selectedVariantId);
            $this->images = $variant ? $variant->images->toArray() : [];
        } else {
            $this->images = [];
        }
    }

    public function deleteImage($id)
    {
        $img = MProductVariantImage::find($id);
        if (!$img) return;
        Storage::disk('public')->delete($img->image_path);
        $img->delete();
        $this->refreshImages();
    }

    public function render()
    {
        return view('livewire.admin.shop.variant-images');
    }
}
