@extends('layouts.app')

@section('title', 'Categories - Scents N Smile')

@section('content')
    <div class="min-h-screen pt-36 sm:pt-28 md:pt-32 pb-6 sm:pb-8 px-3 sm:px-4" style="background-color: #f5e6d3;">
        <div class="max-w-4xl mx-auto">
            <!-- Shop All Perfumes -->
            <div
                class="bg-white rounded-2xl p-4 mb-6 flex items-center gap-4 hover:shadow-lg transition-shadow cursor-pointer">
                <img src="https://via.placeholder.com/80" alt="Shop All" class="w-20 h-20 rounded-xl object-cover">
                <h2 class="text-xl font-bold">Shop All Perfumes</h2>
            </div>

            <!-- Shop by Gender -->
            <div class="bg-white rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">SHOP BY GENDER</h3>

                <!-- Women -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="Women" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium">Women</span>
                </a>

                <!-- Men -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="Men" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium">Men</span>
                </a>

                <!-- Unisex -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="Unisex" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium text-red-400">Unisex</span>
                </a>
            </div>

            <!-- More Ways to Shop -->
            <div class="bg-white rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">MORE WAYS TO SHOP</h3>

                <!-- Bestsellers -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="Bestsellers" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium">Bestsellers</span>
                </a>

                <!-- New Arrivals -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="New Arrivals" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium">New Arrivals</span>
                </a>
            </div>

            <!-- Discover -->
            <div class="bg-white rounded-2xl p-6">
                <h3 class="text-lg font-bold mb-4">DISCOVER</h3>

                <!-- Scent Families -->
                <a href="#"
                    class="flex items-center justify-between gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <div class="flex items-center gap-4">
                        <img src="https://via.placeholder.com/60" alt="Scent Families"
                            class="w-16 h-16 rounded-xl object-cover">
                        <span class="text-lg font-medium">Scent Families</span>
                    </div>
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <!-- Layering Perfumes -->
                <a href="#" class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <img src="https://via.placeholder.com/60" alt="Layering Perfumes"
                        class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-lg font-medium">Layering Perfumes</span>
                </a>
            </div>
        </div>
    </div>
@endsection