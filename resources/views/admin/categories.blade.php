@extends('admin.admin-layout')

@section('title', 'category')

@section('content')

    <div class=" p-6 text-white">

        <!-- Header -->
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold">Category Management</h1>
                <p class="text-gray-400">Manage all food categories</p>
            </div>

            <a href="add-category" class="rounded-xl bg-orange-500 px-5 py-3 font-semibold hover:bg-orange-600">
                + Add Category
            </a>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" placeholder="Search category..."
                class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500 md:w-96" />
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl border border-gray-800 bg-[#111827] shadow-xl">
            <table class="min-w-full">
                <thead class="bg-[#1f2937] text-left">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Category Name</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @foreach ($categories as $category)
                        <tr class="hover:bg-[#1b2433]">
                            <td class="px-6 py-4">1</td>

                            <td class="px-6 py-4">
                                <img src="http://localhost:8000/storage/{{ $category->image }}"
                                    class="h-12 w-12 rounded-lg object-cover">
                            </td>

                            <td class="px-6 py-4">{{ $category->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="rounded-lg bg-blue-500 px-3 py-2 text-sm">
                                        Edit
                                    </button>

                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
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
