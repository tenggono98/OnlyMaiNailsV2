<div>
    <div class="" data-aos="fade-up">
        {{-- Header Title --}}
        <div class="mb-10 hidden xl:block">
            <h1 class=" title-h1 julius-sans-one-regular xl:text-center z-30 tracking-[15%] mb-3 ">
                ONLYMAINAILS</h1>
            <p class="xl:text-xl text-xl xl:text-center tracking-[15%]">Thank you for choosing Onlymainails</p>
        </div>
        {{-- Header Title --}}
        {{-- Container - Image --}}
        {{-- Desktop --}}
        <div class="xl:grid grid-cols-4 grid-rows-2 gap-4 h-[40rem] mb-10 hidden" data-aos="fade-up" data-aos-delay="60">
            @foreach($headerImages as $index => $image)
                @if($index === 0)
                <div class="row-span-2">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->alt_text }}" class="mx-auto rounded-xl w-full h-full object-cover shadow-md" data-aos="zoom-in" data-aos-delay="120">
                </div>
                @elseif($index === 1)
                <div>
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->alt_text }}" class="mx-auto rounded-xl w-full h-full shadow-md object-cover" data-aos="zoom-in" data-aos-delay="180">
                </div>
                @elseif($index === 2)
                <div class="col-start-2 row-start-2">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->alt_text }}" class="mx-auto rounded-xl w-full h-full shadow-md object-cover" data-aos="zoom-in" data-aos-delay="220">
                </div>
                @elseif($index === 3)
                <div class="col-span-2 row-span-2 col-start-3 row-start-1">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->alt_text }}" class="mx-auto rounded-xl w-full h-full shadow-md object-cover" data-aos="zoom-in" data-aos-delay="260">
                </div>
                @endif
            @endforeach
        </div>
        {{-- Desktop --}}
        {{-- Mobile --}}
        <div id="indicators-carousel" class="relative w-full mb-10 h-[20rem] xl:hidden" data-carousel="static" data-aos="fade-up">
            <!-- Carousel wrapper -->
            <div class="relative h-[20rem] overflow-hidden rounded-lg">
                @foreach($headerImages as $index => $image)
                <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                        alt="{{ $image->alt_text }}">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                @foreach($headerImages as $index => $image)
                <button type="button" class="w-3 h-3 rounded-full"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}">
                </button>
                @endforeach
            </div>
        </div>
        {{-- Mobile --}}
        {{-- Container - Image --}}
        {{-- Container - Promo --}}
        <div id="indicators-carousel" class="relative w-full xl:mb-10 mb-10 xl:h-36" data-carousel="static" data-aos="fade-up" data-aos-delay="100">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-36">
                @foreach($promoImages as $index => $image)
                <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                        alt="{{ $image->alt_text }}">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                @foreach($promoImages as $index => $image)
                <button type="button" class="w-3 h-3 rounded-full"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}">
                </button>
                @endforeach
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        {{-- Container - Promo --}}
        {{-- About Us --}}
        <div class="xl:mb-10 mb-40  align-middle" data-aos="fade-up">
            <div class="grid xl:grid-cols-2 grid-cols-1 gap-10">
                <div class="" data-aos="fade-right">
                    {{-- Img --}}
                    <img src="{{ asset('img/0V9A9946.jpg') }}"
                        class="mx-auto rounded-xl w-full xl:h-[42rem] object-cover shadow-md" alt="">
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
                            class="xl:text-4xl text-xl underline underline-offset-4 relative group flex items-center space-x-2">
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
