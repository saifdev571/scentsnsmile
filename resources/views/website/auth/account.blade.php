@extends('layouts.app')

@section('title', $pageTitle ?? 'My Account - Scents N Smile')

@section('content')
<div class="bg-gray-100 min-h-screen pt-20 lg:pt-24">
    <!-- Mobile Header - removed sticky, added margin top -->
    <div class="lg:hidden bg-white shadow-sm mx-4 rounded-lg mb-4">
        <div class="flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">My Account</h1>
            <div class="w-6"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg" id="successAlert">
            <div class="flex items-center justify-between">
                <p>{{ session('success') }}</p>
                <button onclick="document.getElementById('successAlert').remove()" class="text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r-lg" id="errorAlert">
            <div class="flex items-center justify-between">
                <p>{{ session('error') }}</p>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
            <!-- Left Sidebar - Desktop -->
            <div class="hidden lg:block w-72 flex-shrink-0">
                <!-- User Profile Card -->
                <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#e8a598] to-[#F27F6E] p-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-[#e8a598] text-2xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="text-white">
                                <p class="text-sm opacity-90">Hello,</p>
                                <p class="font-semibold text-lg">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- My Orders -->
                    <a href="{{ route('user.orders') }}" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                        <div class="w-10 h-10 bg-[#e8a598]/10 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#e8a598]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">My Orders</p>
                            <p class="text-xs text-gray-500">Track, return, or buy again</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Account Settings -->
                    <div class="border-b border-gray-100">
                        <button onclick="toggleSection('accountSettings')" class="w-full flex items-center gap-4 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-[#e8a598]/10 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#e8a598]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="font-medium text-gray-900">Account Settings</p>
                            </div>
                            <svg id="accountSettingsIcon" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="accountSettingsMenu" class="hidden bg-gray-50">
                            <a href="#profile" onclick="showTab('profile')" class="block px-4 py-2 pl-16 text-sm text-gray-600 hover:text-[#e8a598] hover:bg-gray-100">Profile Information</a>
                            <a href="#addresses" onclick="showTab('addresses')" class="block px-4 py-2 pl-16 text-sm text-gray-600 hover:text-[#e8a598] hover:bg-gray-100">Manage Addresses</a>
                        </div>
                    </div>

                    <!-- Logout -->
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 hover:bg-red-50 transition-colors text-left">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <p class="font-medium text-red-600">Logout</p>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile User Card & Quick Links -->
            <div class="lg:hidden space-y-3">
                <!-- User Card -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-lg text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400">{{ $user->phone ?? 'Add phone number' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.orders') }}" class="bg-white rounded-lg shadow-sm p-4 flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-[#e8a598]/10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#e8a598]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Orders</span>
                    </a>
                    <a href="#wishlist" class="bg-white rounded-lg shadow-sm p-4 flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Wishlist</span>
                    </a>
                    <button onclick="showTab('addresses')" class="bg-white rounded-lg shadow-sm p-4 flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Addresses</span>
                    </button>
                    <button onclick="showTab('profile')" class="bg-white rounded-lg shadow-sm p-4 flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Profile</span>
                    </button>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="flex-1 space-y-4">

                <!-- Profile Information Tab -->
                <div id="profileTab" class="bg-white rounded-lg shadow-sm">
                    <div class="border-b border-gray-100 px-4 py-4 lg:px-6">
                        <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
                        <p class="text-sm text-gray-500 mt-1">Update your personal details here</p>
                    </div>
                    <form action="{{ route('user.profile.update') }}" method="POST" class="p-4 lg:p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ $user->email }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 py-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-600 text-sm">
                                        +91
                                    </span>
                                    <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" 
                                           placeholder="Enter mobile number"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <div class="flex gap-4 mt-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="gender" value="male" {{ ($user->gender ?? '') == 'male' ? 'checked' : '' }}
                                               class="w-4 h-4 text-[#e8a598] focus:ring-[#e8a598]">
                                        <span class="text-sm text-gray-700">Male</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="gender" value="female" {{ ($user->gender ?? '') == 'female' ? 'checked' : '' }}
                                               class="w-4 h-4 text-[#e8a598] focus:ring-[#e8a598]">
                                        <span class="text-sm text-gray-700">Female</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] text-white font-medium rounded-lg hover:opacity-90 transition-opacity">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="border-b border-gray-100 px-4 py-4 lg:px-6">
                        <h2 class="text-lg font-semibold text-gray-900">Change Password</h2>
                        <p class="text-sm text-gray-500 mt-1">Ensure your account is using a secure password</p>
                    </div>
                    <form action="{{ route('user.password.update') }}" method="POST" class="p-4 lg:p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="currentPassword" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors pr-12">
                                    <button type="button" onclick="togglePassword('currentPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="newPassword" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors pr-12">
                                    <button type="button" onclick="togglePassword('newPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="confirmPassword" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors pr-12">
                                    <button type="button" onclick="togglePassword('confirmPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Addresses Tab -->
                <div id="addressesTab" class="bg-white rounded-lg shadow-sm hidden">
                    <div class="border-b border-gray-100 px-4 py-4 lg:px-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Manage Addresses</h2>
                            <p class="text-sm text-gray-500 mt-1">Add or edit your delivery addresses</p>
                        </div>
                        <button onclick="openAddressModal()" class="px-4 py-2 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] text-white text-sm font-medium rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add New
                        </button>
                    </div>
                    <div class="p-4 lg:p-6">
                        @if($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($addresses as $address)
                            <div class="border border-gray-200 rounded-lg p-4 relative {{ $address->is_default ? 'border-[#e8a598] bg-[#e8a598]/5' : '' }}">
                                @if($address->is_default)
                                <span class="absolute top-2 right-2 bg-[#e8a598] text-white text-xs px-2 py-1 rounded">Default</span>
                                @endif
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        @if($address->type == 'home')
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        @else
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-gray-900">{{ $address->name }}</span>
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase">{{ $address->type ?? 'Home' }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1">{{ $address->phone }}</p>
                                        <p class="text-sm text-gray-500 line-clamp-2">
                                            {{ $address->address_line_1 }}, 
                                            @if($address->address_line_2) {{ $address->address_line_2 }}, @endif
                                            {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-4 pt-3 border-t border-gray-100">
                                    <button onclick="editAddress({{ $address->id }})" class="text-sm text-[#e8a598] font-medium hover:underline">Edit</button>
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('user.address.delete', $address->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 font-medium hover:underline">Remove</button>
                                    </form>
                                    @if(!$address->is_default)
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('user.address.default', $address->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-500 font-medium hover:underline">Set as Default</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No addresses saved</h3>
                            <p class="text-gray-500 mb-4">Add your first delivery address</p>
                            <button onclick="openAddressModal()" class="px-6 py-2 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] text-white font-medium rounded-lg hover:opacity-90 transition-opacity">
                                Add Address
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Mobile Logout Button -->
                <div class="lg:hidden">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-white text-red-600 font-medium rounded-lg shadow-sm hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Address Modal -->
<div id="addressModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeAddressModal()"></div>
    <div class="absolute inset-x-4 top-1/2 -translate-y-1/2 max-w-lg mx-auto bg-white rounded-xl shadow-xl max-h-[90vh] overflow-y-auto lg:inset-x-auto">
        <div class="sticky top-0 bg-white border-b border-gray-100 px-4 py-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900" id="addressModalTitle">Add New Address</h3>
            <button onclick="closeAddressModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="addressForm" action="{{ route('user.address.store') }}" method="POST" class="p-4">
            @csrf
            <input type="hidden" name="_method" id="addressMethod" value="POST">
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="addressName" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <input type="tel" name="phone" id="addressPhone" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pincode</label>
                        <input type="text" name="pincode" id="addressPincode" required maxlength="6"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city" id="addressCity" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                    <input type="text" name="address_line_1" id="addressLine1" required placeholder="House No., Building Name"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                    <input type="text" name="address_line_2" id="addressLine2" placeholder="Street, Area, Landmark"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input type="text" name="state" id="addressState" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer px-4 py-2 border border-gray-300 rounded-lg has-[:checked]:border-[#e8a598] has-[:checked]:bg-[#e8a598]/5">
                            <input type="radio" name="type" value="home" checked class="w-4 h-4 text-[#e8a598] focus:ring-[#e8a598]">
                            <span class="text-sm">Home</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer px-4 py-2 border border-gray-300 rounded-lg has-[:checked]:border-[#e8a598] has-[:checked]:bg-[#e8a598]/5">
                            <input type="radio" name="type" value="work" class="w-4 h-4 text-[#e8a598] focus:ring-[#e8a598]">
                            <span class="text-sm">Work</span>
                        </label>
                    </div>
                </div>
                
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_default" id="addressDefault" class="w-4 h-4 text-[#e8a598] focus:ring-[#e8a598] rounded">
                    <span class="text-sm text-gray-700">Make this my default address</span>
                </label>
            </div>
            
            <div class="mt-6 flex gap-3">
                <button type="button" onclick="closeAddressModal()" class="flex-1 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] text-white font-medium rounded-lg hover:opacity-90 transition-opacity">
                    Save Address
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Toggle sidebar section
    function toggleSection(section) {
        const menu = document.getElementById(section + 'Menu');
        const icon = document.getElementById(section + 'Icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Show tab
    function showTab(tab) {
        const profileTab = document.getElementById('profileTab');
        const addressesTab = document.getElementById('addressesTab');
        
        if (tab === 'profile') {
            profileTab.classList.remove('hidden');
            addressesTab.classList.add('hidden');
        } else if (tab === 'addresses') {
            profileTab.classList.add('hidden');
            addressesTab.classList.remove('hidden');
        }
        
        // Scroll to top on mobile
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Address Modal
    function openAddressModal() {
        document.getElementById('addressModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Reset form
        document.getElementById('addressForm').reset();
        document.getElementById('addressForm').action = "{{ route('user.address.store') }}";
        document.getElementById('addressMethod').value = 'POST';
        document.getElementById('addressModalTitle').textContent = 'Add New Address';
    }

    function closeAddressModal() {
        document.getElementById('addressModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function editAddress(id) {
        // Fetch address data and populate form
        fetch('/account/addresses/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const address = data.address;
                    document.getElementById('addressName').value = address.name;
                    document.getElementById('addressPhone').value = address.phone;
                    document.getElementById('addressPincode').value = address.pincode;
                    document.getElementById('addressCity').value = address.city;
                    document.getElementById('addressLine1').value = address.address_line_1;
                    document.getElementById('addressLine2').value = address.address_line_2 || '';
                    document.getElementById('addressState').value = address.state;
                    document.getElementById('addressDefault').checked = address.is_default;
                    
                    // Set form action for update
                    document.getElementById('addressForm').action = '/account/addresses/' + id;
                    document.getElementById('addressMethod').value = 'PUT';
                    document.getElementById('addressModalTitle').textContent = 'Edit Address';
                    
                    openAddressModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load address details');
            });
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddressModal();
        }
    });

    // Initialize - show addresses tab if hash is #addresses
    if (window.location.hash === '#addresses') {
        showTab('addresses');
    }
</script>
@endpush
