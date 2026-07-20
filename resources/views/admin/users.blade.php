@extends('admin.admin-layout')

@section('title', 'users')

@section('content')
    <section class="min-h-screen bg-[#0f172a] p-6 text-white">
        <!-- Search + Filter -->
        <div class="mb-6 flex flex-col gap-4 lg:flex-row">
            <input type="text" placeholder="Search food..." id="search-user"
                class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none focus:border-orange-500 lg:w-96" />

            <select class="rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 outline-none">
                <option>All Categories</option>
                <option>Pizza</option>
                <option>Burger</option>
                <option>Drinks</option>
            </select>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-800 bg-[#111827] shadow-xl">
            <table class="min-w-full">
                <thead class="bg-[#1f2937]">
                    <tr class="text-left">
                        <th class="px-3 py-1 text-md font-semibold">User Id</th>
                        <th class="px-3 py-1 text-md font-semibold">User Name</th>
                        <th class="px-3 py-1 text-md font-semibold">User Email</th>
                        <th class="px-3 py-1 text-md font-semibold">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @foreach ($users as $user)
                        <tr class="hover:bg-[#1b2433]">
                            <td class="px-3 py-2 text-sm">
                                {{ $user->id }}
                            </td>

                            <td class="px-3 py-2 text-sm font-medium">{{ $user->name }}</td>
                            <td class="px-3 py-2 text-sm font-medium ">{{ $user->email }}</td>

                            <td class="px-3 py-2 text-sm">
                                <form>
                                    <select
                                        data-url="{{ route('users.update_status', $user->id) }}" name="status"
                                        class="status-select bg-gray-900 cursor-pointer hover:bg-gray-800">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>
                                            Blocked
                                        </option>
                                    </select>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection


@push('script')
    <script src="{{ asset('/js/index.js') }}"></script>
@endpush
