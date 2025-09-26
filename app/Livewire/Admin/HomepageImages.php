<?php

namespace App\Livewire\Admin;

use App\Models\HomepageImage;
use App\Services\ImageUploadService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app-admin')]
class HomepageImages extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $images;

    #[Validate('image|mimes:jpg,jpeg,png,webp|max:10240')]
    public $newImage;

    public $section = 'header';

    #[Validate('required|string|max:255')]
    public $altText;

    #[Validate('required|integer|min:1')]
    public $displayOrder;

    // Image cropping options
    public $useCropper = true;
    public $cropAspectRatio = [16, 9]; // Default 16:9 for homepage images
    public $outputWidth = 1920;
    public $outputHeight = 1080;
    public $cropOptions = [];
    
    // Loading states
    public $isProcessingImage = false;
    public $processingMessage = 'Processing image...';
    public $croppedImagePreview = null;
    public $croppedImageData = null;

    protected function rules()
    {
        return [
            'newImage' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            'altText' => 'required|string|max:255',
            'displayOrder' => 'required|integer|min:1'
        ];
    }

    public function mount()
    {
        $this->loadImages();
        $this->setupCropOptions();
    }

    protected function setupCropOptions()
    {
        $this->cropOptions = [
            'aspectRatio' => $this->cropAspectRatio,
            'viewMode' => 1, // Restrict crop box within image
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
            'minWidth' => 800,
            'minHeight' => 450,
            'maxWidth' => 4000,
            'maxHeight' => 2250,
        ];
    }

    public function render()
    {
        return view('livewire.admin.homepage-images');
    }

    public function loadImages()
    {
        $this->images = HomepageImage::where('section', $this->section)
            ->orderBy('display_order')
            ->get();
    }

    public function save()
    {
        if (!$this->newImage) {
            $this->addError('newImage', 'Please upload an image.');
            return;
        }

        $this->validate();

        $this->isProcessingImage = true;
        $this->processingMessage = 'Processing and uploading image...';

        try {
            $imageService = new ImageUploadService();
            
            // Upload and process the image
            $result = $imageService->uploadImage($this->newImage, [
                'width' => $this->outputWidth,
                'height' => $this->outputHeight,
                'crop' => true,
                'quality' => 90,
                'format' => 'jpg',
                'path' => 'homepage-images',
            ]);

            HomepageImage::create([
                'image_path' => $result['path'],
                'alt_text' => $this->altText,
                'section' => $this->section,
                'display_order' => $this->displayOrder,
                'status' => '1'
            ]);

            $this->reset(['newImage', 'altText', 'displayOrder']);
            $this->loadImages();
            $this->alert('success', 'Image added successfully');
            
        } catch (\Exception $e) {
            $this->addError('newImage', 'Error processing image: ' . $e->getMessage());
        } finally {
            $this->isProcessingImage = false;
        }
    }

    public function handleCroppedImage($imageData = null)
    {
        // Debug: Log the received data structure
        \Log::info('handleCroppedImage received:', ['data' => $imageData]);
        
        if (!$imageData) {
            $this->addError('newImage', 'No image data received.');
            return;
        }

        // Handle different data structures
        $imageDataString = null;
        $filename = 'cropped-image.jpg';
        
        if (is_array($imageData)) {
            if (isset($imageData['data'])) {
                $imageDataString = $imageData['data'];
                $filename = $imageData['filename'] ?? 'cropped-image.jpg';
            } else {
                $this->addError('newImage', 'Invalid image data structure received.');
                return;
            }
        } else {
            // If it's a string, treat it as base64 data
            $imageDataString = $imageData;
        }

        // Store the cropped image data for later saving
        $this->croppedImageData = $imageDataString;
        $this->croppedImagePreview = $imageDataString; // Show preview
        
        $this->alert('success', 'Image cropped successfully! Please fill in the details below and click Save Image.');
    }

    public function saveCroppedImage()
    {
        if (!$this->croppedImageData) {
            $this->addError('croppedImageData', 'No cropped image data available.');
            return;
        }

        $this->isProcessingImage = true;
        $this->processingMessage = 'Saving cropped image...';

        try {
            // Validate required fields
            $this->validate([
                'altText' => 'required|string|max:255',
                'displayOrder' => 'required|integer|min:1'
            ]);

            $imageService = new ImageUploadService();
            
            // Create a temporary file from the cropped image data
            $croppedImagePath = $this->createTempFileFromBase64($this->croppedImageData);
            
            // Create UploadedFile instance from the cropped image
            $croppedFile = new \Illuminate\Http\UploadedFile(
                $croppedImagePath,
                'cropped-image.jpg',
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
                'path' => 'homepage-images',
            ]);

            // Clean up temporary file
            unlink($croppedImagePath);

            HomepageImage::create([
                'image_path' => $result['path'],
                'alt_text' => $this->altText,
                'section' => $this->section,
                'display_order' => $this->displayOrder,
                'status' => '1'
            ]);

            // Reset form and clear cropped data
            $this->reset(['newImage', 'altText', 'displayOrder', 'croppedImageData', 'croppedImagePreview']);
            $this->loadImages();
            $this->alert('success', 'Image cropped and saved successfully!');
            
        } catch (\Exception $e) {
            $this->addError('croppedImageData', 'Error saving cropped image: ' . $e->getMessage());
        } finally {
            $this->isProcessingImage = false;
        }
    }

    public function clearCroppedImage()
    {
        $this->reset(['croppedImageData', 'croppedImagePreview', 'altText', 'displayOrder']);
        $this->alert('info', 'Cropped image cleared. You can start over.');
    }

    // Add this method to handle the event from the child component
    public function getListeners()
    {
        return [
            'imageCropped' => 'handleCroppedImage',
        ];
    }

    protected function createTempFileFromBase64($base64Data)
    {
        // Remove data URL prefix if present
        if (strpos($base64Data, 'data:') === 0) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }

        $imageData = base64_decode($base64Data);
        $tempPath = tempnam(sys_get_temp_dir(), 'cropped_image_');
        file_put_contents($tempPath, $imageData);

        return $tempPath;
    }

    public function toggleStatus($id)
    {
        $image = HomepageImage::find($id);
        if ($image) {
            // Convert current status to opposite value ('1' to '0' or '0' to '1')
            $image->status = $image->status === '1' ? '0' : '1';
            $image->save();
            $this->loadImages();
            $this->alert('success', 'Status updated successfully');
        }
    }

    public function delete($id)
    {
        $image = HomepageImage::find($id);
        if ($image) {
            // Use ImageUploadService to delete the image
            $imageService = new ImageUploadService();
            $imageService->deleteImage($image->image_path);
            
            $image->delete();
            $this->loadImages();
            $this->alert('success', 'Image deleted successfully');
        }
    }

    public function switchSection($section)
    {
        $this->section = $section;
        $this->loadImages();
    }
}
