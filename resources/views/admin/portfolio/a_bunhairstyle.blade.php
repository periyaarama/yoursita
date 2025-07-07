<x-app-layout :bodyClass="Auth::check() && Auth::user()->hasRole('admin') ? 'bg-[#FFD8A9]' : ''">
    <div x-data="{ showModal: false, currentImage: '' }">
        <div class="px-6 py-12 min-h-screen">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-bold font-playfair capitalize mb-10 text-center text-gray-800 tracking-wide">
                    Bun Hairstyle Portfolio
                </h1>

                <!-- Portfolio Grid -->
                <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
                    @foreach ($images as $img)
                        @include('components._portfolio-card', [
                            'image' => $img->url,
                            'title' => 'Bun Hairstyle',
                            'id' => $img->id,
                            'type' => 'bunhairstyle'
                        ])
                    @endforeach
                </div>

                <!-- Admin Upload Button -->
                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <div class="flex justify-center mt-10">
                            <form action="{{ route('admin.bunhairstyle.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <input type="file" id="adminImageUpload" name="image" accept="image/*" class="hidden" onchange="document.getElementById('uploadForm').submit()">
                                <button type="button"
                                        onclick="document.getElementById('adminImageUpload').click()"
                                        class="bg-pink-500 hover:bg-pink-600 text-white w-12 h-12 rounded-full shadow-lg text-2xl flex items-center justify-center transition duration-300"
                                        title="Upload New Image">
                                    +
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

                <!-- Back Button -->
                <div class="mt-12 text-center">
                    <a href="{{ route('portfolio') }}"
                       class="inline-block bg-pink-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-pink-700 transition">
                        ← Back to Galleries
                    </a>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div x-show="showModal" x-transition
             class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
             @keydown.window.escape="showModal = false">
            <div class="relative max-w-4xl w-full px-4">
                <img :src="currentImage"
                     class="max-h-[90vh] mx-auto rounded-xl object-contain shadow-2xl"
                     alt="Enlarged Image">
                <button @click="showModal = false"
                        class="absolute top-3 right-4 text-white text-4xl font-bold hover:text-pink-400 leading-none z-50">
                    &times;
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
