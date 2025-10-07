<div>
    {{-- Hero Section --}}
    <div class="relative py-16 xl:py-0 mb-16 xl:mb-20" data-aos="fade-up">
        {{-- Hero Content Container --}}
        <div class="w-full  mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 xl:gap-20 items-center">
                
                {{-- Left Column - Content --}}
                <div class="text-center lg:text-left order-last lg:order-first" data-aos="fade-right" data-aos-delay="100">
                    {{-- Badge --}}
                    <div class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 rounded-full bg-[#efcabe] bg-opacity-10 text-[#efcabe] text-xs sm:text-sm font-medium mb-4 sm:mb-6 transition-all duration-300 hover:bg-opacity-20 hover:scale-105 hover:shadow-lg cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Premium Nail Care Services
                    </div>
                    
                    {{-- Main Headline --}}
                    <h1 class="julius-sans-one-regular text-4xl sm:text-5xl lg:text-6xl xl:text-7xl 2xl:text-8xl font-bold tracking-[8%] mb-6 sm:mb-8 text-gray-900 leading-tight" data-aos="fade-up" data-aos-delay="300">
                        ONLYMAINAILS
                    </h1>
                    
                    {{-- Subtitle --}}
                    <p class="text-lg sm:text-xl lg:text-xl xl:text-2xl text-gray-600 mb-8 sm:mb-10 lg:mb-12 leading-relaxed max-w-2xl mx-auto lg:mx-0" data-aos="fade-up" data-aos-delay="400">
                        Experience luxury nail care with our expert technicians, premium products, and personalized service in a clean, welcoming environment.
                    </p>
                    
                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-6 justify-center lg:justify-start mb-8 sm:mb-10 lg:mb-12" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('book') }}" 
                           class="group bg-gray-900 hover:bg-gray-800 text-white px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 rounded-xl sm:rounded-2xl text-base sm:text-lg lg:text-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:-translate-y-1 flex items-center justify-center gap-2 sm:gap-3 shadow-lg">
                            <span class="transition-all duration-300 group-hover:text-white">Book Appointment</span>
                            <span class="transition-all duration-300 group-hover:translate-x-1 group-hover:scale-110">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </a>
                        
                        <a href="{{ route('services') }}" 
                           class="group border-2 border-gray-300 hover:border-gray-900 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 rounded-xl sm:rounded-2xl text-base sm:text-lg lg:text-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 hover:shadow-xl flex items-center justify-center gap-2 sm:gap-3">
                            <span class="transition-all duration-300 group-hover:text-gray-900">View Services</span>
                            <span class="transition-all duration-300 group-hover:translate-x-1 group-hover:scale-110">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                    
                    {{-- Trust Indicators --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 xl:gap-8" data-aos="fade-up" data-aos-delay="600">
                        <div class="group flex flex-col items-center xl:items-start space-y-2 p-4 rounded-xl transition-all duration-300 hover:bg-[#efcabe] hover:bg-opacity-5 hover:scale-105 hover:shadow-lg cursor-pointer">
                            <div class="w-12 h-12 bg-[#efcabe] bg-opacity-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:bg-opacity-20 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-6 h-6 text-[#efcabe] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 transition-all duration-300 group-hover:text-[#efcabe]">Licensed Technicians</h3>
                            <p class="text-sm text-gray-600 text-center xl:text-left transition-all duration-300 group-hover:text-gray-700">Certified professionals</p>
                        </div>
                        <div class="group flex flex-col items-center xl:items-start space-y-2 p-4 rounded-xl transition-all duration-300 hover:bg-[#efcabe] hover:bg-opacity-5 hover:scale-105 hover:shadow-lg cursor-pointer">
                            <div class="w-12 h-12 bg-[#efcabe] bg-opacity-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:bg-opacity-20 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-6 h-6 text-[#efcabe] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 transition-all duration-300 group-hover:text-[#efcabe]">Premium Products</h3>
                            <p class="text-sm text-gray-600 text-center xl:text-left transition-all duration-300 group-hover:text-gray-700">High-quality materials</p>
                        </div>
                        <div class="group flex flex-col items-center xl:items-start space-y-2 p-4 rounded-xl transition-all duration-300 hover:bg-[#efcabe] hover:bg-opacity-5 hover:scale-105 hover:shadow-lg cursor-pointer">
                            <div class="w-12 h-12 bg-[#efcabe] bg-opacity-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:bg-opacity-20 group-hover:scale-110 group-hover:rotate-3">
                                <svg class="w-6 h-6 text-[#efcabe] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 transition-all duration-300 group-hover:text-[#efcabe]">Clean Environment</h3>
                            <p class="text-sm text-gray-600 text-center xl:text-left transition-all duration-300 group-hover:text-gray-700">Sanitized & safe</p>
                        </div>
                    </div>
                </div>
                
                {{-- Right Column - Hero Image --}}
                <div class="relative order-first lg:order-last" data-aos="fade-left" data-aos-delay="200">
                    <div class="relative w-full max-w-sm mx-auto lg:max-w-md xl:max-w-lg">
                        {{-- Main Hero Image --}}
                        <div class="group relative aspect-[3/4] sm:aspect-[2/3] lg:aspect-[3/4] xl:aspect-[2/3] bg-gradient-to-br from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] rounded-2xl lg:rounded-3xl shadow-xl lg:shadow-2xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-3xl hover:rotate-1 cursor-pointer">
                            {{-- Professional placeholder content --}}
                            <div class="absolute inset-0 flex items-center justify-center p-3 sm:p-4 lg:p-6 transition-all duration-500 group-hover:scale-110">
                                <div class="text-center">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 xl:w-24 xl:h-24 mx-auto mb-3 sm:mb-4 bg-white bg-opacity-20 rounded-lg lg:rounded-xl flex items-center justify-center backdrop-blur-sm transition-all duration-500 group-hover:bg-opacity-30 group-hover:scale-110 group-hover:rotate-6">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10 xl:w-12 xl:h-12 text-white transition-all duration-500 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-white text-sm sm:text-base lg:text-lg xl:text-lg font-semibold mb-1 transition-all duration-500 group-hover:scale-105">Professional Nail Art</h3>
                                    <p class="text-white text-xs sm:text-sm lg:text-sm opacity-90 transition-all duration-500 group-hover:opacity-100">Premium nail care services</p>
                                </div>
                            </div>
                            {{-- Subtle overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Hero Section End --}}
    
    <div class="" data-aos="fade-up">
        {{-- Header Title --}}
        {{-- <div class="mb-10 hidden xl:block">
            <h1 class=" title-h1 julius-sans-one-regular xl:text-center z-30 tracking-[15%] mb-3 ">
                ONLYMAINAILS</h1>
            <p class="xl:text-xl text-xl xl:text-center tracking-[15%]">Thank you for choosing Onlymainails</p>
        </div> --}}
        {{-- Header Title --}}
        {{-- Container - Image --}}
        {{-- JavaScript Randomized Grid Layout --}}
        <div class="mb-10 hidden xl:block" data-aos="fade-up" data-aos-delay="60">
            <div id="randomized-grid" class="relative w-full min-h-[600px]">
                {{-- Images will be positioned by JavaScript --}}
                @foreach($headerImages as $index => $image)
                    <div class="grid-item absolute transition-all duration-500 opacity-0" data-index="{{ $index }}">
                        @if($image && $image->image_path)
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 group-hover:scale-[1.02] w-full h-full">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->alt_text ?? 'Nail art showcase' }}" 
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110" 
                                    loading="lazy">
                                {{-- Overlay on hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-4">
                                    <div class="text-white">
                                        <h3 class="font-semibold text-lg mb-1">{{ $image->alt_text ?? 'Professional Nail Art' }}</h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg bg-gradient-to-br from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] w-full h-full flex items-center justify-center group-hover:scale-[1.02] transition-all duration-500">
                                <div class="text-center p-6">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-[#efcabe]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-[#efcabe] font-semibold text-lg mb-2">Nail Art Gallery</h3>
                                    <p class="text-gray-600 text-sm">Professional nail designs</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                
                {{-- Add placeholder items if needed --}}
                @if(count($headerImages) < 12)
                    @for($i = count($headerImages); $i < 12; $i++)
                        <div class="grid-item absolute transition-all duration-500 opacity-0" data-index="{{ $i }}" data-placeholder="true">
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg bg-gradient-to-br from-[#efcabe]/20 via-[#f5e6e1]/20 to-[#faf7f5]/20 border-2 border-dashed border-[#efcabe]/30 w-full h-full flex items-center justify-center group-hover:scale-[1.02] transition-all duration-500">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-[#efcabe]/50 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-[#efcabe]/50 text-xs">More coming soon</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
        {{-- Desktop --}}
        {{-- Mobile - Modern Grid Layout --}}
        <div class="mb-10 xl:hidden" data-aos="fade-up">
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                @foreach($headerImages as $index => $image)
                    @php
                        // Create varied heights for mobile grid
                        $heights = ['h-48', 'h-56', 'h-40', 'h-52'];
                        $height = $heights[$index % count($heights)];
                        
                        // Staggered animation delays
                        $delay = 120 + ($index * 60);
                    @endphp
                    
                    <div class="group {{ $index === 0 ? 'col-span-2' : '' }}" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
                        @if($image && $image->image_path)
                            <div class="relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 group-hover:scale-[1.02] {{ $height }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->alt_text ?? 'Nail art showcase' }}" 
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110" 
                                    loading="lazy">
                                {{-- Subtle overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-3">
                                    <div class="text-white">
                                        <h3 class="font-semibold text-sm">{{ $image->alt_text ?? 'Professional Nail Art' }}</h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="relative overflow-hidden rounded-xl shadow-lg bg-gradient-to-br from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] {{ $height }} flex items-center justify-center group-hover:scale-[1.02] transition-all duration-500">
                                <div class="text-center p-4">
                                    <div class="w-12 h-12 mx-auto mb-3 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-[#efcabe]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-[#efcabe] font-semibold text-sm mb-1">Nail Art Gallery</h3>
                                    <p class="text-gray-600 text-xs">Professional designs</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                
                {{-- Add placeholder cards if needed --}}
                @if(count($headerImages) < 4)
                    @for($i = count($headerImages); $i < 4; $i++)
                        <div class="group" data-aos="zoom-in" data-aos-delay="{{ 120 + ($i * 60) }}">
                            <div class="h-40 bg-gradient-to-br from-[#efcabe]/20 via-[#f5e6e1]/20 to-[#faf7f5]/20 rounded-xl border-2 border-dashed border-[#efcabe]/30 flex items-center justify-center group-hover:scale-[1.02] transition-all duration-500">
                                <div class="text-center">
                                    <svg class="w-6 h-6 text-[#efcabe]/50 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-[#efcabe]/50 text-xs">More coming soon</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
        {{-- Mobile --}}
        {{-- Container - Image --}}
        {{-- Container - Promo --}}
        <div id="promo-carousel" class="relative w-full xl:mb-10 mb-10 h-[12rem] sm:h-[14rem] md:h-[16rem] xl:h-[9rem] 2xl:h-[10rem]" data-carousel="static" data-aos="fade-up" data-aos-delay="100">
            <!-- Carousel wrapper -->
            <div class="relative h-[12rem] sm:h-[14rem] md:h-[16rem] xl:h-[9rem] 2xl:h-[10rem] overflow-hidden rounded-lg">
                @if(count($promoImages) > 0)
                    @foreach($promoImages as $index => $image)
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                        @if($image && $image->image_path)
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                                alt="{{ $image->alt_text ?? 'Promotional offer' }}"
                                loading="lazy">
                        @else
                            <div class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 bg-gradient-to-r from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] flex items-center justify-center">
                                <div class="text-center p-4">
                                    <div class="w-12 h-12 mx-auto mb-3 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-[#efcabe]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-[#efcabe] font-semibold text-sm sm:text-base">Special Offer</h3>
                                    <p class="text-gray-600 text-xs sm:text-sm">Limited time promotion</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endforeach
                @else
                    {{-- Fallback when no promo images are available --}}
                    <div class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 bg-gradient-to-r from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] flex items-center justify-center">
                        <div class="text-center p-4">
                            <div class="w-12 h-12 mx-auto mb-3 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#efcabe]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-[#efcabe] font-semibold text-sm sm:text-base">Promotions Coming Soon</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Stay tuned for special offers</p>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Slider indicators -->
            @if(count($promoImages) > 1)
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-3 left-1/2">
                @foreach($promoImages as $index => $image)
                <button type="button" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Promo slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}">
                </button>
                @endforeach
            </div>
            @endif
            <!-- Slider controls -->
            @if(count($promoImages) > 1)
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-2 sm:px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none transition-all duration-300">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-2 sm:px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none transition-all duration-300">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
            @endif
        </div>
        {{-- Container - Promo --}}
        {{-- About Us --}}
        <div class="xl:mb-10 mb-40  align-middle" data-aos="fade-up">
            <div class="grid xl:grid-cols-2 grid-cols-1 gap-10">
                <div class="" data-aos="fade-right">
                    {{-- Img --}}
                    @if(file_exists(public_path('img/0V9A9946.jpg')))
                        <img src="{{ asset('img/0V9A9946.jpg') }}"
                            class="mx-auto rounded-xl w-full xl:h-[42rem] object-cover shadow-md transition-all duration-500 hover:scale-105 hover:shadow-xl" 
                            alt="Owner & CEO of OnlyMaiNails"
                            loading="lazy">
                    @else
                        <div class="mx-auto rounded-xl w-full xl:h-[42rem] bg-gradient-to-br from-[#efcabe] via-[#f5e6e1] to-[#faf7f5] shadow-md flex items-center justify-center transition-all duration-500 hover:scale-105 hover:shadow-xl">
                            <div class="text-center p-8">
                                <div class="w-20 h-20 mx-auto mb-6 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-[#efcabe]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-[#efcabe] font-semibold text-xl mb-2">Meet Our Founder</h3>
                                <p class="text-gray-600 text-base">Professional nail care expert</p>
                            </div>
                        </div>
                    @endif
                    {{-- Img --}}
                    {{-- Caption  --}}
                    <small class="font-thin italic">Owner & CEO of OnlyMaiNails</small>
                    {{-- Caption  --}}
                </div>
                <div class="xl:py-10 " data-aos="fade-left" data-aos-delay="60">
                    <h1 class=" julius-sans-one-regular mb-10 title-h1">About Our Studio</h1>
                    <div class="mb-10">
                        <p class="mb-10">
                            At Only Mai Nails we are dedicated to providing our clients with the best possible nail care
                            experience. Our team of highly skilled and licensed technicians is passionate about what
                            they do and committed to delivering exceptional service in a clean and welcoming
                            environment. We believe that healthy nails are the foundation of beauty and wellness, and we
                            strive to help our clients achieve the perfect balance of both.
                        </p>
                        <p>
                            From basic manicures to the latest trends in nail art and design, we offer a wide range of
                            services to suit every need and budget. At Only Mai Nails we pride ourselves on using only
                            the highest quality products and techniques to ensure that our clients receive the best
                            possible results. Come and experience the ultimate in nail care at Only Mai Nails – we look
                            forward to seeing you soon!
                        </p>
                    </div>
                    <div class="">
                        <button
                            class="xl:text-4xl text-xl underline underline-offset-4 relative group flex items-center gap-2 bg-white ">
                            <span>Book Now</span>
                            <span class="transition-transform duration-300 group-hover:translate-x-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- About Us --}}
        {{-- LOCATION --}}
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-10 mb-36" data-aos="fade-up">
            <div class="relative" data-aos="fade-right">
                <div class="absolute bottom-0 left-0 -z-10">
                    <svg width="112" height="111" viewBox="0 0 112 111" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.6405 31.4043C13.1094 31.4043 13.6084 31.421 14.2086 31.4577L14.4561 31.4744L37.1 36.9769L31.5787 14.4109L31.5639 14.1642C31.5252 13.5713 31.5087 13.0724 31.5087 12.5994C31.5087 12.06 31.5309 11.528 31.5676 10.9977C26.1371 10.3553 20.4775 12.104 16.3106 16.2572C12.1451 20.4086 10.3906 26.051 11.0351 31.4616C11.5652 31.4282 12.099 31.4043 12.6405 31.4043Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M97.1653 31.4575C97.7675 31.4209 98.2626 31.4042 98.7355 31.4042C99.273 31.4042 99.8068 31.4281 100.339 31.4632C100.985 26.0508 99.2305 20.4083 95.0617 16.257C90.8965 12.1041 85.2351 10.3552 79.8046 10.9976C79.8398 11.5278 79.8657 12.0599 79.8657 12.5992C79.8657 13.0797 79.8472 13.5935 79.8102 14.1695L79.7918 14.4125L74.2725 36.9768L96.9163 31.4742L97.1653 31.4575Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M98.7357 79.5976C98.2519 79.5976 97.7492 79.5811 97.1564 79.5425L96.9106 79.5258L74.2725 74.0253L79.7918 96.5893L79.8102 96.8323C79.8472 97.4068 79.8657 97.9221 79.8657 98.4045C79.8657 98.9422 79.8398 99.4722 79.8046 100.003C85.2351 100.647 90.8965 98.8979 95.0617 94.7448C99.2268 90.5918 100.982 84.9512 100.337 79.5388C99.807 79.5735 99.2732 79.5976 98.7357 79.5976Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M14.2177 79.5423C13.623 79.5809 13.1242 79.5974 12.6405 79.5974C12.0993 79.5974 11.5654 79.5752 11.0351 79.5386C10.3906 84.9509 12.1451 90.5916 16.3106 94.7445C20.4775 98.8977 26.1371 100.646 31.5676 100.002C31.5343 99.472 31.5087 98.9419 31.5087 98.4043C31.5087 97.9275 31.5252 97.4285 31.5639 96.834L31.5787 96.589L37.0998 74.025L14.4616 79.5258L14.2177 79.5423Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M92.9004 37.089C92.4958 37.089 92.0952 37.1074 91.696 37.1332L68.4483 42.7829L74.1153 19.6132C74.1432 19.2156 74.1579 18.8143 74.1579 18.413C74.1577 8.2437 65.8863 0 55.6867 0C45.4852 0 37.2137 8.2437 37.2137 18.413C37.2137 18.8143 37.232 19.2156 37.2561 19.6132L42.9231 42.7829L19.6792 37.1332C19.2783 37.1074 18.8795 37.089 18.473 37.089C8.27143 37.089 0 45.3327 0 55.5C0 65.6693 8.27143 73.913 18.473 73.913C18.8756 73.913 19.2783 73.8946 19.6792 73.867L42.9231 68.219L37.2561 91.3888C37.2322 91.7866 37.2137 92.1859 37.2137 92.589C37.2137 102.756 45.4849 111 55.6867 111C65.8863 111 74.1577 102.757 74.1577 92.589C74.1577 92.1859 74.1429 91.7864 74.1151 91.3888L68.4481 68.219L91.6958 73.867C92.093 73.8946 92.4956 73.913 92.9002 73.913C103.102 73.913 111.371 65.6695 111.371 55.5C111.371 45.3327 103.104 37.089 92.9004 37.089ZM55.6847 65.8698C49.9384 65.8698 45.28 61.2271 45.28 55.5C45.28 49.7711 49.9386 45.1284 55.6847 45.1284C61.4329 45.1284 66.0912 49.7714 66.0912 55.5C66.0912 61.2271 61.4329 65.8698 55.6847 65.8698Z"
                            fill="#efcabe" fill-opacity="0.5" />
                    </svg>
                </div>
                <h1
                    class="xl:text-5xl text-2xl julius-sans-one-regular z-30 tracking-[15%] mb-3 text-left bottom-0 absolute">
                    Location</h1>
            </div>
            <div class="" data-aos="fade-left" data-aos-delay="60">
                <iframe
                    src="{{ $data_homepage['gmapsLinks'] }}"
                    class="w-full min-h-[25rem]" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h1>{{ $data_homepage['address'] }}</h1>
            </div>
        </div>
        {{-- LOCATION --}}
        {{-- Contact Us --}}
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-10 mb-36" data-aos="fade-up">
            <div class="relative" data-aos="fade-right">
                <div class="absolute bottom-0 left-0 -z-10">
                    <svg width="112" height="111" viewBox="0 0 112 111" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.6405 31.4043C13.1094 31.4043 13.6084 31.421 14.2086 31.4577L14.4561 31.4744L37.1 36.9769L31.5787 14.4109L31.5639 14.1642C31.5252 13.5713 31.5087 13.0724 31.5087 12.5994C31.5087 12.06 31.5309 11.528 31.5676 10.9977C26.1371 10.3553 20.4775 12.104 16.3106 16.2572C12.1451 20.4086 10.3906 26.051 11.0351 31.4616C11.5652 31.4282 12.099 31.4043 12.6405 31.4043Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M97.1653 31.4575C97.7675 31.4209 98.2626 31.4042 98.7355 31.4042C99.273 31.4042 99.8068 31.4281 100.339 31.4632C100.985 26.0508 99.2305 20.4083 95.0617 16.257C90.8965 12.1041 85.2351 10.3552 79.8046 10.9976C79.8398 11.5278 79.8657 12.0599 79.8657 12.5992C79.8657 13.0797 79.8472 13.5935 79.8102 14.1695L79.7918 14.4125L74.2725 36.9768L96.9163 31.4742L97.1653 31.4575Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M98.7357 79.5976C98.2519 79.5976 97.7492 79.5811 97.1564 79.5425L96.9106 79.5258L74.2725 74.0253L79.7918 96.5893L79.8102 96.8323C79.8472 97.4068 79.8657 97.9221 79.8657 98.4045C79.8657 98.9422 79.8398 99.4722 79.8046 100.003C85.2351 100.647 90.8965 98.8979 95.0617 94.7448C99.2268 90.5918 100.982 84.9512 100.337 79.5388C99.807 79.5735 99.2732 79.5976 98.7357 79.5976Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M14.2177 79.5423C13.623 79.5809 13.1242 79.5974 12.6405 79.5974C12.0993 79.5974 11.5654 79.5752 11.0351 79.5386C10.3906 84.9509 12.1451 90.5916 16.3106 94.7445C20.4775 98.8977 26.1371 100.646 31.5676 100.002C31.5343 99.472 31.5087 98.9419 31.5087 98.4043C31.5087 97.9275 31.5252 97.4285 31.5639 96.834L31.5787 96.589L37.0998 74.025L14.4616 79.5258L14.2177 79.5423Z"
                            fill="#efcabe" fill-opacity="0.5" />
                        <path
                            d="M92.9004 37.089C92.4958 37.089 92.0952 37.1074 91.696 37.1332L68.4483 42.7829L74.1153 19.6132C74.1432 19.2156 74.1579 18.8143 74.1579 18.413C74.1577 8.2437 65.8863 0 55.6867 0C45.4852 0 37.2137 8.2437 37.2137 18.413C37.2137 18.8143 37.232 19.2156 37.2561 19.6132L42.9231 42.7829L19.6792 37.1332C19.2783 37.1074 18.8795 37.089 18.473 37.089C8.27143 37.089 0 45.3327 0 55.5C0 65.6693 8.27143 73.913 18.473 73.913C18.8756 73.913 19.2783 73.8946 19.6792 73.867L42.9231 68.219L37.2561 91.3888C37.2322 91.7866 37.2137 92.1859 37.2137 92.589C37.2137 102.756 45.4849 111 55.6867 111C65.8863 111 74.1577 102.757 74.1577 92.589C74.1577 92.1859 74.1429 91.7864 74.1151 91.3888L68.4481 68.219L91.6958 73.867C92.093 73.8946 92.4956 73.913 92.9002 73.913C103.102 73.913 111.371 65.6695 111.371 55.5C111.371 45.3327 103.104 37.089 92.9004 37.089ZM55.6847 65.8698C49.9384 65.8698 45.28 61.2271 45.28 55.5C45.28 49.7711 49.9386 45.1284 55.6847 45.1284C61.4329 45.1284 66.0912 49.7714 66.0912 55.5C66.0912 61.2271 61.4329 65.8698 55.6847 65.8698Z"
                            fill="#efcabe" fill-opacity="0.5" />
                    </svg>
                </div>
                <h1
                    class="xl:text-5xl text-2xl julius-sans-one-regular z-30 tracking-[15%] mb-3 text-left bottom-0 absolute">
                    Contact Us</h1>
            </div>
            <div class="" data-aos="fade-left" data-aos-delay="60">

                <div class="flex flex-col gap-4">
                    <div class="flex gap-3">

                        <svg class=" text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd"/>
                          </svg>

                          <div class="">
                            <h1>Instagram</h1>
                            <a class="text-2xl underline underline-offset-2"  href="https://www.instagram.com/{{ $data_homepage['instagram'] }}/">{{ $data_homepage['instagram'] }}</a>
                          </div>

                    </div>

                    <div class="flex gap-3">

                        <svg class="text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                          </svg>


                          <div class="">
                            <h1>Email</h1>
                            <a class="text-2xl underline underline-offset-2"

                            href="https://mail.google.com/mail/u/0/
                            ?to={{ $data_homepage['email'] }}
                            &su=OnlyMaiNails+Help
                            &body=Hello+There
                            &tf=cm"
                            >{{ $data_homepage['email'] }}</a>
                          </div>

                    </div>

                </div>

            </div>
        </div>
        {{-- Contact Us --}}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridContainer = document.getElementById('randomized-grid');
    if (!gridContainer) return;

    const items = gridContainer.querySelectorAll('.grid-item');
    if (items.length === 0) return;

    // Grid configuration
    const GAP = 16; // 4 * 4px (gap-4)
    const MIN_ITEM_WIDTH = 200;
    const MIN_ITEM_HEIGHT = 200;
    const MAX_ITEM_WIDTH = 400;
    const MAX_ITEM_HEIGHT = 500;

    // Available sizes for randomization
    const sizePresets = [
        { width: 250, height: 250 }, // Square
        { width: 300, height: 200 }, // Landscape
        { width: 200, height: 300 }, // Portrait
        { width: 350, height: 250 }, // Wide
        { width: 250, height: 350 }, // Tall
        { width: 300, height: 300 }, // Large square
        { width: 400, height: 200 }, // Extra wide
        { width: 200, height: 400 }, // Extra tall
    ];

    function createRandomizedGrid() {
        const containerWidth = gridContainer.offsetWidth;
        const containerHeight = Math.max(600, window.innerHeight * 0.6);
        
        // Clear previous positioning
        items.forEach(item => {
            item.style.position = 'absolute';
            item.style.left = '0px';
            item.style.top = '0px';
            item.style.width = '0px';
            item.style.height = '0px';
            item.style.opacity = '0';
        });

        // Create grid layout
        const grid = new Array(Math.ceil(containerHeight / 50)).fill(null).map(() => new Array(Math.ceil(containerWidth / 50)).fill(false));
        const placedItems = [];

        // Shuffle items for random order
        const shuffledItems = Array.from(items).sort(() => Math.random() - 0.5);

        shuffledItems.forEach((item, index) => {
            const size = sizePresets[Math.floor(Math.random() * sizePresets.length)];
            
            // Find best position
            const position = findBestPosition(grid, size.width, size.height, containerWidth, containerHeight);
            
            if (position) {
                // Place item
                item.style.left = position.x + 'px';
                item.style.top = position.y + 'px';
                item.style.width = size.width + 'px';
                item.style.height = size.height + 'px';
                item.style.opacity = '1';
                
                // Mark grid as occupied
                markGridOccupied(grid, position.x, position.y, size.width, size.height);
                placedItems.push({ item, position, size });
                
                // Add staggered animation
                setTimeout(() => {
                    item.style.transform = 'scale(1)';
                    item.style.transition = 'all 0.5s ease-out';
                }, index * 100);
            }
        });

        // Update container height to fit all items
        if (placedItems.length > 0) {
            const maxBottom = Math.max(...placedItems.map(item => item.position.y + item.size.height));
            gridContainer.style.height = Math.max(maxBottom + GAP, containerHeight) + 'px';
        } else {
            gridContainer.style.height = containerHeight + 'px';
        }
    }

    function findBestPosition(grid, width, height, containerWidth, containerHeight, attempts = 0) {
        const positions = [];
        
        // Try different positions
        for (let y = 0; y <= containerHeight - height; y += 20) {
            for (let x = 0; x <= containerWidth - width; x += 20) {
                if (canPlaceAt(grid, x, y, width, height)) {
                    // Calculate score based on how well it fits
                    const score = calculateFitScore(x, y, width, height, containerWidth, containerHeight);
                    positions.push({ x, y, score });
                }
            }
        }
        
        if (positions.length === 0 && attempts < 3) {
            // If no perfect fit, try with smaller size (max 3 attempts)
            const smallerWidth = Math.max(width * 0.8, MIN_ITEM_WIDTH);
            const smallerHeight = Math.max(height * 0.8, MIN_ITEM_HEIGHT);
            return findBestPosition(grid, smallerWidth, smallerHeight, containerWidth, containerHeight, attempts + 1);
        }
        
        // Return position with best score or null if no position found
        return positions.length > 0 ? positions.sort((a, b) => b.score - a.score)[0] : null;
    }

    function canPlaceAt(grid, x, y, width, height) {
        const startX = Math.floor(x / 50);
        const startY = Math.floor(y / 50);
        const endX = Math.ceil((x + width) / 50);
        const endY = Math.ceil((y + height) / 50);
        
        for (let gy = startY; gy < endY; gy++) {
            for (let gx = startX; gx < endX; gx++) {
                if (grid[gy] && grid[gy][gx]) {
                    return false;
                }
            }
        }
        return true;
    }

    function markGridOccupied(grid, x, y, width, height) {
        const startX = Math.floor(x / 50);
        const startY = Math.floor(y / 50);
        const endX = Math.ceil((x + width) / 50);
        const endY = Math.ceil((y + height) / 50);
        
        for (let gy = startY; gy < endY; gy++) {
            for (let gx = startX; gx < endX; gx++) {
                if (!grid[gy]) grid[gy] = [];
                grid[gy][gx] = true;
            }
        }
    }

    function calculateFitScore(x, y, width, height, containerWidth, containerHeight) {
        // Prefer positions that fill space efficiently
        let score = 0;
        
        // Prefer center positions
        const centerX = containerWidth / 2;
        const centerY = containerHeight / 2;
        const distanceFromCenter = Math.sqrt(Math.pow(x - centerX, 2) + Math.pow(y - centerY, 2));
        score += Math.max(0, 100 - distanceFromCenter / 10);
        
        // Prefer positions that don't leave large gaps
        const rightEdge = x + width;
        const bottomEdge = y + height;
        const rightGap = containerWidth - rightEdge;
        const bottomGap = containerHeight - bottomEdge;
        
        if (rightGap < 100) score += 20;
        if (bottomGap < 100) score += 20;
        
        // Add some randomness
        score += Math.random() * 30;
        
        return score;
    }

    // Initialize grid
    createRandomizedGrid();

    // Recreate grid on window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(createRandomizedGrid, 250);
    });

    // Recreate grid when images load
    const images = gridContainer.querySelectorAll('img');
    let loadedImages = 0;
    images.forEach(img => {
        if (img.complete) {
            loadedImages++;
        } else {
            img.addEventListener('load', function() {
                loadedImages++;
                if (loadedImages === images.length) {
                    setTimeout(createRandomizedGrid, 100);
                }
            });
        }
    });
    
    if (loadedImages === images.length) {
        setTimeout(createRandomizedGrid, 100);
    }
});
</script>
