@extends('admin.admin-layout')

@section('title', 'orders')

@section('content')

    <section class="min-h-screen bg-[#0f172a] p-6 text-white">
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
        <div class="overflow-x-auto rounded-lg border border-gray-800 bg-[#111827] shadow-xl">
            <table class="min-w-full">
                <thead class="bg-[#1f2937]">
                    <tr class="text-left">
                        <th class="px-6 py-1 text-md font-semibold">Order Id</th>
                        <th class="px-6 py-1 text-md font-semibold">Customer</th>
                        <th class="px-6 py-1 text-md font-semibold">Contact</th>
                        <th class="px-6 py-1 text-md font-semibold">Total</th>
                        <th class="px-6 py-1 text-md font-semibold">Status</th>
                        <th class="px-6 py-1 text-md font-semibold">Payment Status</th>
                        <th class="px-6 py-1 text-md font-semibold">Payment Method</th>
                        <th class="px-6 py-1 text-md font-semibold">Date</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @foreach ($orders as $item)
                        <tr class="hover:bg-[#1b2433]">
                            <td class="px-3 py-2 text-sm">
                                {{ $item->id }}
                            </td>

                            <td class="px-3 py-2 text-sm font-medium">{{ $item->name }}</td>
                            <td class="px-3 py-2 text-sm font-medium ">{{ $item->phone }}</td>
                            <td class="px-3 py-2 text-sm"><i class="fa-solid fa-indian-rupee-sign text-sm"></i>
                                {{ $item->total }}</td>
                            <td class="px-3 py-2 text-sm">
                                <form action="{{ route('orders.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select onchange="this.form.submit()" name="status" id=""
                                        class="bg-gray-900 cursor-pointer hover:bg-gray-800">
                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="preparing" {{ $item->status == 'preparing' ? 'selected' : '' }}>
                                            Preparing</option>
                                        <option value="out_for_delivery"
                                            {{ $item->status == 'out_for_delivery' ? 'selected' : '' }}>Our for delivery
                                        </option>
                                        <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancel</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="rounded-full bg-green-500/20 px-3 py-0.5 text-sm text-green-400">
                                    {{ $item->payment_status }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="rounded-full bg-green-500/20 px-3 py-0.5 text-xs text-green-400 uppercase">
                                    {{ $item->payment_method }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="rounded-full bg-green-500/20 px-3 py-0.5 text-xs text-green-400">
                                    {{ $item->created_at->format('d F Y') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>

@endsection
