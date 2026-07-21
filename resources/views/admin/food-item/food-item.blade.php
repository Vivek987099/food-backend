@extends('admin.layout.admin-layout')

@section('title', 'food items')


@section('content')


    <div class="min-h-screen bg-[#0f172a] p-6 text-white">



        <!-- Header -->
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold">Food Items</h1>
                <p class="text-gray-400">Manage all food products</p>
            </div>

            <a href="add-food" class="rounded-xl bg-orange-500 px-5 py-3 font-semibold hover:bg-orange-600">
                + Add Food Item
            </a>
        </div>
        @if (session('success'))
            <div id="alert"
                class="fixed top-35 right-5 flex items-center gap-3 bg-green-600/30 border border-green-600 text-green-600 px-5 py-3 rounded-xl shadow-xl z-50 transition-all duration-500">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <!-- Search + Filter -->
        <div class="mb-6 flex flex-col gap-4 lg:flex-row">
            <input type="text" placeholder="Search food..."
                class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500 lg:w-96" />

            <select class="rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none">
                <option>All Categories</option>
                <option>Pizza</option>
                <option>Burger</option>
                <option>Drinks</option>
            </select>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl border border-gray-800 bg-[#111827] shadow-xl">
            <table class="min-w-full">
                <thead class="bg-[#1f2937]">
                    <tr class="text-left *:text-orange-500">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Food Name</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @foreach ($food_items as $item)
                        <tr class="hover:bg-[#1b2433]">
                            <td class="px-6 py-4">
                                <img src="http://localhost:8000/storage/{{ $item->image }}"
                                    class="h-14 w-14 rounded-xl object-cover">
                            </td>

                            <td class="px-6 py-4 font-medium">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->category->name }}</td>
                            <td class="px-6 py-4"><i class="fa-solid fa-indian-rupee-sign text-sm"></i> {{ $item->price }}
                            </td>
                            <td class="px-6 py-4">
                                <form>
                                    <select data-url="{{ route('foods.updateStatus', $item->id) }}" name="status"
                                        class="status-select bg-gray-900 cursor-pointer hover:bg-gray-800">
                                        <option value="1" {{ $item->is_available == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $item->is_available == '0' ? 'selected' : '' }}>
                                            InActive</option>

                                    </select>
                                </form>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('food-item.show', $item->slug) }}"
                                        class="rounded-lg bg-blue-500 px-3 py-2 text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('foods.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="rounded-lg bg-red-500 px-3 py-2 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('alert');

            if (alert) {
                setTimeout(() => {
                    alert.classList.add('opacity-0');

                    setTimeout(() => {
                        alert.remove();
                    }, 500); // fade out complete hone ke baad remove
                }, 3000);
            }
        });
    </script>
    <script src="{{ asset('js/index.js') }}"></script>
@endpush
