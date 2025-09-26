<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Services\ImageUploadService;

class ImageCropper extends Component
{
    use WithFileUploads;

    public $image;
    public $croppedImageData = null;
    public $showCropper = false;
    public $cropOptions = [];
    public $uploadedImageUrl = null;
    public $isProcessing = false;
    public $isUploading = false;

    // Configuration options
    public $aspectRatio = null; // null for free aspect ratio, or array like [16, 9]
    public $minWidth = 100;
    public $minHeight = 100;
    public $maxWidth = 1920;
    public $maxHeight = 1080;
    public $viewMode = 1; // 0: free, 1: restrict, 2: restrict with minimum size
    public $dragMode = 'move'; // 'move', 'crop', 'none'
    public $autoCropArea = 0.8; // 0-1, percentage of image to auto-crop
    public $background = true; // show background
    public $responsive = true;
    public $restore = false;
    public $checkCrossOrigin = true;
    public $checkOrientation = true;
    public $modal = true;
    public $guides = true;
    public $center = true;
    public $highlight = true;
    public $cropBoxMovable = true;
    public $cropBoxResizable = true;
    public $toggleDragModeOnDblclick = true;

    // Output options
    public $outputWidth = null;
    public $outputHeight = null;
    public $outputFormat = 'jpg';
    public $outputQuality = 0.9;
    public $outputType = 'base64'; // 'base64', 'blob', 'canvas'

    protected $listeners = ['imageSelected' => 'handleImageSelected'];

    public function mount($cropOptions = [])
    {
        $this->cropOptions = array_merge([
            'aspectRatio' => $this->aspectRatio,
            'viewMode' => $this->viewMode,
            'dragMode' => $this->dragMode,
            'autoCropArea' => $this->autoCropArea,
            'background' => $this->background,
            'responsive' => $this->responsive,
            'restore' => $this->restore,
            'checkCrossOrigin' => $this->checkCrossOrigin,
            'checkOrientation' => $this->checkOrientation,
            'modal' => $this->modal,
            'guides' => $this->guides,
            'center' => $this->center,
            'highlight' => $this->highlight,
            'cropBoxMovable' => $this->cropBoxMovable,
            'cropBoxResizable' => $this->cropBoxResizable,
            'toggleDragModeOnDblclick' => $this->toggleDragModeOnDblclick,
            'minWidth' => $this->minWidth,
            'minHeight' => $this->minHeight,
            'maxWidth' => $this->maxWidth,
            'maxHeight' => $this->maxHeight,
        ], $cropOptions);
    }

    public function updatedImage()
    {
        if ($this->image) {
            $this->isUploading = true;
            
            $this->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB max
            ]);

            $this->showCropper = true;
            $this->uploadedImageUrl = $this->image->temporaryUrl();
            $this->croppedImageData = null;
            $this->isUploading = false;
        }
    }

    public function handleImageSelected($imageData = null)
    {
        if ($imageData) {
            $this->croppedImageData = $imageData;
            $this->showCropper = false;
            $this->isProcessing = true;

            // Process the cropped image
            $this->processCroppedImage();
        }
    }

    public function processCroppedImage()
    {
        if (!$this->croppedImageData) {
            $this->isProcessing = false;
            return;
        }

        try {
            // Log the data structure for debugging
            \Log::info('ImageCropper processCroppedImage data:', ['data' => $this->croppedImageData]);
            
            // The croppedImageData should already be in the correct format from handleImageSelected
            $imageData = $this->croppedImageData;
            $filename = 'cropped-image.jpg';
            
            // Ensure we have the correct structure
            if (is_array($imageData) && isset($imageData['data'])) {
                // Data is already in correct format
                $finalData = $imageData;
            } else {
                // Convert to correct format
                $finalData = [
                    'data' => $imageData,
                    'filename' => $filename
                ];
            }
            
            // Emit event with the cropped image data
            $this->dispatch('imageCropped', $finalData);
            
            $this->isProcessing = false;
            $this->reset(['image', 'croppedImageData', 'showCropper', 'uploadedImageUrl']);

        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->addError('image', 'Error processing image: ' . $e->getMessage());
        }
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

    public function cancelCrop()
    {
        $this->reset(['image', 'croppedImageData', 'showCropper', 'uploadedImageUrl']);
    }

    public function render()
    {
        return view('livewire.component.image-cropper');
    }

    // Helper methods for configuration
    public function setAspectRatio($width, $height = null)
    {
        if ($height === null) {
            $this->aspectRatio = $width;
        } else {
            $this->aspectRatio = [$width, $height];
        }
        $this->cropOptions['aspectRatio'] = $this->aspectRatio;
    }

    public function setOutputSize($width, $height = null)
    {
        $this->outputWidth = $width;
        $this->outputHeight = $height;
    }

    public function setOutputFormat($format)
    {
        $this->outputFormat = $format;
    }

    public function setOutputQuality($quality)
    {
        $this->outputQuality = $quality;
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
        $this->cropOptions['viewMode'] = $mode;
    }

    public function setDragMode($mode)
    {
        $this->dragMode = $mode;
        $this->cropOptions['dragMode'] = $mode;
    }
}
