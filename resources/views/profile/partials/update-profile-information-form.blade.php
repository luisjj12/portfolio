<section>

    {{-- ============================================================
         CABECERA DE SECCIÓN
    ============================================================ --}}
    <header class="flex items-start justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 tracking-tight">
                {{ __('Información del perfil') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Actualiza tu nombre y datos de contacto de la cuenta.') }}
            </p>
        </div>

        {{-- Insignia de estado de la cuenta, al estilo "Tu cuenta" de Amazon --}}
        <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-teal-100 px-3 py-1 text-xs font-medium text-teal-800 ring-1 ring-inset ring-teal-600/20">
            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            {{ __('Cuenta activa') }}
        </span>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8">
        @csrf
        @method('patch')

        {{-- ========================================================
             AVATAR CON INICIAL
             Solo visual: muestra la primera letra del nombre.
             Sin subida de foto, ya que la app no maneja ese campo.
        ======================================================== --}}
        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-gray-800 text-xl font-semibold text-white select-none">
                {{ $user->nombre ? mb_strtoupper(mb_substr($user->nombre, 0, 1)) : '?' }}
            </span>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $user->nombre ?: __('Sin nombre') }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        {{-- ========================================================
             DATOS BÁSICOS
        ======================================================== --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Teléfono (opcional)')" />
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '')" autocomplete="tel" placeholder="+34 600 000 000" />
                <p class="mt-1 text-xs text-gray-500">{{ __('Se usa solo para verificación de pedidos y avisos de seguridad.') }}</p>
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        {{-- ========================================================
             CORREO ELECTRÓNICO Y VERIFICACIÓN
        ======================================================== --}}
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm">
                        <p class="text-amber-800">
                            {{ __('Tu dirección de correo no está verificada.') }}
                            <button form="send-verification" class="font-medium underline decoration-amber-400 underline-offset-2 hover:text-amber-900 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                {{ __('Reenviar correo de verificación.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 font-medium text-teal-700">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- ========================================================
             INFORMACIÓN DE SOLO LECTURA (contexto tipo "Tu cuenta")
        ======================================================== --}}
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 rounded-lg bg-gray-50 p-4 text-sm">
            <div>
                <dt class="text-gray-500">{{ __('Cliente desde') }}</dt>
                <dd class="mt-0.5 font-medium text-gray-900">{{ $user->created_at?->translatedFormat('d \d\e F \d\e Y') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">{{ __('ID de cuenta') }}</dt>
                <dd class="mt-0.5 font-medium text-gray-900">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</dd>
            </div>
        </dl>

        {{-- ========================================================
             ACCIONES
        ======================================================== --}}
        <div class="flex items-center gap-4 pt-2">
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-full bg-gradient-to-b from-yellow-300 to-yellow-400 px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-yellow-500/40 transition hover:from-yellow-400 hover:to-yellow-500 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
            >
                {{ __('Guardar cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-teal-700"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>