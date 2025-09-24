<?php

namespace App\Livewire\Admin;

use App\Models\HomepageImage;
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

    #[Validate('image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=1920,min_height=1080')]
    public $newImage;

    public $section = 'header';

    #[Validate('required|string|max:255')]
    public $altText;

    #[Validate('required|integer|min:1')]
    public $displayOrder;

    protected function rules()
    {
        return [
            'newImage' => 'image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=1920,min_height=1080',
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

        $path = $this->newImage->store('homepage-images', 'public');

        HomepageImage::create([
            'image_path' => $path,
            'alt_text' => $this->altText,
            'section' => $this->section,
            'display_order' => $this->displayOrder,
            'status' => '1'
        ]);

        $this->reset(['newImage', 'altText', 'displayOrder']);
        $this->loadImages();
        $this->alert('success', 'Image added successfully');
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
