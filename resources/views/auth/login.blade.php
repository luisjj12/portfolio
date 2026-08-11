<x-guest-layout>
    <!-- Estado de sesión -->
    <x-auth-session-status class="mb-4 max-w-sm mx-auto text-sm text-[#2F6F4F]" :status="session('status')" />

    <div class="min-h-[80vh] flex items-center justify-center bg-[#EEF1F4] px-4 py-12">
        <div class="w-full max-w-sm">

            <!-- Tarjeta con barra de firma superior -->
            <div class="bg-white rounded-sm shadow-[0_1px_3px_rgba(20,33,61,0.10)] overflow-hidden">
                <div class="h-1 bg-[#2F6F4F]"></div>

                <div class="px-8 pt-8 pb-9">
                    <p class="text-[11px] tracking-[0.2em] uppercase text-[#C9A64A] font-semibold mb-2">
                        {{ __('Acceso') }}
                    </p>
                    <h1 class="font-serif text-4xl text-[#14213D] mb-8">
                        {{ __('Iniciar sesión') }}
                    </h1>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Correo electrónico -->
                        <div class="mb-7">
                            <x-input-label for="email" :value="__('Correo electrónico')" class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold" />
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full bg-transparent border-0 border-b-2 border-gray-200 focus:border-[#2F6F4F] focus:ring-0 rounded-none px-0 py-2 mt-2 text-[#14213D] placeholder-gray-400"
                            />
                            <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-2" />
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-8">
                            <x-input-label for="password" :value="__('Contraseña')" class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold" />
                            <x-text-input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="w-full bg-transparent border-0 border-b-2 border-gray-200 focus:border-[#2F6F4F] focus:ring-0 rounded-none px-0 py-2 mt-2 text-[#14213D]"
                            />
                            <x-input-error :messages="$errors->get('password')" class="text-xs text-red-600 mt-2" />
                        </div>

                        <!-- Botón de iniciar sesión -->
                        <x-primary-button
                            class="w-full py-3 text-xs tracking-[0.15em] uppercase font-semibold text-white bg-[#2F6F4F] hover:bg-[#24573E] rounded-sm transition-colors focus:ring-2 focus:ring-[#C9A64A] focus:ring-offset-2"
                        >
                            {{ __('Entrar') }}
                        </x-primary-button>
                    </form>

                    <!-- Enlaces existentes, sólo restilizados -->
                    <div class="flex items-center justify-center gap-3 mt-7 text-xs text-gray-500">
                        @if (Route::has('password.request'))
                            <x-button-link href="{{ route('password.request') }}" class="hover:text-[#C9A64A] transition-colors">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </x-button-link>
                            <span class="text-gray-300">•</span>
                        @endif
                        <x-button-link href="{{ route('register') }}" class="hover:text-[#C9A64A] transition-colors">
                            {{ __('Crear cuenta') }}
                        </x-button-link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>