@props([
    'error' => '',

])

 <div>
    @error( $error ) <span class="text-xs text-red-600">{{ $message }}</span> @enderror
</div>
