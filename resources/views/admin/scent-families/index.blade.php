@extends('admin.layouts.app')

@section('title', 'Scent Families Management')

@section('content')
    <!-- Main Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 p-6">

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div
                        class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Scent Families</h1>
                        <p class="mt-1 text-sm text-gray-600">Manage product scent families with images</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="exportBtn"
                        class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 hover:text-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                    </button>
                    <button id="refreshBtn"
                        class="inline-flex items-center justify-center w-11 h-11 bg-white text-gray-700 rounded-xl border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 hover:text-purple-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <button onclick="openAddModal()"
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 text-white text-sm font-bold rounded-xl hover:from-purple-600 hover:to-pink-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Scent Family
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div
                class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-xl shadow-md animate-slideIn">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total -->
            <div
                class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <span
                        class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-xs font-bold text-white">Total</span>
                </div>
                <div class="text-white">
                    <p class="text-4xl font-black mb-1">{{ $totalScentFamilies }}</p>
                    <p class="text-purple-100 text-sm font-medium">Total Families</p>
                </div>
            </div>

            <!-- Active -->
            <div
                class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-xs font-bold text-white">Live</span>
                </div>
                <div class="text-white">
                    <p class="text-4xl font-black mb-1">{{ $activeScentFamilies }}</p>
                    <p class="text-emerald-100 text-sm font-medium">Active Families</p>
                </div>
            </div>

            <!-- Inactive -->
            <div
                class="bg-gradient-to-br from-gray-500 to-slate-600 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <span
                        class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-xs font-bold text-white">Offline</span>
                </div>
                <div class="text-white">
                    <p class="text-4xl font-black mb-1">{{ $inactiveScentFamilies }}</p>
                    <p class="text-gray-100 text-sm font-medium">Inactive Families</p>
                </div>
            </div>

            <!-- Used -->
            <div
                class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-xs font-bold text-white">Used</span>
                </div>
                <div class="text-white">
                    <p class="text-4xl font-black mb-1">{{ $usedScentFamilies }}</p>
                    <p class="text-blue-100 text-sm font-medium">Families in Use</p>
                </div>
            </div>
        </div>

        <!-- Main Data Table Card -->
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

            <!-- Table Toolbar -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                </svg>
                            </span>
                            Scent Families Data Table
                        </h2>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="bulkAction"
                            class="px-3 py-2 bg-white border-2 border-gray-300 rounded-lg text-sm font-medium focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select Action</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="delete" class="text-red-600">Delete Selected</option>
                        </select>
                        <button id="applyBulkAction" disabled
                            class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 px-6 py-5 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="globalSearch"
                                class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 rounded-xl bg-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                placeholder="Search by name...">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Status</label>
                        <select id="statusFilter"
                            class="block w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">All Status</option>
                            <option value="1">✓ Active</option>
                            <option value="0">✗ Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Selected</label>
                        <div
                            class="flex items-center h-12 px-4 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl">
                            <span id="selectedCount" class="text-2xl font-black text-purple-700">0</span>
                            <span class="ml-2 text-sm font-semibold text-purple-600">items</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table id="scentFamiliesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-slate-100 to-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-center w-12">
                                <input type="checkbox" id="selectAll"
                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                            </th>
                            <th class="px-4 py-4 text-center w-16">
                                <span class="text-xs font-black text-gray-700 uppercase">ID</span>
                            </th>
                            <th class="px-4 py-4 text-center w-20">
                                <span class="text-xs font-black text-gray-700 uppercase">Image</span>
                            </th>
                            <th class="px-4 py-4 text-left min-w-[200px]">
                                <span class="text-xs font-black text-gray-700 uppercase">Name</span>
                            </th>
                            <th class="px-4 py-4 text-center w-32">
                                <span class="text-xs font-black text-gray-700 uppercase">Usage</span>
                            </th>
                            <th class="px-4 py-4 text-center w-28">
                                <span class="text-xs font-black text-gray-700 uppercase">Status</span>
                            </th>
                            <th class="px-4 py-4 text-center w-32">
                                <span class="text-xs font-black text-gray-700 uppercase">Created</span>
                            </th>
                            <th class="px-4 py-4 text-center w-28">
                                <span class="text-xs font-black text-gray-700 uppercase">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($scentFamilies as $family)
                            <tr class="group hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-all duration-200"
                                data-id="{{ $family->id }}" data-status="{{ $family->is_active ? '1' : '0' }}">
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox"
                                        class="row-select w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500"
                                        value="{{ $family->id }}">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300">#{{ $family->id }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($family->imagekit_url)
                                        <img src="{{ $family->imagekit_thumbnail_url ?? $family->imagekit_url }}"
                                            alt="{{ $family->name }}"
                                            class="w-12 h-12 rounded-lg object-cover mx-auto border-2 border-gray-200">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center mx-auto border-2 border-purple-200">
                                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-bold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                        {{ $family->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold {{ $family->products_count > 0 ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-300' : 'bg-gradient-to-r from-gray-100 to-slate-100 text-gray-500 border border-gray-300' }}">
                                        {{ $family->products_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer status-toggle" data-id="{{ $family->id }}"
                                            data-field="is_active" {{ $family->is_active ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-green-400 peer-checked:to-emerald-500">
                                        </div>
                                    </label>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="text-xs text-gray-500 font-medium">{{ $family->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button
                                            class="edit-btn inline-flex items-center justify-center w-9 h-9 text-purple-600 bg-purple-50 border-2 border-purple-200 rounded-lg hover:bg-purple-100 hover:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                            title="Edit" data-id="{{ $family->id }}" data-name="{{ $family->name }}"
                                            data-description="{{ $family->description }}"
                                            data-is-active="{{ $family->is_active ? 'true' : 'false' }}"
                                            data-image-url="{{ $family->getImageUrl() }}"
                                            data-imagekit-file-id="{{ $family->imagekit_file_id }}"
                                            data-imagekit-url="{{ $family->imagekit_url }}"
                                            data-imagekit-thumbnail-url="{{ $family->imagekit_thumbnail_url }}"
                                            data-imagekit-file-path="{{ $family->imagekit_file_path }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="delete-btn inline-flex items-center justify-center w-9 h-9 text-red-600 bg-red-50 border-2 border-red-200 rounded-lg hover:bg-red-100 hover:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all"
                                            title="Delete" data-id="{{ $family->id }}" data-name="{{ $family->name }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyState">
                                <td colspan="8" class="px-6 py-20">
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex items-center justify-center w-24 h-24 bg-gradient-to-br from-purple-100 to-pink-200 rounded-full mb-6">
                                            <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Scent Families Found</h3>
                                        <p class="text-gray-500 mb-6">Start by creating your first scent family.</p>
                                        <button onclick="openAddModal()"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white text-sm font-bold rounded-xl hover:from-purple-600 hover:to-pink-700 shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create First Family
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-t border-gray-200">
                {{ $scentFamilies->links() }}
            </div>
        </div>
    </div>


    <!-- Add/Edit Modal -->
    <div id="scentFamilyModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form id="scentFamilyForm" method="POST" action="{{ route('admin.scent-families.store') }}">
                    @csrf
                    <input type="hidden" id="methodField" name="_method" value="POST">
                    <input type="hidden" id="scentFamilyId" name="scent_family_id">

                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Add New Scent Family</h3>
                            <button type="button" id="closeModalBtn"
                                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-all">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-6 space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                placeholder="Enter scent family name">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <div class="quill-editor-wrapper" id="descriptionSection">
                                <div id="descriptionEditor" style="height: 150px;"></div>
                            </div>
                            <textarea name="description" id="descriptionHidden" class="hidden"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Add a detailed description for this scent family</p>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Image</label>
                            <div id="uploadArea"
                                class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-purple-400 transition-all cursor-pointer">
                                <input type="file" id="imageInput" accept="image/*" class="hidden">
                                <div class="space-y-2">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <div id="imagePreview" class="hidden mt-4">
                                <div class="relative inline-block">
                                    <img id="previewImg" src="" alt="Preview"
                                        class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
                                    <button type="button" id="removeImageBtn"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="uploadProgress" class="hidden mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="progressBar" class="bg-purple-500 h-2 rounded-full transition-all"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Hidden fields for ImageKit -->
                            <input type="hidden" name="imagekit_file_id" id="imagekitFileId">
                            <input type="hidden" name="imagekit_url" id="imagekitUrl">
                            <input type="hidden" name="imagekit_thumbnail_url" id="imagekitThumbnailUrl">
                            <input type="hidden" name="imagekit_file_path" id="imagekitFilePath">
                            <input type="hidden" name="image_size" id="imageSize">
                            <input type="hidden" name="original_image_size" id="originalImageSize">
                            <input type="hidden" name="image_width" id="imageWidth">
                            <input type="hidden" name="image_height" id="imageHeight">
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div>
                                <label class="text-sm font-bold text-gray-700">Active Status</label>
                                <p class="text-xs text-gray-500">Enable to show this scent family</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-green-400 peer-checked:to-emerald-500">
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" id="cancelModalBtn"
                            class="px-6 py-2.5 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold rounded-xl hover:from-purple-600 hover:to-pink-700 shadow-lg transition-all flex items-center">
                            <span id="loadingSpinner" class="hidden mr-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            <span id="submitBtnText">Create</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Quill Editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    @include('admin.scent-families.scripts')
@endsection