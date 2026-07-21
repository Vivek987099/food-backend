@extends('admin.layout.admin-layout')

@section('title', 'dashboard')

@php
    $cards = [
        ['key' => 'users', 'title' => 'Total Users', 'icon' => '<i class="fa-solid fa-users"></i>'],
        ['key' => 'orders', 'title' => 'Total Orders', 'icon' => '<i class="fa-solid fa-bag-shopping"></i>'],
        ['key' => 'revenue', 'title' => 'Total Revenue', 'icon' => '<i class="fa-solid fa-wallet"></i>'],
        ['key' => 'foods', 'title' => 'Food Items', 'icon' => '<i class="fa-solid fa-bowl-rice"></i>'],
    ];
@endphp

@section('content')
    <section class="min-h-screen w-full  p-6">
        <div class="w-full grid grid-cols-4 gap-4">
            @foreach ($cards as $card)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                {{ $card['title'] }}
                            </p>
                            <h2 class="mt-2 text-3xl font-bold text-gray-900">
                                @if ($card['key'] === 'revenue')
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                @endif
                                {{ $stats[$card['key']] }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center text-orange-500">
                            {!! $card['icon'] !!}
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span
                                class="flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                ↑ 12%
                            </span>

                        </div>

                    </div>
                </div>
            @endforeach


        </div>

        <div class="w-full grid grid-cols-4 gap-5 mt-5">

            <div class="col-span-2">
                <div class="bg-white rounded-lg p-2">
                    <canvas id="monthly-orders" class="w-full"></canvas>
                </div>
            </div>
            <div class="col-span-2">
                <div class=" rounded-lg p-2">
                    <canvas id="orders-status"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/dashboard.js"></script>
@endpush
