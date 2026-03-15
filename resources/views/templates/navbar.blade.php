@php
    $active_tab = 'home';
    $segment = request()->segment(1);
    if ($segment === 'clothing') {
        $active_tab = 'clothing';
    } elseif ($segment === 'footwear') {
        $active_tab = 'footwear';
    } elseif ($segment === 'accessories') {
        $active_tab = 'accessories';
    } elseif ($segment === 'activewear') {
        $active_tab = 'activewear';
    } elseif ($segment === 'grooming') {
        $active_tab = 'grooming';
    }
@endphp
<div
    class="navbar fixed top-0 left-0 z-50 bg-white h-[70px] border-b border-gray-200 w-full flex items-center px-4 md:px-8 shadow-sm">
    <!-- Left side (logo) -->
    <div class="logo flex items-center gap-2">
        <div class="w-10 h-10 bg-gradient-to-br from-[#4F39F6] to-[#6366F1] rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
        </div>
        <a href="/"
            class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#4F39F6] to-[#6366F1] bg-clip-text text-transparent">
            Morven
        </a>
    </div>

    <!-- Centered navs -->
    <div
        class="navs hidden lg:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 gap-1 bg-gray-100 rounded-full p-1">
        <a href="/"
            class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'home' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Home
        </a>
        <a href="/clothing"
            class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'clothing' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Clothing
        </a>
        <a href="/footwear"
            class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'footwear' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Footwear
        </a>
        <a href="/accessories"
            class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'accessories' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Accessories
        </a>
        <!-- <a href="/activewear" class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'activewear' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Active-wear
        </a> -->
        <a href="/grooming"
            class="nav-link px-4 py-2 rounded-full font-medium text-sm transition-all duration-200 {{ $active_tab === 'grooming' ? 'bg-[#4F39F6] text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            Grooming
        </a>
    </div>

    <!-- Right side icons -->
    <div class="user-icons flex items-center gap-2 ml-auto">
        <button onclick="openModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="w-5 h-5 text-gray-600">
                <path fill-rule="evenodd"
                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        @auth
            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-[#4F39F6] to-[#6366F1] rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                    style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            {{ Auth::user()->name }}
                            @if (Auth::user()->hasVerifiedEmail())
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Verified">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('my.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My
                        Orders</a>
                    <a href="{{ route('wishlist.index') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Wishlist</a>
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                    @if (!Auth::user()->hasVerifiedEmail())
                        <form method="POST" action="{{ route('verification.resend') }}"
                            class="border-t border-gray-100 mt-2 pt-2">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-[#4F39F6] hover:bg-[#4F39F6]/5 flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Verify Email
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-2 pt-2">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 cursor-pointer">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Login/Register Buttons -->
            <button onclick="Livewire.dispatch('showLoginModal')"
                class="hidden md:block px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#4F39F6] transition-colors cursor-pointer">
                Sign In
            </button>
            <button onclick="Livewire.dispatch('showRegisterModal')"
                class="hidden md:block px-4 py-2 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white text-sm font-medium rounded-lg transition-colors cursor-pointer">
                Sign Up
            </button>
        @endauth

        <livewire:shopping.details />

        <button class="md:hidden p-2 hover:bg-gray-100 rounded-full transition-colors mr-2 cursor-pointer"
            onclick="openSideNav()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <!-- Mobile Side Navigation -->
    <div id="sideNav"
        class="side-nav w-[280px] h-screen bg-white fixed top-0 left-0 z-[100] shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <div class="menu h-[70px] w-full border-b border-gray-200 p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-[#4F39F6] to-[#6366F1] rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-800">Menu</span>
            </div>
            <button class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer"
                onclick="closeSideNav()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="side-nav-content py-4 px-3 flex flex-col gap-2">
            <a href="/"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'home' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Home
            </a>
            <a href="/clothing"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'clothing' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Clothing
            </a>
            <a href="/footwear"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'footwear' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Footwear
            </a>
            <a href="/accessories"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'accessories' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Accessories
            </a>
            <a href="/activewear"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'activewear' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Activewear
            </a>
            <a href="/grooming"
                class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors {{ $active_tab === 'grooming' ? 'bg-[#4F39F6]/10 text-[#4F39F6]' : '' }}">
                Grooming
            </a>

            @guest
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <button onclick="Livewire.dispatch('showLoginModal'); closeSideNav();"
                        class="w-full px-4 py-3 text-left rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors">
                        Sign In
                    </button>
                    <button onclick="Livewire.dispatch('showRegisterModal'); closeSideNav();"
                        class="w-full px-4 py-3 text-left rounded-xl font-medium text-white bg-[#4F39F6] hover:bg-[#3d2bc4] transition-colors mt-2">
                        Sign Up
                    </button>
                </div>
            @endguest

            @auth
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <a href="{{ route('my.orders') }}"
                        class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors block">
                        My Orders
                    </a>
                    <a href="{{ route('wishlist.index') }}"
                        class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors block">
                        My Wishlist
                    </a>
                    <a href="{{ route('profile.show') }}"
                        class="px-4 py-3 rounded-xl font-medium text-gray-700 hover:bg-gray-100 hover:text-[#4F39F6] transition-colors block">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-xl font-medium text-red-600 hover:bg-red-50 transition-colors">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Side Navigation Overlay -->
    <div id="sideNavOverlay"
        class="fixed inset-0 bg-black/50 z-[99] opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out">
    </div>

    <!-- Search Modal -->
    <div id="searchModal" onclick="if(event.target.id === 'searchModal') closeModal()"
        class="fixed inset-0 z-[60] bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl p-6 rounded-2xl shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Search Products</h3>
                <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @livewire('product-search')
        </div>
    </div>
</div>

<script>
    function openSideNav() {
        const sideNav = document.getElementById('sideNav');
        const overlay = document.getElementById('sideNavOverlay');

        // Show the side navigation
        sideNav.classList.remove('-translate-x-full');
        sideNav.classList.add('translate-x-0');

        // Show the overlay
        overlay.classList.remove('pointer-events-none', 'opacity-0');
        overlay.classList.add('pointer-events-auto', 'opacity-100');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeSideNav() {
        const sideNav = document.getElementById('sideNav');
        const overlay = document.getElementById('sideNavOverlay');

        // Hide the side navigation
        sideNav.classList.remove('translate-x-0');
        sideNav.classList.add('-translate-x-full');

        // Hide the overlay
        overlay.classList.remove('pointer-events-auto', 'opacity-100');
        overlay.classList.add('pointer-events-none', 'opacity-0');

        // Restore body scroll
        document.body.style.overflow = '';
    }

    // Close side nav when clicking on overlay
    document.getElementById('sideNavOverlay').addEventListener('click', closeSideNav);

    // Close side nav when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSideNav();
        }
    });

    function openModal() {
        const modal = document.getElementById('searchModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Focus on the search input after modal opens
        setTimeout(() => {
            const input = modal.querySelector('input[type="text"]');
            if (input) input.focus();
        }, 100);
    }

    function closeModal() {
        document.getElementById('searchModal').classList.remove('flex');
        document.getElementById('searchModal').classList.add('hidden');
    }

    // Listen for Livewire event to close search modal
    document.addEventListener('livewire:init', () => {
        Livewire.on('close-search-modal', () => {
            closeModal();
        });
    });
</script>
