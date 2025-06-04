<header
    class="sticky top-0 z-50 backdrop-blur bg-gray-900/80 shadow-md flex flex-wrap lg:justify-start lg:flex-nowrap z-50 w-full py-5">
    <nav
        class="relative max-w-7xl w-full flex flex-wrap lg:grid lg:grid-cols-12 basis-full items-center px-4 md:px-6 lg:px-8 mx-auto">
        <div class="lg:col-span-3 flex items-center">
            <!-- Logo -->
            <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-hidden focus:opacity-80"
               href="{{ route('home') }}" aria-label="IRCP">
                <svg class="w-30 h-auto" width="116" height="50" viewBox="0 0 116 32" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <g id="logogram" transform="translate(0, 1) rotate(0)">
                        <path class="fill-blue-500 dark:fill-blue-500" fill="currentColor"
                              d="M12.2749 24.7064V34.7473C12.2749 35.1322 12.122 35.5014 11.8498 35.7734C11.5778 36.0456 11.2086 36.1985 10.8237 36.1985C10.4388 36.1985 10.0697 36.0456 9.79748 35.7734C9.52528 35.5014 9.37238 35.1322 9.37238 34.7473V24.7203C9.77651 25.0154 10.2609 25.1801 10.7612 25.1925C11.3064 25.208 11.8407 25.0365 12.2749 24.7064ZM24.6351 21.8038C24.2668 21.8038 23.9135 21.9502 23.6531 22.2106C23.3927 22.471 23.2463 22.8243 23.2463 23.1926V24.9425C23.2463 25.3275 23.3992 25.6966 23.6714 25.9687C23.9434 26.2409 24.3126 26.3938 24.6976 26.3938C25.0825 26.3938 25.4517 26.2409 25.7237 25.9687C25.9959 25.6966 26.1488 25.3275 26.1488 24.9425V23.2621C26.1597 23.0629 26.1274 22.8638 26.0544 22.6782C25.9813 22.4927 25.8693 22.3249 25.7255 22.1866C25.5819 22.0483 25.4101 21.9424 25.2221 21.8763C25.0339 21.8104 24.8337 21.7856 24.6351 21.8038ZM6.21985 28.5116C5.72012 28.4966 5.23635 28.3322 4.83107 28.0395V38.1081C4.83107 38.4949 4.98469 38.8658 5.25817 39.1393C5.53164 39.4127 5.90254 39.5663 6.28928 39.5663C6.67603 39.5663 7.04693 39.4127 7.3204 39.1393C7.59388 38.8658 7.7475 38.4949 7.7475 38.1081V28.1089C7.294 28.4021 6.75891 28.5432 6.21985 28.5116ZM20.1076 18.7902C19.9195 18.7807 19.7314 18.8098 19.5548 18.8753C19.3783 18.9409 19.2169 19.0417 19.0804 19.1715C18.944 19.3015 18.8355 19.4578 18.7614 19.631C18.6873 19.8041 18.6491 19.9907 18.6494 20.179V27.9145C18.6494 28.3012 18.803 28.6722 19.0765 28.9456C19.3501 29.2191 19.7209 29.3727 20.1076 29.3727C20.4944 29.3727 20.8654 29.2191 21.1388 28.9456C21.4123 28.6722 21.5659 28.3012 21.5659 27.9145V20.2762C21.577 20.0758 21.5445 19.8754 21.4706 19.6887C21.3967 19.5021 21.2834 19.3336 21.1381 19.195C20.9928 19.0564 20.8194 18.9509 20.6295 18.8859C20.4397 18.8207 20.2379 18.7975 20.0382 18.818L20.1076 18.7902ZM15.4969 21.7622C14.9737 21.7586 14.4646 21.5937 14.0387 21.29V31.3864C14.0387 31.7732 14.1923 32.1441 14.4657 32.4176C14.7393 32.691 15.1101 32.8446 15.4969 32.8446C15.8837 32.8446 16.2545 32.691 16.5281 32.4176C16.8015 32.1441 16.9551 31.7732 16.9551 31.3864V21.3039C16.5146 21.632 15.9767 21.8031 15.4275 21.79L15.4969 21.7622ZM3.06732 29.4977V1.29157C3.06366 0.947745 2.92451 0.619271 2.68008 0.377443C2.43566 0.135614 2.1057 -1.38867e-05 1.76186 1.06644e-09H1.45633C1.1125 -1.38867e-05 0.782538 0.135614 0.538112 0.377443C0.293687 0.619271 0.154531 0.947745 0.150879 1.29157V29.4977C0.150879 29.8439 0.288424 30.176 0.533238 30.4208C0.778052 30.6656 1.11011 30.8031 1.45633 30.8031H1.76186C2.1081 30.8031 2.44014 30.6656 2.68496 30.4208C2.92978 30.176 3.06732 29.8439 3.06732 29.4977ZM6.37261 27.4423H6.06708C5.72086 27.4423 5.3888 27.3048 5.14399 27.06C4.89917 26.8151 4.76163 26.4831 4.76163 26.1368V4.65241C4.76529 4.30861 4.90444 3.9801 5.14886 3.73829C5.39329 3.49646 5.72325 3.36083 6.06708 3.36085H6.37261C6.71644 3.36083 7.0464 3.49646 7.29083 3.73829C7.53525 3.9801 7.67441 4.30861 7.67806 4.65241V26.1646C7.67806 26.5108 7.54052 26.8429 7.29571 27.0877C7.05089 27.3326 6.71883 27.4701 6.37261 27.4701V27.4423ZM10.9695 24.137H10.6501C10.3076 24.137 9.97899 24.0009 9.73679 23.7587C9.49459 23.5165 9.35849 23.188 9.35849 22.8454V7.98548C9.35668 7.8147 9.38876 7.64526 9.45278 7.48695C9.51681 7.32865 9.61166 7.18463 9.73179 7.06322C9.85192 6.94182 9.99497 6.84543 10.1526 6.77966C10.3102 6.71389 10.4792 6.68002 10.6501 6.68003H10.9695C11.3133 6.6837 11.6418 6.82284 11.8836 7.06726C12.1255 7.31169 12.261 7.64165 12.261 7.98548V22.8454C12.261 23.188 12.1249 23.5165 11.8827 23.7587C11.6405 24.0009 11.3121 24.137 10.9695 24.137ZM15.5663 20.7345H15.2747C14.9308 20.7345 14.6009 20.5989 14.3564 20.357C14.112 20.1152 13.9728 19.7868 13.9692 19.4429V11.4435C13.9578 11.2652 13.9831 11.0865 14.0437 10.9183C14.1041 10.7503 14.1985 10.5962 14.3209 10.4661C14.4432 10.3359 14.591 10.2323 14.7551 10.1614C14.9192 10.0907 15.096 10.0543 15.2747 10.0548H15.5802C15.9264 10.0548 16.2585 10.1923 16.5033 10.4371C16.7482 10.6819 16.8857 11.014 16.8857 11.3602V19.4151C16.8875 19.5878 16.8551 19.759 16.7903 19.919C16.7255 20.079 16.6297 20.2245 16.5082 20.3473C16.3868 20.4699 16.2424 20.5673 16.083 20.6338C15.9237 20.7003 15.7528 20.7345 15.5802 20.7345H15.5663ZM20.1771 17.7486H19.8715C19.5253 17.7486 19.1933 17.6111 18.9484 17.3663C18.7036 17.1214 18.5661 16.7894 18.5661 16.4432V14.3739C18.5697 14.03 18.7089 13.7016 18.9533 13.4598C19.1977 13.2178 19.5277 13.0823 19.8715 13.0823H20.1771C20.5209 13.0823 20.8509 13.2178 21.0953 13.4598C21.3398 13.7016 21.4789 14.03 21.4825 14.3739V16.4432C21.4825 16.787 21.347 17.117 21.1051 17.3614C20.8633 17.6058 20.5348 17.745 20.191 17.7486H20.1771Z"/>
                    </g>
                    <g id="logotype" transform="translate(33, 8)">
                        <path class="fill-black dark:fill-white"
                              d="M8.31 0.54L13.52 0.54L13.52 26L8.31 26L8.31 0.54ZM21.07 26L15.86 26L15.86 0.54L25.79 0.54Q28.69 0.54 30.73 1.56Q32.76 2.59 33.83 4.45Q34.90 6.31 34.90 8.82L34.90 8.82Q34.90 11.34 33.81 13.16Q32.73 14.98 30.67 15.94Q28.61 16.91 25.67 16.91L25.67 16.91L18.93 16.91L18.93 12.69L24.83 12.69Q26.44 12.69 27.46 12.25Q28.49 11.82 29.00 10.95Q29.51 10.09 29.51 8.82L29.51 8.82Q29.51 7.53 29.00 6.65Q28.49 5.77 27.45 5.30Q26.42 4.84 24.81 4.84L24.81 4.84L21.07 4.84L21.07 26ZM35.80 26L30.03 26L23.82 14.41L29.48 14.41L35.80 26ZM47.70 26.34L47.70 26.34Q44.31 26.34 41.64 24.80Q38.96 23.27 37.42 20.34Q35.87 17.42 35.87 13.29L35.87 13.29Q35.87 9.13 37.42 6.20Q38.98 3.27 41.66 1.73Q44.35 0.19 47.70 0.19L47.70 0.19Q49.87 0.19 51.74 0.80Q53.61 1.41 55.06 2.57Q56.51 3.73 57.44 5.42Q58.36 7.10 58.65 9.23L58.65 9.23L53.37 9.23Q53.20 8.19 52.71 7.38Q52.22 6.57 51.50 6.00Q50.77 5.42 49.83 5.12Q48.89 4.83 47.80 4.83L47.80 4.83Q45.82 4.83 44.31 5.82Q42.81 6.81 41.99 8.70Q41.17 10.58 41.17 13.29L41.17 13.29Q41.17 16.04 42.00 17.92Q42.84 19.80 44.33 20.75Q45.82 21.71 47.78 21.71L47.78 21.71Q48.87 21.71 49.81 21.41Q50.74 21.11 51.48 20.54Q52.22 19.97 52.71 19.15Q53.20 18.33 53.39 17.30L53.39 17.30L58.67 17.30Q58.46 19.06 57.62 20.69Q56.77 22.31 55.37 23.59Q53.97 24.87 52.04 25.61Q50.10 26.34 47.70 26.34ZM65.40 26L60.19 26L60.19 0.54L70.11 0.54Q73.02 0.54 75.05 1.64Q77.09 2.74 78.16 4.68Q79.22 6.62 79.22 9.13L79.22 9.13Q79.22 11.66 78.14 13.58Q77.05 15.51 74.99 16.59Q72.93 17.68 70.00 17.68L70.00 17.68L63.60 17.68L63.60 13.47L69.16 13.47Q70.76 13.47 71.80 12.92Q72.83 12.36 73.34 11.39Q73.84 10.41 73.84 9.13L73.84 9.13Q73.84 7.85 73.34 6.88Q72.83 5.90 71.79 5.37Q70.75 4.84 69.14 4.84L69.14 4.84L65.40 4.84L65.40 26Z"/>
                    </g>

                </svg>
            </a>
            <!-- End Logo -->
        </div>

        <!-- Button Group -->
        <div class="flex items-center gap-x-1 lg:gap-x-2 ms-auto py-1 lg:ps-6 lg:order-3 lg:col-span-3">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <flux:dropdown position="top" align="end">
                            <flux:profile
                                class="cursor-pointer"
                                :initials="auth()->user()->initials()"
                            />

                            <flux:menu>
                                <flux:menu.radio.group>
                                    <div class="p-0 text-sm font-normal">
                                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                            <div class="grid flex-1 text-start text-sm leading-tight">
                                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </flux:menu.radio.group>

                                <flux:menu.separator/>
                                @if(auth()->user()->isAdmin)
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('admin.dashboard')" icon="layout-grid"
                                                        wire:navigate>{{ __('Tableau de bord') }}</flux:menu.item>
                                    </flux:menu.radio.group>
                                @else
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('moncompte.etablissement')" icon="layout-grid"
                                                        wire:navigate>{{ __('Mon Tableau de bord') }}</flux:menu.item>
                                    </flux:menu.radio.group>
                                @endif


                                <flux:menu.separator/>

                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                                    class="w-full">
                                        {{ __('Se déconnecter') }}
                                    </flux:menu.item>
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    @else
                        <flux:navlist.item icon="log-in" href="{{ route('login') }}"
                        >
                            {{ __('Se connecter') }}
                        </flux:navlist.item>

                    @endauth
                </nav>
            @endif

            <div class="lg:hidden">
                <button type="button"
                        class="hs-collapse-toggle size-9.5 flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-black hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        id="hs-navbar-hcail-collapse" aria-expanded="false" aria-controls="hs-navbar-hcail"
                        aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-hcail">
                    <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6"/>
                        <line x1="3" x2="21" y1="12" y2="12"/>
                        <line x1="3" x2="21" y1="18" y2="18"/>
                    </svg>
                    <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                         width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- End Button Group -->

        <!-- Collapse -->
        <div id="hs-navbar-hcail"
             class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow lg:block lg:w-auto lg:basis-auto lg:order-2 lg:col-span-6"
             aria-labelledby="hs-navbar-hcail-collapse">
            <div
                class="flex flex-col gap-y-4 gap-x-0 mt-5 lg:flex-row lg:justify-center lg:items-center lg:gap-y-0 lg:gap-x-7 lg:mt-0">

                <flux:navlist class="lg:flex-row lg:items-center">
                    <flux:navlist.item href="{{ route('home') }}" class="text-white hover:text-indigo-400 hover:bg-gray-100/10 dark:hover:bg-neutral-700/30 rounded-md px-2 py-1 {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : '' }}">
                        Accueil
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('centres') }}" class="text-white hover:text-indigo-400 hover:bg-gray-100/10 dark:hover:bg-neutral-700/30 rounded-md px-2 py-1 {{ request()->routeIs('centres') || request()->routeIs('centre.details') ? 'bg-blue-600 text-white' : '' }}">
                        Centre acrédité
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('search') }}" class="text-white hover:text-indigo-400 hover:bg-gray-100/10 dark:hover:bg-neutral-700/30 rounded-md px-2 py-1 {{ request()->routeIs('search') ? 'bg-blue-600 text-white' : '' }}">
                        Les certificats
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('about') }}" class="text-white hover:text-indigo-400 hover:bg-gray-100/10 dark:hover:bg-neutral-700/30 rounded-md px-2 py-1 {{ request()->routeIs('about') ? 'bg-blue-600 text-white' : '' }}">
                        À propos
                    </flux:navlist.item>

                    <flux:navlist.item href="{{ route('contact') }}" class="text-white hover:text-indigo-400 hover:bg-gray-100/10 dark:hover:bg-neutral-700/30 rounded-md px-2 py-1 {{ request()->routeIs('contact') ? 'bg-blue-600 text-white' : '' }}">
                        Contact
                    </flux:navlist.item>
                </flux:navlist>
            </div>

        </div>
        <!-- End Collapse -->
    </nav>

</header>
