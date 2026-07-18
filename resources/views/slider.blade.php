@extends('admin.admin-layout')

@section('title', 'orders')

@section('content')
    <div class="p-6 text-white">
        <!-- Header -->
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold">Slider Management</h1>
                <p class="text-gray-400">Manage all food categories</p>
            </div>

            <a href="add-slider" class="rounded-xl bg-orange-500 px-5 py-3 font-semibold hover:bg-orange-600">
                + Add new Slider
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-800 bg-[#111827] shadow-xl">
            <table class="min-w-full">
                <thead class="bg-[#1f2937]">
                    <tr class="text-left">
                        <th class="px-6 py-1 text-md font-semibold">Image</th>
                        <th class="px-6 py-1 text-md font-semibold">Title</th>
                        <th class="px-6 py-1 text-md font-semibold">Status</th>
                        <th class="px-6 py-1 text-md font-semibold">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @foreach ($sliders as $item)
                        <tr class="hover:bg-[#1b2433]">


                            <td class="px-3 py-2 text-sm font-medium ">
                                <img src="http://localhost:8000/storage/{{ $item->image }}"
                                    class="h-14 w-20 rounded-md object-cover">
                            </td>
                            <td class="px-3 py-2 text-sm">
                                @if ($item->title)
                                    {{ $item->title }}
                                @endif ----
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <form action="{{ route('sliders.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select onchange="this.form.submit()" name="status" id=""
                                        class="bg-gray-900 cursor-pointer hover:bg-gray-800">
                                        <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $item->status == '0' ? 'selected' : '' }}>
                                            InActive
                                        </option>

                                    </select>
                                </form>
                            </td>
                           
                           

                            <td class="px-3 py-2 text-sm">
                                <div class="flex gap-2">
                                    <button class="rounded-lg bg-blue-500 px-3 py-0.5 text-xs">
                                        Edit
                                    </button>
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="rounded-lg bg-red-500 px-3 py-0.5  text-xs">
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
