{{-- sssssssssssssss --}}
<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-500 to-blue-700 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/cerebrologo.png') }}" alt="Cerebro Logo" class="h-12 w-auto mb-0">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('addpatient')" :active="request()->routeIs('addpatient')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Archive') }}
                    </x-nav-link>
                    <x-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.index')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Patients') }}
                    </x-nav-link>
                    <x-nav-link :href="route('files.index')" :active="request()->routeIs('files.index')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Files') }}
                    </x-nav-link>
                    <x-nav-link :href="route('archives.index')" :active="request()->routeIs('archives.index')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Zip') }}
                    </x-nav-link>
                    <x-nav-link :href="route('extract')" :active="request()->routeIs('extract')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Extract') }}
                    </x-nav-link>
                    <x-nav-link :href="route('setting')" :active="request()->routeIs('setting')"
                        class="font-semibold text-white hover:text-gray-200 transition ease-in-out duration-150">
                        {{ __('Settings') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-black">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('addpatient')" :active="request()->routeIs('addpatient')" class="font-bold text-black">
                {{ __('Archive') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.index')" class="font-bold text-black">
                {{ __('Patients') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('files.index')" :active="request()->routeIs('files.index')" class="font-bold text-black">
                {{ __('Files') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('archives.index')" :active="request()->routeIs('archives.index')" class="font-bold text-black">
                {{ __('Zip') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('extract')" :active="request()->routeIs('extract')" class="font-bold text-black">
                {{ __('Extract') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('setting')" :active="request()->routeIs('setting')" class="font-bold text-black">
                {{ __('Settings') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base
 text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-bold text-black">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="font-bold text-black">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
