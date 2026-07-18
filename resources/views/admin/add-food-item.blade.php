@extends('admin.admin-layout')

@section('title','food item')

@section('content')
    <div class="min-h-screen bg-[#0f172a] p-6 text-white">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Add Food Item</h1>
            <p class="mt-2 text-gray-400">Create a new food item for your menu</p>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl rounded-3xl border border-gray-800 bg-[#111827] p-8 shadow-2xl">

            <form class="space-y-6" method="POST" enctype="multipart/form-data" action="/admin/add-food">
                <!-- Laravel -->
                <!-- @csrf -->

                <!-- Food Name -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Food Name
                    </label>

                    <input type="text" name="name" placeholder="Enter food name"
                    name="name"
                        class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500">
                </div>

                <!-- Price + Category -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Price -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-300">
                            Price
                        </label>

                        <input type="number" name="price" placeholder="₹ 199"
                        name="price"
                            class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-300">
                            Category
                        </label>

                        <select name="category_id"
                            class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500">

                            <option>Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Image Upload -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Food Image
                    </label>

                    <div
                        class="rounded-2xl border-2 border-dashed border-gray-700 bg-[#1f2937] p-8 text-center hover:border-orange-500">
                        <input type="file" name="image" class="w-full text-gray-400">
                        <p class="mt-3 text-sm text-gray-500">
                            Upload JPG / PNG (Max 2MB)
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Description
                    </label>

                    <textarea rows="5" name="description" placeholder="Enter food description..."
                    name="description"
                        class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="rounded-xl bg-orange-500 px-6 py-3 font-semibold hover:bg-orange-600">
                        Save Food Item
                    </button>

                    <button type="reset" class="rounded-xl bg-gray-700 px-6 py-3 font-semibold hover:bg-gray-600">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
