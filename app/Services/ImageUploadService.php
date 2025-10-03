<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Interfaces\ImageInterface;

class ImageUploadService
{
    protected ImageManager $imageManager;
    protected string $disk;
    protected string $basePath;

    // Predefined configurations for different use cases
    protected array $presets = [
        'homepage' => [
            'width' => 1920,
            'height' => 1080,
            'aspectRatio' => [16, 9],
            'quality' => 90,
            'format' => 'jpg',
            'path' => 'homepage-images',
        ],
        'product' => [
            'width' => 800,
            'height' => 800,
            'aspectRatio' => [1, 1],
            'quality' => 90,
            'format' => 'jpg',
            'path' => 'products',
        ],
        'variant' => [
            'width' => 600,
            'height' => 600,
            'aspectRatio' => [1, 1],
            'quality' => 90,
            'format' => 'jpg',
            'path' => 'shop/variants',
        ],
        'thumbnail' => [
            'width' => 300,
            'height' => 300,
            'aspectRatio' => [1, 1],
            'quality' => 85,
            'format' => 'jpg',
            'path' => 'thumbnails',
        ],
        'banner' => [
            'width' => 1200,
            'height' => 400,
            'aspectRatio' => [3, 1],
            'quality' => 90,
            'format' => 'jpg',
            'path' => 'banners',
        ],
    ];

    public function __construct(string $disk = 'public', string $basePath = 'images')
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->disk = $disk;
        $this->basePath = $basePath;
    }

    /**
     * Upload image using a predefined preset
     *
     * @param UploadedFile $file
     * @param string $preset
     * @param array $overrides
     * @return array
     */
    public function uploadWithPreset(UploadedFile $file, string $preset, array $overrides = []): array
    {
        if (!isset($this->presets[$preset])) {
            throw new \InvalidArgumentException("Preset '{$preset}' not found. Available presets: " . implode(', ', array_keys($this->presets)));
        }

        $presetOptions = $this->presets[$preset];
        $options = array_merge($presetOptions, $overrides);

        return $this->uploadImage($file, $options);
    }

    /**
     * Get preset configuration
     *
     * @param string $preset
     * @return array
     */
    public function getPreset(string $preset): array
    {
        if (!isset($this->presets[$preset])) {
            throw new \InvalidArgumentException("Preset '{$preset}' not found. Available presets: " . implode(', ', array_keys($this->presets)));
        }

        return $this->presets[$preset];
    }

    /**
     * Get all available presets
     *
     * @return array
     */
    public function getAvailablePresets(): array
    {
        return array_keys($this->presets);
    }

    /**
     * Upload and process an image with optional cropping
     *
     * @param UploadedFile $file
     * @param array $options
     * @return array
     */
    public function uploadImage(UploadedFile $file, array $options = []): array
    {
        $defaultOptions = [
            'width' => null,
            'height' => null,
            'crop' => false,
            'quality' => 90,
            'format' => 'jpg',
            'path' => $this->basePath,
            'filename' => null,
            'cropData' => null, // For CropperJS data: {x, y, width, height, rotate, scaleX, scaleY}
        ];

        $options = array_merge($defaultOptions, $options);

        // Generate filename if not provided
        $filename = $options['filename'] ?? $this->generateFilename($file, $options['format']);
        
        // Create full path
        $fullPath = $options['path'] . '/' . $filename;

        // Process the image
        $image = $this->processImage($file, $options);

        // Store the processed image
        $storedPath = $this->storeImage($image, $fullPath, $options['quality'], $options['format']);

        return [
            'path' => $storedPath,
            'filename' => $filename,
            'url' => asset('storage/' . $storedPath),
            'size' => Storage::disk($this->disk)->size($storedPath),
        ];
    }

    /**
     * Process image with cropping, resizing, etc.
     *
     * @param UploadedFile $file
     * @param array $options
     * @return ImageInterface
     */
    protected function processImage(UploadedFile $file, array $options): ImageInterface
    {
        $image = $this->imageManager->read($file->getPathname());

        // Apply crop data if provided (from CropperJS)
        if ($options['cropData']) {
            $image = $this->applyCropData($image, $options['cropData']);
        }

        // Resize if dimensions are specified
        if ($options['width'] || $options['height']) {
            $image = $this->resizeImage($image, $options);
        }

        return $image;
    }

    /**
     * Apply crop data from CropperJS
     *
     * @param ImageInterface $image
     * @param array $cropData
     * @return ImageInterface
     */
    protected function applyCropData(ImageInterface $image, array $cropData): ImageInterface
    {
        // Extract crop coordinates and dimensions
        $x = (int) $cropData['x'];
        $y = (int) $cropData['y'];
        $width = (int) $cropData['width'];
        $height = (int) $cropData['height'];
        $rotate = $cropData['rotate'] ?? 0;
        $scaleX = $cropData['scaleX'] ?? 1;
        $scaleY = $cropData['scaleY'] ?? 1;

        // Apply rotation if needed
        if ($rotate !== 0) {
            $image = $image->rotate($rotate);
        }

        // Apply scaling if needed
        if ($scaleX !== 1 || $scaleY !== 1) {
            $currentWidth = $image->width();
            $currentHeight = $image->height();
            $newWidth = (int) ($currentWidth * $scaleX);
            $newHeight = (int) ($currentHeight * $scaleY);
            $image = $image->resize($newWidth, $newHeight);
        }

        // Apply crop
        $image = $image->crop($width, $height, $x, $y);

        return $image;
    }

    /**
     * Resize image maintaining aspect ratio or forcing dimensions
     *
     * @param ImageInterface $image
     * @param array $options
     * @return ImageInterface
     */
    protected function resizeImage(ImageInterface $image, array $options): ImageInterface
    {
        $width = $options['width'];
        $height = $options['height'];
        $crop = $options['crop'];

        if ($crop && $width && $height) {
            // Crop to exact dimensions
            $image = $image->cover($width, $height);
        } elseif ($width && $height) {
            // Resize to fit within dimensions
            $image = $image->resize($width, $height);
        } elseif ($width) {
            // Resize by width, maintain aspect ratio
            $image = $image->resize($width, null);
        } elseif ($height) {
            // Resize by height, maintain aspect ratio
            $image = $image->resize(null, $height);
        }

        return $image;
    }

    /**
     * Store the processed image
     *
     * @param ImageInterface $image
     * @param string $path
     * @param int $quality
     * @param string $format
     * @return string
     */
    protected function storeImage(ImageInterface $image, string $path, int $quality, string $format): string
    {
        try {
            // Ensure directory exists
            $directory = dirname($path);
            if (!Storage::disk($this->disk)->exists($directory)) {
                Storage::disk($this->disk)->makeDirectory($directory);
            }

            // Encode image with specified format and quality
            $encodedImage = $image->toJpeg($quality);
            
            if ($format === 'png') {
                $encodedImage = $image->toPng();
            } elseif ($format === 'webp') {
                $encodedImage = $image->toWebp($quality);
            }

            // Store the image
            $stored = Storage::disk($this->disk)->put($path, $encodedImage);
            
            if (!$stored) {
                throw new \Exception("Failed to store image at path: {$path}");
            }

            return $path;
        } catch (\Exception $e) {
            \Log::error('ImageUploadService storeImage error', [
                'path' => $path,
                'format' => $format,
                'quality' => $quality,
                'error' => $e->getMessage(),
                'disk' => $this->disk
            ]);
            throw $e;
        }
    }

    /**
     * Generate a unique filename
     *
     * @param UploadedFile $file
     * @param string $format
     * @return string
     */
    protected function generateFilename(UploadedFile $file, string $format): string
    {
        $extension = $format === 'jpg' ? 'jpg' : $format;
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = \Illuminate\Support\Str::random(8);
        
        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Delete an image
     *
     * @param string $path
     * @return bool
     */
    public function deleteImage(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }
        
        return false;
    }

    /**
     * Get image dimensions
     *
     * @param string $path
     * @return array|null
     */
    public function getImageDimensions(string $path): ?array
    {
        if (!Storage::disk($this->disk)->exists($path)) {
            return null;
        }

        $image = $this->imageManager->read(Storage::disk($this->disk)->path($path));
        
        return [
            'width' => $image->width(),
            'height' => $image->height(),
        ];
    }

    /**
     * Create multiple sizes of an image
     *
     * @param UploadedFile $file
     * @param array $sizes
     * @param array $options
     * @return array
     */
    public function createMultipleSizes(UploadedFile $file, array $sizes, array $options = []): array
    {
        $results = [];
        
        foreach ($sizes as $sizeName => $sizeOptions) {
            $sizeOptions = array_merge($options, $sizeOptions);
            $sizeOptions['filename'] = $this->generateSizeFilename($file, $sizeName, $sizeOptions['format'] ?? 'jpg');
            
            $results[$sizeName] = $this->uploadImage($file, $sizeOptions);
        }
        
        return $results;
    }

    /**
     * Generate filename for different sizes
     *
     * @param UploadedFile $file
     * @param string $sizeName
     * @param string $format
     * @return string
     */
    protected function generateSizeFilename(UploadedFile $file, string $sizeName, string $format): string
    {
        $extension = $format === 'jpg' ? 'jpg' : $format;
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = \Illuminate\Support\Str::random(8);
        
        return "{$timestamp}_{$sizeName}_{$random}.{$extension}";
    }

    /**
     * Validate image file
     *
     * @param UploadedFile $file
     * @param array $rules
     * @return array
     */
    public function validateImage(UploadedFile $file, array $rules = []): array
    {
        $defaultRules = [
            'max_size' => 5 * 1024 * 1024, // 5MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
            'min_width' => null,
            'min_height' => null,
            'max_width' => null,
            'max_height' => null,
        ];

        $rules = array_merge($defaultRules, $rules);
        $errors = [];

        // Check file size
        if ($file->getSize() > $rules['max_size']) {
            $errors[] = "File size must be less than " . ($rules['max_size'] / 1024 / 1024) . "MB";
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $rules['allowed_types'])) {
            $errors[] = "File type must be one of: " . implode(', ', $rules['allowed_types']);
        }

        // Check dimensions if specified
        if ($rules['min_width'] || $rules['min_height'] || $rules['max_width'] || $rules['max_height']) {
            $image = $this->imageManager->read($file->getPathname());
            $width = $image->width();
            $height = $image->height();

            if ($rules['min_width'] && $width < $rules['min_width']) {
                $errors[] = "Image width must be at least {$rules['min_width']}px";
            }

            if ($rules['min_height'] && $height < $rules['min_height']) {
                $errors[] = "Image height must be at least {$rules['min_height']}px";
            }

            if ($rules['max_width'] && $width > $rules['max_width']) {
                $errors[] = "Image width must be at most {$rules['max_width']}px";
            }

            if ($rules['max_height'] && $height > $rules['max_height']) {
                $errors[] = "Image height must be at most {$rules['max_height']}px";
            }
        }

        return $errors;
    }
}
