@extends('admin.layout.admin-layout')

@section('title', 'add slider')

@section('content')

    <div class="text-white p-6 w-full min-h-screen">

        <!-- Form Card -->
        <div class="max-w-4xl mx-auto rounded-3xl border border-gray-800 bg-[#111827] p-8 shadow-2xl">
            <form class="space-y-6" method="POST" enctype="multipart/form-data" action="{{ route('slider.update',$slider->id) }}" class="w-full">
                <!-- Laravel -->
                <!-- @csrf -->
                @method('PUT')
                <!-- Food Name -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-300">
                        Food Name
                    </label>

                    <input type="text" value="{{ $slider->title ? $slider->title : 'No title available' }}" name="name"
                        placeholder="Enter food name" name="name"
                        class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500">
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
                        <div class="h-1 w-full bg-orange-500/50 rounded-2xl mt-10"></div>
                        <div class="mt-3">
                            <h1 class="my-3 text-xl uppercase">Current image</h1>
                            <img src="http://localhost:8000/storage/{{$slider->image}}" class="rounded-2xl" alt="">
                        </div>
                    </div>
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
