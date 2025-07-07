<div x-data="{ showEdit: false }" class="relative group break-inside-avoid transition-transform hover:scale-[1.02]">
    @php
        $type = $type ?? 'portfolio'; // Default fallback
    @endphp

    <!-- Image Preview -->
    <img src="{{ asset($image) }}"
         alt="{{ $title }}"

         class="w-full rounded-xl shadow-md object-cover cursor-pointer"
         @click="$dispatch('open-modal', { image: '{{ asset($image) }}' })">

    <!-- Admin Edit & Delete Controls -->
    @if(Auth::check() && Auth::user()->hasRole('admin') && $id)
        <div class="absolute top-2 right-2 hidden group-hover:flex flex-col gap-2 z-10">
            @php
                $updateRoute = match ($type) {
                    'bridalhenna' => route('admin.bridalhenna.update', $id),
                    'bridalmakeup' => route('admin.bridalmakeup.update', $id),
                    'bunhairstyle' => route('admin.bunhairstyle.update', $id),
                    'braidhairstyle' => route('admin.braid.update', $id),
                    'chinesemakeup' => route('admin.chinesemakeup.update', $id),
                    'halfuphairstyle' => route('admin.halfuphairstyle.update', $id),
                    'handhenna' => route('admin.handhenna.update', $id),
                    'indianmakeup' => route('admin.indianmakeup.update', $id),
                    'leghenna' => route('admin.leghenna.update', $id),
                    default => '#'
                };

                $deleteRoute = match ($type) {
                    'bridalhenna' => route('admin.bridalhenna.delete', $id),
                    'bridalmakeup' => route('admin.bridalmakeup.delete', $id),
                    'bunhairstyle' => route('admin.bunhairstyle.delete', $id),
                    'braidhairstyle' => route('admin.braid.delete', $id),
                    'chinesemakeup' => route('admin.chinesemakeup.delete', $id),
                    'halfuphairstyle' => route('admin.halfuphairstyle.delete', $id),
                    'handhenna' => route('admin.handhenna.delete', $id),
                    'indianmakeup' => route('admin.indianmakeup.delete', $id),
                    'leghenna' => route('admin.leghenna.delete', $id),
                    default => '#'
                };
            @endphp

            <!-- EDIT: Upload New Image -->
            <form action="{{ $updateRoute }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white/90 rounded-full shadow p-1">
                @csrf
                <label for="file-{{ $id }}" class="cursor-pointer" title="Change Image">
                    <svg class="w-5 h-5 text-gray-800 hover:text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6m-3 3H5v-3l6-6"/>
                    </svg>
                </label>
                <input id="file-{{ $id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
            </form>

            <!-- DELETE: Remove Image -->
            <form action="{{ $deleteRoute }}"
                  method="POST"
                  onsubmit="return confirm('Delete this image?')"
                  class="bg-white/90 rounded-full shadow p-1">
                @csrf
                @method('DELETE')
                <button type="submit" title="Delete">
                    <svg class="w-5 h-5 text-red-600 hover:text-red-800" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
    @endif
</div>
