<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    {{-- HERO ZONE --}}
    <section id="hero">
        <div class="lg:grid lg:grid-cols-7 lg:grid-flow-col">
            <div class="lg:justify-end lg:flex lg:col-span-3">
                <img src="{{ asset('img/IMG_3915.png') }}"
                    class="object-cover w-full rounded-lg lg:h-full h-72 lg:w-auto delay-[300ms] duration-[600ms] taos:[transform:translate3d(-200px,0,0)_scale(0.6)] taos:opacity-0 data-taos-offset='400'"
                    alt="">
            </div>
            <div class="p-5 text-justify lg:col-span-4 lg:px-40 lg:py-14">
                <h1 class="text-4xl hidden lg:block leading-loose tracking-wide text-center uppercase lg:text-left delay-[300ms] duration-[600ms] taos:scale-[0.6] taos:opacity-0"
                    data-taos-offset="400">Only Mai Nails</h1>
                <p class="mb-5 leading-loose">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum provident eius dolores accusantium
                    totam quam odit? Commodi temporibus dolorem mollitia.
                </p>
                <p class="mb-5 leading-loose">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, hic.
                </p>
                <p class="mb-5 leading-loose">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur maiores sunt nemo voluptatibus
                    amet voluptas officia, ipsum vero nulla facilis in dignissimos laboriosam necessitatibus deserunt
                    totam nihil odio. Veritatis, illo.
                </p>
                <div class="flex justify-end">
                    <div class="">
                        {{-- <img src="{{ asset('img/CTA_model.png') }}" class="w-auto h-48" alt=""> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- HERO ZONE --}}
    {{-- BANNER ZONE --}}
    <section id="banner" class="py-10 ">
        <div class="py-5 ">
            <h1 class="text-4xl text-center animate-fade animate-once animate-delay-100">WELCOME TO ONLYMAINAILS </h1>
        </div>
    </section>
    {{-- BANNER ZONE --}}
    {{-- About Us ZONE --}}
    <section id="about-us">
        <div class="lg:grid lg:grid-cols-7 lg:grid-flow-col">
            <div class="order-1 lg:order-2 lg:col-span-3">
                <img src="{{ asset('img/IMG_3916.png') }}"
                    class="object-cover w-full rounded-lg lg:h-full h-72 lg:w-auto delay-[300ms] duration-[600ms] taos:[transform:translate3d(200px,0,0)_scale(0.6)] taos:opacity-0"
                    data-taos-offset='400' alt="">
            </div>
            <div class="order-2 p-5 text-justify lg:order-1 lg:col-span-4 lg:px-40 lg:py-14">
                <h1 class="text-4xl leading-loose tracking-wide text-center uppercase lg:text-left">About Us</h1>
                <p class="mb-5 leading-loose">
                    At Only Mai Nails we are dedicated to providing our clients with the best possible nail care
                    experience. Our team of highly skilled and licensed technicians is passionate about what they do and
                    committed to delivering exceptional service in a clean and welcoming environment. We believe that
                    healthy nails are the foundation of beauty and wellness, and we strive to help our clients achieve
                    the perfect balance of both.
                </p>
                <p class="mb-5 leading-loose">
                    From basic manicures to the latest trends in nail art and design, we offer a wide range of services
                    to suit every need and budget. At Only Mai Nails we pride ourselves on using only the highest
                    quality products and techniques to ensure that our clients receive the best possible results. Come
                    and experience the ultimate in nail care at Only Mai Nails – we look forward to seeing you soon!
                </p>
            </div>
        </div>
    </section>
    {{-- About Us ZONE --}}
    {{-- BANNER ZONE --}}
    <section id="banner" class="py-10 ">
        <div class="py-5 ">
            <h1 class="text-4xl text-center uppercase">WHAT OUR BEAUTIFUL & HAPPY CLIENTS SAY </h1>
        </div>
    </section>
    {{-- BANNER ZONE --}}
    {{-- Review ZONE --}}
    <section id="review">
        <div class="grid gap-4 lg:grid-cols-3">
            {{-- Review Comment - Start --}}
            @foreach ($review as $r)
                {{-- Card  --}}
                <div class="p-4 border-[#fadde1] border  rounded-lg">
                    <article>
                        <div class="flex items-center mb-4">
                            <div class="font-medium dark:text-white">
                                <p>{{ $r->user->name }}
                                    <time datetime="{{ Carbon\Carbon::parse($r->created_at)->format('Y-m-d H:i') }}"
                                        class="block text-sm text-gray-500 dark:text-gray-400">{{ Carbon\Carbon::parse($r->created_at)->format('F Y') }}</time>
                                </p>
                            </div>
                        </div>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $r->description_review }}</p>
                    </article>
                </div>
                {{-- Card --}}
                {{-- Review Comment - End --}}
            @endforeach
            {{-- Card  --}}
            <div class="p-4 border-[#fadde1] border  flex justify-center items-center rounded-lg">
                <div class="">
                    <a href="" class="transition-transform hover:underline">
                        <h1 class="">View More</h1>
                    </a>
                </div>
            </div>
            {{-- Card --}}
        </div>
    </section>
    {{-- Review ZONE --}}
</div>
