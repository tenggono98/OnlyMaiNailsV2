# Image Cropper Implementation Guide

## Overview

The Image Cropper system provides a comprehensive solution for uploading, cropping, and processing images across the application. It consists of reusable components, services, and traits that can be easily integrated into any Livewire component.

## Architecture

### Core Components

1. **ImageCropper Component** (`app/Livewire/Component/ImageCropper.php`)
   - Interactive image cropping interface using CropperJS
   - Handles file upload, validation, and cropping operations
   - Emits events for parent components

2. **ImageUploadService** (`app/Services/ImageUploadService.php`)
   - Centralized image processing and storage
   - Supports predefined presets for different use cases
   - Handles resizing, quality optimization, and format conversion

3. **HasImageCropper Trait** (`app/Livewire/Traits/HasImageCropper.php`)
   - Reusable functionality for Livewire components
   - Standardizes image cropping workflow
   - Provides common methods and properties

## Available Presets

The ImageUploadService includes predefined configurations:

| Preset | Dimensions | Aspect Ratio | Use Case |
|--------|------------|--------------|----------|
| `homepage` | 1920x1080 | 16:9 | Homepage banners and hero images |
| `product` | 800x800 | 1:1 | Product thumbnails |
| `variant` | 600x600 | 1:1 | Product variant images |
| `thumbnail` | 300x300 | 1:1 | Small thumbnails |
| `banner` | 1200x400 | 3:1 | Marketing banners |

## Implementation Guide

### 1. Basic Implementation

To add image cropping to a new Livewire component:

```php
<?php

namespace App\Livewire\YourComponent;

use App\Livewire\Traits\HasImageCropper;
use Livewire\Component;

class YourComponent extends Component
{
    use HasImageCropper;
    
    public function mount()
    {
        // Use a preset
        $this->usePreset('product');
        
        // Or set custom dimensions
        $this->setCropDimensions(800, 600, [4, 3]);
    }
    
    public function saveCroppedImage()
    {
        // Validate your form fields
        $this->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);
        
        // Save the cropped image
        $result = $this->saveCroppedImageWithPreset('product');
        
        if ($result) {
            // Create your model record
            YourModel::create([
                'title' => $this->title,
                'description' => $this->description,
                'image_path' => $result['path'],
            ]);
            
            // Reset form
            $this->reset(['title', 'description']);
        }
    }
}
```

### 2. Blade Template Integration

```blade
<!-- Upload Options -->
<div class="mb-4 p-3 bg-gray-50 rounded-lg">
    <div class="flex items-center space-x-4">
        <label class="flex items-center">
            <input type="radio" wire:model="useCropper" value="true" class="mr-2">
            <span class="text-sm font-medium text-gray-700">Use Image Cropper (Recommended)</span>
        </label>
        <label class="flex items-center">
            <input type="radio" wire:model="useCropper" value="false" class="mr-2">
            <span class="text-sm font-medium text-gray-700">Direct Upload</span>
        </label>
    </div>
    <p class="text-xs text-gray-500 mt-2">
        Image Cropper allows you to crop and resize images to the perfect dimensions ({{ $outputWidth }}x{{ $outputHeight }}px)
    </p>
</div>

@if($useCropper)
    <!-- Image Cropper Component -->
    <div class="space-y-4">
        <livewire:component.image-cropper 
            :crop-options="$cropOptions"
            :output-width="$outputWidth"
            :output-height="$outputHeight"
            :output-format="'jpg'"
            :output-quality="0.9"
            wire:key="your-component-cropper-{{ now()->timestamp }}"
        />
        
        <!-- Show cropped image preview if available -->
        @if($croppedImagePreview)
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-green-800">Image Cropped Successfully!</h4>
                        <p class="text-sm text-green-700">Your image has been cropped and is ready to be saved.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ $croppedImagePreview }}" alt="Cropped preview" class="w-16 h-16 object-cover rounded">
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <button type="button" wire:click="clearCroppedImage" 
                    class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Clear & Start Over
            </button>
            <button type="button" wire:click="saveCroppedImage" 
                    class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ !$croppedImagePreview ? 'disabled' : '' }}>
                Save Image
            </button>
        </div>
    </div>
@else
    <!-- Direct Upload Form -->
    <div class="space-y-3">
        <input type="file" wire:model="image" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
        <button type="button" wire:click="saveDirectUpload" class="px-4 py-2 bg-blue-600 text-white rounded-md">
            Upload Image
        </button>
    </div>
@endif
```

### 3. Multiple Images Implementation

For components that handle multiple images (like VariantImages):

```php
public function handleCroppedImage($imageData = null)
{
    // Store multiple cropped images
    $this->croppedImages[] = [
        'data' => $imageDataString,
        'filename' => $filename,
        'preview' => $imageDataString
    ];
}

public function saveAllCroppedImages()
{
    foreach ($this->croppedImages as $croppedImage) {
        $result = $this->saveCroppedImageWithPreset('variant');
        // Process each result...
    }
}
```

## API Reference

### HasImageCropper Trait Methods

#### `usePreset(string $preset)`
Sets crop dimensions and options using a predefined preset.

```php
$this->usePreset('homepage'); // Sets 1920x1080 with 16:9 aspect ratio
```

#### `setCropDimensions(int $width, int $height, array $aspectRatio = null)`
Sets custom crop dimensions and aspect ratio.

```php
$this->setCropDimensions(800, 600, [4, 3]); // 800x600 with 4:3 aspect ratio
```

#### `handleCroppedImage($imageData)`
Handles cropped image data from the cropper component.

#### `saveCroppedImageWithPreset(string $preset, array $overrides = [])`
Saves the cropped image using a preset configuration.

```php
$result = $this->saveCroppedImageWithPreset('product', ['quality' => 95]);
```

#### `clearCroppedImage()`
Clears the current cropped image data.

### ImageUploadService Methods

#### `uploadWithPreset(UploadedFile $file, string $preset, array $overrides = [])`
Uploads an image using a predefined preset.

```php
$imageService = new ImageUploadService();
$result = $imageService->uploadWithPreset($file, 'homepage');
```

#### `getPreset(string $preset)`
Gets the configuration for a specific preset.

```php
$config = $imageService->getPreset('product');
// Returns: ['width' => 800, 'height' => 800, 'aspectRatio' => [1, 1], ...]
```

#### `getAvailablePresets()`
Gets all available preset names.

```php
$presets = $imageService->getAvailablePresets();
// Returns: ['homepage', 'product', 'variant', 'thumbnail', 'banner']
```

## Customization

### Adding New Presets

To add a new preset, modify the `$presets` array in `ImageUploadService`:

```php
protected array $presets = [
    // ... existing presets
    'custom' => [
        'width' => 1200,
        'height' => 800,
        'aspectRatio' => [3, 2],
        'quality' => 90,
        'format' => 'jpg',
        'path' => 'custom-images',
    ],
];
```

### Custom Crop Options

Override the `setupCropOptions()` method in your component:

```php
protected function setupCropOptions()
{
    parent::setupCropOptions();
    
    // Add custom options
    $this->cropOptions['minWidth'] = 200;
    $this->cropOptions['minHeight'] = 200;
    $this->cropOptions['guides'] = false;
}
```

## Error Handling

The system includes comprehensive error handling:

- **File validation**: Size, type, and format validation
- **Storage errors**: Graceful handling of storage failures
- **Processing errors**: Image processing error recovery
- **User feedback**: Clear error messages and loading states

## Performance Considerations

- **Lazy loading**: Cropper components load only when needed
- **Memory management**: Efficient handling of large images
- **Temporary files**: Automatic cleanup of temporary files
- **Optimized processing**: Quality and format optimization

## Browser Support

- **Modern browsers**: Full support for all features
- **Mobile devices**: Touch-friendly interface
- **Fallback**: Direct upload option for unsupported browsers

## Security

- **File validation**: Strict file type and size validation
- **Path sanitization**: Secure file path handling
- **Access control**: Proper permission checks
- **XSS protection**: Safe image URL generation

## Troubleshooting

### Common Issues

1. **Modal not opening**: Check if `wire:ignore` is properly set
2. **Cropper not initializing**: Ensure Alpine.js is loaded
3. **Image not saving**: Verify file permissions and storage configuration
4. **Memory errors**: Check PHP memory limits for large images

### Debug Mode

Enable debug logging by adding to your component:

```php
public function handleCroppedImage($imageData = null)
{
    \Log::info('Cropped image data received', ['data' => $imageData]);
    // ... rest of method
}
```

## Examples

### Complete Implementation Example

See the following files for complete implementation examples:

- `app/Livewire/Admin/HomepageImages.php` - Single image with form fields
- `app/Livewire/Admin/Shop/Products.php` - Product image upload
- `app/Livewire/Admin/Shop/VariantImages.php` - Multiple images upload

## Migration Guide

To migrate existing image upload components:

1. Add the `HasImageCropper` trait
2. Update the blade template with the cropper component
3. Replace direct upload logic with cropper methods
4. Test the new functionality

## Support

For issues or questions about the image cropper implementation, refer to:

- Component source code in `app/Livewire/Component/ImageCropper.php`
- Service implementation in `app/Services/ImageUploadService.php`
- Trait functionality in `app/Livewire/Traits/HasImageCropper.php`

