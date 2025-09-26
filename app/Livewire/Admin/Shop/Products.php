<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app-admin')]
class Products extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $products;
    public $variants = [];

    // Form fields
    #[Validate('required|string|max:64')]
    public $sku;
    #[Validate('required|string|max:255')]
    public $name_service;
    public $description;
    public $price_service = 0; // base price obsolete
    public $stock = 0; // base stock obsolete
    public $status = true;
    public $image;
    public $id_edit;
    public $is_edit = false;
    
    // Image cropping options
    public $useCropper = true;
    public $cropAspectRatio = [1, 1]; // Square aspect ratio for product images
    public $outputWidth = 800;
    public $outputHeight = 800;
    public $cropOptions = [];
    
    // Loading states
    public $isProcessingImage = false;
    public $processingMessage = 'Processing image...';
    public $croppedImagePreview = null;
    public $croppedImageData = null;
    public $hasCroppedImage = false;

    public function render()
    {
        $this->products = MProduct::with('variants')->orderByDesc('id')->get();
        return view('livewire.admin.shop.products');
    }

    public function mount()
    {
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

    public function resetForm()
    {
        $this->reset(['sku','name_service','description','price_service','stock','status','image','id_edit','is_edit','croppedImageData','croppedImagePreview','hasCroppedImage']);
        $this->variants = [];
    }

    public function handleCroppedImage($imageData = null)
    {
        // Debug: Log the received data structure
        \Log::info('Products handleCroppedImage received:', ['data' => $imageData]);
        
        if (!$imageData) {
            $this->addError('image', 'No image data received.');
            return;
        }

        // Handle different data structures
        $imageDataString = null;
        $filename = 'cropped-product-image.jpg';
        
        if (is_array($imageData)) {
            if (isset($imageData['data'])) {
                $imageDataString = $imageData['data'];
                $filename = $imageData['filename'] ?? 'cropped-product-image.jpg';
            } else {
                $this->addError('image', 'Invalid image data structure received.');
                return;
            }
        } else {
            // If it's a string, treat it as base64 data
            $imageDataString = $imageData;
        }

        // Automatically save the cropped image and set it to the main form
        $this->isProcessingImage = true;
        $this->processingMessage = 'Processing cropped image...';

        try {
            $imageService = new ImageUploadService();
            
            // Create a temporary file from the cropped image data
            $croppedImagePath = $this->createTempFileFromBase64($imageDataString);
            
            // Create UploadedFile instance from the cropped image
            $croppedFile = new \Illuminate\Http\UploadedFile(
                $croppedImagePath,
                $filename,
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
                'path' => 'products',
            ]);

            // Clean up temporary file
            unlink($croppedImagePath);

            // Store the image path for the main form
            $this->image = $result['path']; // Store the path instead of UploadedFile
            $this->croppedImagePreview = $imageDataString; // Show preview
            $this->hasCroppedImage = true;
            
            $this->alert('success', 'Product image cropped and ready! You can now save the product.');
            
        } catch (\Exception $e) {
            $this->addError('image', 'Error processing cropped image: ' . $e->getMessage());
        } finally {
            $this->isProcessingImage = false;
        }
    }


    protected function createTempFileFromBase64($base64Data)
    {
        // Remove data URL prefix if present
        if (strpos($base64Data, 'data:') === 0) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }

        $imageData = base64_decode($base64Data);
        $tempPath = tempnam(sys_get_temp_dir(), 'cropped_product_image_');
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

    public function save()
    {
        $this->validate([
            'sku' => 'required|string|max:64',
            'name_service' => 'required|string|max:255',
            'description' => 'nullable|string',
            // price/stock are handled by variants; keep optional
        ]);

        // Validate variant SKUs for uniqueness
        $variantSkus = [];
        foreach ($this->variants as $index => $v) {
            if (!empty($v['sku'])) {
                if (in_array($v['sku'], $variantSkus)) {
                    $this->addError('variants.' . $index . '.sku', 'SKU must be unique within this product.');
                    return;
                }
                $variantSkus[] = $v['sku'];

                // Check if SKU already exists in database
                $existingVariant = MProductVariant::where('sku', $v['sku'])->first();
                if ($existingVariant && (!$this->is_edit || $existingVariant->m_product_id != $this->id_edit)) {
                    $this->addError('variants.' . $index . '.sku', 'This SKU is already in use.');
                    return;
                }
            }
        }

        // Ensure at least one active variant
        $hasActiveVariant = collect($this->variants)->contains(function($v){
            return !empty($v['name']) && (isset($v['status']) ? (bool)$v['status'] : true) && (isset($v['price']) && $v['price'] !== null);
        });
        if (!$hasActiveVariant) {
            $this->alert('error', 'Please add at least one active variant with a price.');
            return;
        }

        $data = [
            'sku' => $this->sku,
            'name_service' => $this->name_service,
            'description' => $this->description,
            'price_service' => 0,
            'stock' => 0,
            'status' => (bool) $this->status,
        ];

        if ($this->image) {
            // Check if it's already a stored path (from cropped image) or a new upload
            if (is_string($this->image)) {
                // It's already a stored path from cropped image
                $data['image_path'] = $this->image;
                \Log::info('Using cropped image path:', ['path' => $this->image]);
            } else {
                // It's a new file upload
                $path = $this->image->store('products', 'public');
                $data['image_path'] = $path;
                \Log::info('Storing new image:', ['path' => $path]);
            }
        }

        if ($this->is_edit) {
            $product = MProduct::find($this->id_edit);
            if (!$product) {
                $this->alert('error', 'Product not found');
                return;
            }
            // Only delete old image if we have a new one and it's not already stored (cropped)
            if ($this->image && $product->image_path && !is_string($this->image)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->update($data);
            \Log::info('Product updated:', ['id' => $product->id, 'image_path' => $data['image_path'] ?? 'no image']);
            
            // Replace variants
            MProductVariant::where('m_product_id', $product->id)->delete();
            foreach ($this->variants as $v) {
                if (!empty($v['name'])) {
                    $baseSku = $v['sku'] ?? ($this->sku.'-'.strtoupper(generateUUID(4)));
                    $uniqueSku = $this->generateUniqueSku($baseSku);

                    MProductVariant::create([
                        'm_product_id' => $product->id,
                        'sku' => $uniqueSku,
                        'name' => $v['name'],
                        'price' => $v['price'] ?? null,
                        'stock' => $v['stock'] ?? 0,
                        'status' => isset($v['status']) ? (bool)$v['status'] : true,
                    ]);
                }
            }
            $this->alert('success', 'Product updated');
        } else {
            $product = MProduct::create($data);
            \Log::info('Product created:', ['id' => $product->id, 'image_path' => $data['image_path'] ?? 'no image']);
            
            foreach ($this->variants as $v) {
                if (!empty($v['name'])) {
                    $baseSku = $v['sku'] ?? ($this->sku.'-'.strtoupper(generateUUID(4)));
                    $uniqueSku = $this->generateUniqueSku($baseSku);

                    MProductVariant::create([
                        'm_product_id' => $product->id,
                        'sku' => $uniqueSku,
                        'name' => $v['name'],
                        'price' => $v['price'] ?? null,
                        'stock' => $v['stock'] ?? 0,
                        'status' => isset($v['status']) ? (bool)$v['status'] : true,
                    ]);
                }
            }
            $this->alert('success', 'Product created');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $product = MProduct::find($id);
        if (!$product) {
            $this->alert('error', 'Product not found');
            return;
        }
        $this->is_edit = true;
        $this->id_edit = $product->id;
        $this->sku = $product->sku;
        $this->name_service = $product->name_service;
        $this->description = $product->description;
        $this->price_service = 0;
        $this->stock = 0;
        $this->status = $product->status;
        $this->variants = method_exists($product, 'variants') ? $product->variants()->get(['sku','name','price','stock','status'])->toArray() : [];
    }

    public function addVariantRow()
    {
        $this->variants[] = ['sku' => '', 'name' => '', 'price' => null, 'stock' => 0, 'status' => true];
    }

    public function removeVariantRow($index)
    {
        if (isset($this->variants[$index])) unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function delete($id)
    {
        $product = MProduct::find($id);
        if ($product) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->delete();
            $this->alert('success', 'Product deleted');
        }
    }

    private function generateUniqueSku($baseSku)
    {
        $originalSku = $baseSku;
        $counter = 1;
        while (MProductVariant::where('sku', $baseSku)->exists()) {
            $baseSku = $originalSku . '-' . $counter;
            $counter++;
        }
        return $baseSku;
    }
}


