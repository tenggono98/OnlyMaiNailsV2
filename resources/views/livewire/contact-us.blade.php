<div class="max-w-2xl mx-auto content-flow px-5" data-aos-skip>
    <h1 class="text-3xl font-semibold mb-4">Contact Us</h1>
    <p class="text-mute mb-6">Have questions? Send us a message below or DM <a class="underline" href="https://www.instagram.com/{{ getSettingWeb('instagram') }}/" target="_blank">{{ '@'.getSettingWeb('instagram') }}</a>.</p>

    <form wire:submit.prevent="submit" class="bg-white rounded-xl border border-brand-accent-light p-6 ux-card">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" wire:model.defer="name" class="w-full p-3 border border-brand-accent-light rounded-lg form-control" placeholder="Your name" />
                @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" wire:model.defer="email" class="w-full p-3 border border-brand-accent-light rounded-lg form-control" placeholder="you@example.com" />
                @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Message</label>
                <textarea wire:model.defer="message" rows="6" class="w-full p-3 border border-brand-accent-light rounded-lg form-control resize-y" placeholder="How can we help you?"></textarea>
                @error('message') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex items-center justify-between gap-3">
                <div class="">
                    <button type="submit" class="ux-btn bg-brand-accent-light px-6 py-3 rounded-lg font-medium">
                        Send Message
                    </button>
                </div>
                <div class="">
                <small class="text-mute">If you have any other questions, please DM {{ '@'.getSettingWeb('instagram') }} on Instagram.</small>

                </div>

            </div>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('contactSent', () => {
                if (window.Swal) {
                    Swal.fire({
                        title: 'Message sent',
                        text: 'Thanks! We\'ll get back to you soon.',
                        icon: 'success',
                        timer: 2200,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>
</div>
