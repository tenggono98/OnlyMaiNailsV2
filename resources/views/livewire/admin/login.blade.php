<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <img class="h-12 w-auto" src="{{ asset('img/logo.png') }}" alt="OnlyMaiNails">
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Admin Login
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sign in to your admin account
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="admin-card py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" wire:submit.prevent="login">
                <div>
                    <label for="email" class="admin-label">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" wire:model="email" required 
                               class="admin-input" placeholder="Enter your email">
                    </div>
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="admin-label">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" wire:model="password" required 
                               class="admin-input" placeholder="Enter your password">
                    </div>
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" wire:click="login" 
                            class="admin-btn-primary w-full">
                        <span wire:loading.remove wire:target="login">Sign in</span>
                        <span wire:loading wire:target="login">Signing in...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
