<?php

namespace App\Livewire\Admin;

use App\Models\HomepageImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class HomepageImages extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $images;
    
    #[Validate('required|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=1920,min_height=1080')]
    public $newImage;
    
    public $section = 'header';
    
    #[Validate('required|string|max:255')]
    public $altText;
    
    #[Validate('required|integer|min:1')]
    public $displayOrder;

    protected function rules()
    {
        return [
            'newImage' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=1920,min_height=1080',
            'altText' => 'required|string|max:255',
            'displayOrder' => 'required|integer|min:1'
        ];
    }

    public function mount()
    {
        $this->loadImages();
    }

    public function render()
    {
        return view('livewire.admin.homepage-images')->layout('components.layouts.app-admin');
    }

    public function loadImages()
    {
        $this->images = HomepageImage::where('section', $this->section)
            ->orderBy('display_order')
            ->get();
    }

    public function save()
    {
        $this->validate();

        $path = $this->newImage->store('homepage-images', 'public');

        HomepageImage::create([
            'image_path' => $path,
            'alt_text' => $this->altText,
            'section' => $this->section,
            'display_order' => $this->displayOrder,
            'status' => true
        ]);

        $this->reset(['newImage', 'altText', 'displayOrder']);
        $this->loadImages();
        $this->alert('success', 'Image added successfully');
    }

    public function toggleStatus($id)
    {
        $image = HomepageImage::find($id);
        if ($image) {
            $image->status = !$image->status;
            $image->save();
            $this->loadImages();
            $this->alert('success', 'Status updated successfully');
        }
    }

    public function delete($id)
    {
        $image = HomepageImage::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
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