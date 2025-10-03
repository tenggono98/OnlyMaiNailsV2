<div>
    <!-- File Upload Input -->
    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium text-gray-900">
            Select Image
        </label>
        
        <!-- Upload Area -->
        <div class="relative">
            <!-- File Input -->
            <input type="file" 
                   wire:model="image" 
                   accept="image/*" 
                   id="image-upload"
                   class="hidden"
                   wire:loading.attr="disabled">
            
            <!-- Custom Upload Button -->
            <label for="image-upload" 
                   class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200 {{ $isUploading ? 'opacity-50 cursor-not-allowed' : '' }}">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <!-- Upload Icon -->
                    <svg class="w-8 h-8 mb-2 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    
                    <!-- Upload Text -->
                    <p class="mb-2 text-sm text-gray-500">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG, WEBP (MAX. 64MB)</p>
                </div>
            </label>
            
            <!-- Upload Loading Overlay -->
            <div wire:loading wire:target="image" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 rounded-lg">
                <div class="flex flex-col items-center space-y-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700">Uploading Image...</p>
                        <p class="text-xs text-gray-500">Please wait while we process your file</p>
                    </div>
                </div>
            </div>
        </div>
        
        @error('image') 
            <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @enderror
    </div>

    <!-- Cropper Modal -->
    <div x-data="cropperModal()" 
         x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         style="display: none;"
         wire:ignore>
            
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden" wire:ignore.self>
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Crop Image</h3>
                    <button @click="closeModal()" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <div class="mb-4">
                        <div id="cropper-container" class="max-h-96 overflow-hidden" wire:ignore>
                            <img id="cropper-image" 
                                 :src="imageUrl" 
                                 style="max-width: 100%; max-height: 400px;"
                                 alt="Image to crop">
                        </div>
                    </div>

                    <!-- Cropper Controls -->
                    <div class="flex flex-wrap gap-2 mb-4" wire:ignore>
                        <button type="button" 
                                class="cropper-rotate-left px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            ↺ Rotate Left
                        </button>
                        <button type="button" 
                                class="cropper-rotate-right px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            ↻ Rotate Right
                        </button>
                        <button type="button" 
                                class="cropper-flip-horizontal px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            ↔ Flip Horizontal
                        </button>
                        <button type="button" 
                                class="cropper-flip-vertical px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            ↕ Flip Vertical
                        </button>
                        <button type="button" 
                                class="cropper-reset px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            Reset
                        </button>
                        <button type="button" 
                                class="cropper-zoom-in px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            Zoom In
                        </button>
                        <button type="button" 
                                class="cropper-zoom-out px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            Zoom Out
                        </button>
                    </div>

                    <!-- Aspect Ratio Controls -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aspect Ratio</label>
                        <div class="flex flex-wrap gap-2" wire:ignore>
                            <button type="button" 
                                    class="aspect-ratio-btn px-3 py-1 bg-blue-100 hover:bg-blue-200 rounded text-sm"
                                    data-ratio="free">
                                Free
                            </button>
                            <button type="button" 
                                    class="aspect-ratio-btn px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm"
                                    data-ratio="1">
                                1:1
                            </button>
                            <button type="button" 
                                    class="aspect-ratio-btn px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm"
                                    data-ratio="16/9">
                                16:9
                            </button>
                            <button type="button" 
                                    class="aspect-ratio-btn px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm"
                                    data-ratio="4/3">
                                4:3
                            </button>
                            <button type="button" 
                                    class="aspect-ratio-btn px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm"
                                    data-ratio="3/2">
                                3:2
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 p-4 border-t bg-gray-50">
                    <button @click="closeModal()" 
                            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="button" 
                            id="crop-image-btn"
                            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            wire:ignore>
                        <span wire:loading.remove wire:target="processCroppedImage">Crop & Save</span>
                        <span wire:loading wire:target="processCroppedImage">Processing...</span>
                    </button>
                </div>
            </div>
        </div>

    <!-- Processing Overlay -->
    @if($isProcessing)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-700">Processing image...</p>
            </div>
        </div>
    @endif

    <!-- Include CropperJS CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <script>
        // Alpine.js component for cropper modal
        function cropperModal() {
            return {
                showModal: false,
                imageUrl: '',
                cropper: null,
                isInitialized: false,
                cropOptions: @json($cropOptions),
                outputWidth: @json($outputWidth),
                outputHeight: @json($outputHeight),
                outputQuality: @json($outputQuality),

                init() {
                    console.log('Alpine.js cropperModal initialized');
                    
                    // Watch for changes in Livewire properties
                    this.$watch('$wire.showCropper', (value) => {
                        console.log('showCropper changed to:', value);
                        if (value && this.$wire.uploadedImageUrl) {
                            console.log('Opening modal with URL:', this.$wire.uploadedImageUrl);
                            this.imageUrl = this.$wire.uploadedImageUrl;
                            this.showModal = true;
                            this.$nextTick(() => {
                                this.initCropper();
                            });
                        } else if (!value) {
                            console.log('Closing modal');
                            this.showModal = false;
                            this.destroyCropper();
                        }
                    });

                    // Check if modal should be shown on init
                    if (this.$wire.showCropper && this.$wire.uploadedImageUrl) {
                        console.log('Modal should be shown on init');
                        this.imageUrl = this.$wire.uploadedImageUrl;
                        this.showModal = true;
                        this.$nextTick(() => {
                            this.initCropper();
                        });
                    }
                },

                initCropper() {
                    const image = document.getElementById('cropper-image');
                    if (!image || this.cropper || this.isInitialized) return;

                    // Wait for image to load
                    if (image.complete) {
                        this.setupCropper();
                    } else {
                        image.onload = () => this.setupCropper();
                    }
                },

                setupCropper() {
                    const image = document.getElementById('cropper-image');
                    if (!image || this.cropper) return;

                    try {
                        console.log('Initializing cropper with options:', this.cropOptions);
                        this.cropper = new Cropper(image, {
                            aspectRatio: this.cropOptions.aspectRatio,
                            viewMode: this.cropOptions.viewMode,
                            dragMode: this.cropOptions.dragMode,
                            autoCropArea: this.cropOptions.autoCropArea,
                            background: this.cropOptions.background,
                            responsive: this.cropOptions.responsive,
                            restore: this.cropOptions.restore,
                            checkCrossOrigin: this.cropOptions.checkCrossOrigin,
                            checkOrientation: this.cropOptions.checkOrientation,
                            modal: this.cropOptions.modal,
                            guides: this.cropOptions.guides,
                            center: this.cropOptions.center,
                            highlight: this.cropOptions.highlight,
                            cropBoxMovable: this.cropOptions.cropBoxMovable,
                            cropBoxResizable: this.cropOptions.cropBoxResizable,
                            toggleDragModeOnDblclick: this.cropOptions.toggleDragModeOnDblclick,
                            minCropBoxWidth: this.cropOptions.minWidth,
                            minCropBoxHeight: this.cropOptions.minHeight,
                            maxCropBoxWidth: this.cropOptions.maxWidth,
                            maxCropBoxHeight: this.cropOptions.maxHeight,
                        });

                        this.isInitialized = true;
                        console.log('Cropper initialized successfully');
                        this.setupCropperControls();
                    } catch (error) {
                        console.error('Error initializing cropper:', error);
                    }
                },

                setupCropperControls() {
                    if (!this.cropper) return;

                    // Rotate buttons
                    document.querySelector('.cropper-rotate-left')?.addEventListener('click', () => {
                        this.cropper.rotate(-90);
                    });

                    document.querySelector('.cropper-rotate-right')?.addEventListener('click', () => {
                        this.cropper.rotate(90);
                    });

                    // Flip buttons
                    document.querySelector('.cropper-flip-horizontal')?.addEventListener('click', () => {
                        this.cropper.scaleX(-this.cropper.getData().scaleX);
                    });

                    document.querySelector('.cropper-flip-vertical')?.addEventListener('click', () => {
                        this.cropper.scaleY(-this.cropper.getData().scaleY);
                    });

                    // Reset button
                    document.querySelector('.cropper-reset')?.addEventListener('click', () => {
                        this.cropper.reset();
                    });

                    // Zoom buttons
                    document.querySelector('.cropper-zoom-in')?.addEventListener('click', () => {
                        this.cropper.zoom(0.1);
                    });

                    document.querySelector('.cropper-zoom-out')?.addEventListener('click', () => {
                        this.cropper.zoom(-0.1);
                    });

                    // Aspect ratio buttons
                    document.querySelectorAll('.aspect-ratio-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const ratio = btn.dataset.ratio;
                            
                            // Update button states
                            document.querySelectorAll('.aspect-ratio-btn').forEach(b => {
                                b.classList.remove('bg-blue-100', 'hover:bg-blue-200');
                                b.classList.add('bg-gray-200', 'hover:bg-gray-300');
                            });
                            btn.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            btn.classList.add('bg-blue-100', 'hover:bg-blue-200');

                            // Set aspect ratio
                            if (ratio === 'free') {
                                this.cropper.setAspectRatio(NaN);
                            } else {
                                this.cropper.setAspectRatio(eval(ratio));
                            }
                        });
                    });

                    // Crop button
                    document.getElementById('crop-image-btn')?.addEventListener('click', () => {
                        if (!this.cropper) return;

                        const canvas = this.cropper.getCroppedCanvas({
                            width: this.outputWidth,
                            height: this.outputHeight,
                            imageSmoothingEnabled: true,
                            imageSmoothingQuality: 'high',
                        });

                        if (canvas) {
                            const dataURL = canvas.toDataURL('image/jpeg', this.outputQuality);
                            
                            // Send to Livewire
                            this.$wire.call('handleImageSelected', {
                                data: dataURL,
                                filename: 'cropped-image.jpg'
                            });
                            
                            // Close modal after sending data
                            this.closeModal();
                        }
                    });
                },

                closeModal() {
                    this.showModal = false;
                    this.destroyCropper();
                    // Reset Livewire state
                    this.$wire.set('showCropper', false);
                    this.$wire.set('uploadedImageUrl', null);
                    this.$wire.set('image', null);
                },

                destroyCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                        this.isInitialized = false;
                    }
                }
            }
        }

        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.querySelector('label[for="image-upload"]');
            const fileInput = document.getElementById('image-upload');

            if (uploadArea && fileInput) {
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                // Highlight drop area when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, unhighlight, false);
                });

                // Handle dropped files
                uploadArea.addEventListener('drop', handleDrop, false);

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                function highlight(e) {
                    uploadArea.classList.add('border-blue-400', 'bg-blue-50');
                }

                function unhighlight(e) {
                    uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
                }

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    if (files.length > 0) {
                        fileInput.files = files;
                        // Trigger Livewire update
                        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            }
        });
    </script>
</div>
