@extends('admin.layout.admin-layout')

@section('title', 'category')

@section('content')
    <div class="ml-72 min-h-screen bg-[#0f172a] p-6 text-white">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Add Category</h1>
            <p class="mt-2 text-gray-400">Create a new food category</p>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl rounded-3xl border border-gray-800 bg-[#111827] p-8 shadow-2xl">

            <form class="space-y-6" method="POST" enctype="multipart/form-data">

                <!-- Category Name -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Category Name
                    </label>

                    <input type="text" placeholder="Enter category name"
                    name="name"
                        class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-white outline-none transition focus:border-orange-500">
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Category Image
                    </label>

                    <div
                        class="rounded-2xl border-2 border-dashed border-gray-700 bg-[#1f2937] p-8 text-center hover:border-orange-500">
                        <input type="file" class="w-full text-gray-400" name="image" accept="image/*">
                        <p class="mt-3 text-sm text-gray-500">
                            Upload JPG / PNG (Max 2MB)
                        </p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-gray-300">
                        Status
                    </label>

                    <div class="flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="status" checked>
                            <span>Active</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="status">
                            <span>Inactive</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Description
                    </label>

                    <textarea rows="4" placeholder="Optional description..."
                        class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-white outline-none focus:border-orange-500"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="rounded-xl bg-orange-500 px-6 py-3 font-semibold text-white transition hover:bg-orange-600">
                        Save Category
                    </button>

                    <button type="reset" class="rounded-xl bg-gray-700 px-6 py-3 font-semibold hover:bg-gray-600">
                        Reset
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
