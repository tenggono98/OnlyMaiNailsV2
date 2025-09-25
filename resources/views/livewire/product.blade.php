<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    {{-- BANNER ZONE --}}
    <section id="banner" class="">
        <div class="py-5 ">
            <h1 class="text-4xl text-center animate-fade animate-once animate-delay-100">Our Product </h1>
        </div>
    </section>
    {{-- BANNER ZONE --}}
    {{-- Content ZONE --}}
    <section id="content-product">
        <div class="grid grid-cols-3 gap-3">
            {{-- Filter Zone --}}
            <div class="flex flex-col gap-4 p-4">
                <!-- Search Name -->
                <input type="text" placeholder="Search Product Name" id="search-product"
                    class="p-2 border border-brand-accent-light rounded">
                <!-- Product Line -->
                <div>
                    <button
                        class="flex items-center justify-between w-full p-2 text-left border border-brand-accent-light rounded"
                        onclick="toggleDropdown('product-line')">
                        <div>
                            <h1>Product</h1>
                        </div>
                    </button>
                    <ul id="product-line" class="hidden pl-4 mt-2">
                        <li class="flex items-center gap-2 p-1 align-middle">
                            <input type="checkbox" name="" id="pro-1">
                            <div class="">
                                <label for="pro-1">
                                    Product 1
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Category Filter -->
                <div>
                    <button
                        class="flex items-center justify-between w-full p-2 text-left border border-brand-accent-light rounded"
                        onclick="toggleDropdown('category-filter')">
                        <div>
                            <h1>Category</h1>
                        </div>
                    </button>
                    <ul id="category-filter" class="hidden pl-4 mt-2">
                        <li class="flex items-center gap-2 p-1 align-middle">
                            <input type="checkbox" name="" id="cat-1">
                            <div class="">
                                <label for="cat-1">
                                    Category 1
                                </label>
                            </div>
                        </li>
                        <li class="flex items-center gap-2 p-1 align-middle">
                            <input type="checkbox" name="" id="cat-1">
                            <div class="">
                                <label for="cat-1">
                                    Category 1
                                </label>
                            </div>
                        </li>
                        <li class="flex items-center gap-2 p-1 align-middle">
                            <input type="checkbox" name="" id="cat-1">
                            <div class="">
                                <label for="cat-1">
                                    Category 1
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Color -->
                <div>
                    <button
                        class="flex items-center justify-between w-full p-2 text-left border border-brand-accent-light rounded"
                        onclick="toggleDropdown('color-filter')">
                        <div>
                            <h1>Color</h1>
                        </div>
                    </button>
                    <ul id="color-filter" class="hidden pl-4 mt-2">
                        <li class="p-1">Pink</li>
                        <li class="p-1">Blue</li>
                    </ul>
                </div>
                <!-- Price -->
                <h1 class="p-2">Price</h1>
                <div class="flex flex-row gap-2">
                    <div>
                        <label for="min-price" class="block">Min</label>
                        <input type="number" id="min-price" class="p-2 border border-brand-accent-light rounded">
                    </div>
                    <div>
                        <label for="max-price" class="block">Max</label>
                        <input type="number" id="max-price" class="p-2 border border-brand-accent-light rounded">
                    </div>
                </div>
            </div>
            {{-- Filter Zone --}}
            {{-- Product Zone --}}
            <div class="col-span-2">
                <div class="flex justify-end mb-5">
                    <div class="">


                    {{-- Show Filter --}}
                    <select name="" id="">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>

                    {{-- Sort By --}}
                    <select name="" id="">
                        <option value="">Name A-Z</option>
                        <option value="">Name Z-A</option>
                        <option value="">Category A-Z</option>
                        <option value="">Category Z-A</option>
                        <option value="">Price Min-Max</option>
                        <option value="">Price Max-Min</option>
                    </select>
                    {{-- Sort By --}}
                </div>

                    {{-- Show Filter --}}
                </div>
                <div class="grid grid-cols-3 gap-3 ">
                    <div class="p-4 border border-brand-accent-light rounded-lg">
                        <img class="w-auto mx-auto rounded-2xl h-42"
                            src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2899&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                        <div class="my-5">
                            <div class="flex justify-between">
                                <div class="">
                                    <h1>Product 1</h1>
                                </div>
                                <div class="">
                                    <h2>$50</h2>
                                </div>
                            </div>
                            <small>{{ Str::substr('Lorem ipsum dolor sit amet consectetur adipisicing elit... asdasdasd', 0, 58) }}</small>

                        </div>
                    </div>
                    <div class="p-4 border border-brand-accent-light rounded-lg">
                        <img class="w-auto mx-auto rounded-2xl h-42"
                            src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2899&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                            <div class="my-5">
                                <h1>Product 1</h1>
                            </div>
                    </div>
                    <div class="p-4 border border-brand-accent-light rounded-lg">
                        <img class="w-auto mx-auto rounded-2xl h-42"
                            src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2899&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                            <div class="my-5">
                                <h1>Product 1</h1>
                            </div>
                    </div>
                </div>
            </div>
            {{-- Product Zone --}}
        </div>
    </section>
    {{-- Content ZONE --}}
    <script>
        function toggleDropdown(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
            const icon = button.querySelector('.icon');
            if (icon) {
                if (element.classList.contains('hidden')) {
                    icon.classList.remove('rotate-180');
                } else {
                    icon.classList.add('rotate-180');
                }
            } else {
                console.error('Icon element not found');
            }
        }
    </script>
</div>
