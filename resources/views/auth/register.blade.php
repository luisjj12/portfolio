<x-guest-layout>
    <div class="flex flex-col w-full max-w-[940px] rounded-2xl overflow-hidden shadow-[0_16px_48px_rgba(0,0,0,0.12)] bg-white lg:flex-row">

        {{-- Panel izquierdo --}}
        <aside class="w-full lg:w-[220px] lg:min-w-[220px] bg-[#1F2A44] px-7 py-9 flex flex-col gap-8">

            <div>
                <x-application-logo class="w-12 h-12 text-white block mb-7" />
                <span class="block text-[10px] tracking-[0.25em] uppercase text-[#FF6F59] font-semibold mb-[10px]">
                    {{ __('Registro de cuenta') }}
                </span>
                <h2 class="text-[1.35rem] font-bold text-white leading-[1.3] m-0 mb-[10px]">
                    {{ __('Crea tu cuenta') }}
                </h2>
                <p class="text-[0.8rem] text-[rgba(255,255,255,0.45)] leading-[1.65] m-0">
                    {{ __('Completa tus datos para empezar a comprar en MiTienda.') }}
                </p>
            </div>

            <p class="text-[11px] text-[rgba(255,255,255,0.25)] m-0 mt-auto">
                {{ __('Tus datos están protegidos') }}
            </p>
        </aside>

        {{-- Formulario --}}
        <div class="flex-1 px-10 py-9 bg-white overflow-y-auto">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Datos personales --}}
                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-semibold m-0 mb-[14px]">{{ __('Datos personales') }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] mb-[14px]">
                    <div>
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" type="text" name="telefono" :value="old('telefono')" required autocomplete="tel"
                        inputmode="numeric" pattern="[0-9]{8,15}" title="Solo números, entre 9 y 15 dígitos"
                        class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                    <p class="text-xs text-gray-400 mt-1">Solo números, entre 9 y 15 dígitos (sin espacios, guiones ni el prefijo +).</p>
                    <x-input-error :messages="$errors->get('telefono')" class="mt-1" />
                </div>

                {{-- Dirección --}}
                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-semibold m-0 mb-[14px]">{{ __('Dirección') }}</p>

                <div class="mb-[14px]">
                    <x-input-label for="calle" :value="__('Calle')" />
                    <x-text-input id="calle" type="text" name="calle" :value="old('calle')" required
                        class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                    <x-input-error :messages="$errors->get('calle')" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] mb-[14px]">
                    <div>
                        <x-input-label for="ciudad" :value="__('Ciudad')" />
                        <x-text-input id="ciudad" type="text" name="ciudad" :value="old('ciudad')" required
                            class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                        <x-input-error :messages="$errors->get('ciudad')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="codigo_postal" :value="__('Código Postal')" />
                        <x-text-input id="codigo_postal" type="text" name="codigo_postal" :value="old('codigo_postal')" required
                            class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                        <x-input-error :messages="$errors->get('codigo_postal')" class="mt-1" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="pais" :value="__('País')" />
                    <x-text-input id="pais" type="text" name="pais" :value="old('pais')" required
                        class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] text-sm" />
                    <x-input-error :messages="$errors->get('pais')" class="mt-1" />
                </div>

                {{-- Seguridad --}}
                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-semibold m-0 mb-[14px]">{{ __('Seguridad') }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] mb-7">
                    <div x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <div class="relative">
                            <x-text-input id="password" :type="'password'" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" minlength="8"
                                class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] pr-9 text-sm" />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" tabindex="-1">
                                <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.774 3.162 10.066 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Mínimo 8 caracteres.</p>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>
                    <div x-data="{ show: false }">
                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                        <div class="relative">
                            <x-text-input id="password_confirmation" :type="'password'" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                                class="w-full mt-1 !rounded-lg !border !border-[#E5E7EB] px-3 py-[9px] pr-9 text-sm" />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" tabindex="-1">
                                <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.774 3.162 10.066 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-3 text-xs tracking-[0.15em] uppercase font-semibold text-white bg-[#2F6F4F] hover:bg-[#24573E] rounded-sm transition-colors focus:ring-2 focus:ring-[#C9A64A] focus:ring-offset-2">
                    {{ __('Registrarse') }}
                </button>

                <p class="text-center mt-[18px] text-sm text-gray-400">
                    <a
                        href="{{ route('login') }}"
                        class="text-gray-400 no-underline hover:text-[#2F6F4F] transition-colors">
                        {{ __('¿Ya tienes cuenta? Inicia sesión') }}
                    </a>
                </p>
            </form>
        </div>

    </div>
</x-guest-layout>
