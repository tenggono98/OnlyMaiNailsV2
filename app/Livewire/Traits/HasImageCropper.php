<?php

namespace App\Livewire\Traits;

use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;

trait HasImageCropper
{
    // Image cropping properties
    public $useCropper = true;
    public $cropAspectRatio = [1, 1];
    public $outputWidth = 800;
    public $outputHeight = 800;
    public $cropOptions = [];
    
    // Loading states
    public $isProcessingImage = false;
    public $processingMessage = 'Processing image...';
    public $croppedImagePreview = null;
    public $croppedImageData = null;

    /**
     * Setup crop options based on dimensions
     */
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

    /**
     * Set crop dimensions and aspect ratio
     */
    public function setCropDimensions(int $width, int $height, array $aspectRatio = null)
    {
        $this->outputWidth = $width;
        $this->outputHeight = $height;
        $this->cropAspectRatio = $aspectRatio ?? [$width, $height];
        $this->setupCropOptions();
    }

    /**
     * Use a preset configuration
     */
    public function usePreset(string $preset)
    {
        $imageService = new ImageUploadService();
        $presetConfig = $imageService->getPreset($preset);
        
        $this->outputWidth = $presetConfig['width'];
        $this->outputHeight = $presetConfig['height'];
        $this->cropAspectRatio = $presetConfig['aspectRatio'];
        $this->setupCropOptions();
    }

    /**
     * Handle cropped image data from the cropper component
     */
    public function handleCroppedImage($imageData = null)
    {
        \Log::info('HasImageCropper handleCroppedImage received:', ['data' => $imageData]);
        
        if (!$imageData) {
            $this->addError('image', 'No image data received.');
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
                $this->addError('image', 'Invalid image data structure received.');
                return;
            }
        } else {
            $imageDataString = $imageData;
        }

        // Store the cropped image data for later saving
        $this->croppedImageData = $imageDataString;
        $this->croppedImagePreview = $imageDataString;
        
        $this->alert('success', 'Image cropped successfully! You can now save it.');
    }

    /**
     * Save cropped image using ImageUploadService
     */
    public function saveCroppedImageWithPreset(string $preset = null, array $customOptions = [])
    {
        if (!$this->croppedImageData) {
            $this->addError('croppedImageData', 'No cropped image data available.');
            return null;
        }

        $this->isProcessingImage = true;
        $this->processingMessage = 'Saving cropped image...';

        try {
            $imageService = new ImageUploadService();
            
            // Create a temporary file from the cropped image data
            $croppedImagePath = $this->createTempFileFromBase64($this->croppedImageData);
            
            // Create UploadedFile instance from the cropped image
            $croppedFile = new UploadedFile(
                $croppedImagePath,
                'cropped-image.jpg',
                'image/jpeg',
                null,
                true
            );

            // Upload using preset or custom options
            if ($preset) {
                $result = $imageService->uploadWithPreset($croppedFile, $preset, $customOptions);
            } else {
                $options = array_merge([
                    'width' => $this->outputWidth,
                    'height' => $this->outputHeight,
                    'quality' => 90,
                    'format' => 'jpg',
                ], $customOptions);
                
                $result = $imageService->uploadImage($croppedFile, $options);
            }

            // Clean up temporary file
            unlink($croppedImagePath);

            // Clear cropped data
            $this->croppedImageData = null;
            $this->croppedImagePreview = null;
            
            $this->alert('success', 'Image cropped and saved successfully!');
            
            return $result;
            
        } catch (\Exception $e) {
            $this->addError('croppedImageData', 'Error saving cropped image: ' . $e->getMessage());
            return null;
        } finally {
            $this->isProcessingImage = false;
        }
    }

    /**
     * Clear cropped image data
     */
    public function clearCroppedImage()
    {
        $this->reset(['croppedImageData', 'croppedImagePreview']);
        $this->alert('info', 'Cropped image cleared. You can start over.');
    }

    /**
     * Create temporary file from base64 data
     */
    protected function createTempFileFromBase64($base64Data)
    {
        try {
            \Log::info('Creating temp file from base64', [
                'data_length' => strlen($base64Data),
                'has_data_prefix' => strpos($base64Data, 'data:') === 0
            ]);

            // Remove data URL prefix if present
            if (strpos($base64Data, 'data:') === 0) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            }

            $imageData = base64_decode($base64Data);
            
            if ($imageData === false) {
                throw new \Exception('Invalid base64 data provided');
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'cropped_image_');
            
            if ($tempPath === false) {
                throw new \Exception('Failed to create temporary file');
            }

            $bytesWritten = file_put_contents($tempPath, $imageData);
            
            if ($bytesWritten === false) {
                throw new \Exception('Failed to write image data to temporary file');
            }

            \Log::info('Temp file created successfully', [
                'path' => $tempPath,
                'size' => $bytesWritten
            ]);

            return $tempPath;
        } catch (\Exception $e) {
            \Log::error('Failed to create temp file from base64', [
                'error' => $e->getMessage(),
                'data_length' => strlen($base64Data)
            ]);
            throw new \Exception("Failed to process cropped image: " . $e->getMessage());
        }
    }

    /**
     * Get listeners for the cropper component
     */
    public function getListeners()
    {
        return [
            'imageCropped' => 'handleCroppedImage',
        ];
    }
}
