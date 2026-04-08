<x-guest-layout>
    <style>
        .login-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }
        .login-bg::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(49, 64, 75, 0.03) 0%, transparent 60%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
            border-radius: 2rem;
        }
        .input-icon {
            color: #94a3b8;
        }
        .input-group:focus-within .input-icon {
            color: #31404B;
        }
        .btn-primary-custom {
            background: #31404B;
            color: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border: none;
        }
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(49, 64, 75, 0.2);
            background: #4B5D6B;
        }
        .btn-primary-custom:active {
            transform: scale(0.98);
        }
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .btn-loading .loading-text { display: none; }
        .btn-loading .loading-spinner { display: inline-block; }
    </style>

    <div class="login-bg min-h-screen flex flex-col justify-center items-center p-6">
        <div class="w-full max-w-md z-10">
            <!-- Title Section -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-black text-[#31404B] tracking-widest uppercase">SINPOL-RJ</h1>
                <div class="h-1 w-20 bg-[#FFCC00] mx-auto mt-2 rounded-full"></div>
                <h2 class="mt-6 text-xl font-medium text-[#4B5D6B]">Painel Administrativo</h2>
            </div>

            <!-- Login Card -->
            <div class="glass-card p-8 md:p-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login.do') }}" class="space-y-8" id="loginForm">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <label for="email" class="block text-xs font-bold text-[#31404B] uppercase tracking-wider mb-2 ml-1">Usuário / E-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#FFCC00] focus:border-transparent transition-all duration-300 text-[#31404B] placeholder-gray-400 outline-none"
                                placeholder="identificacao@sinpol.org.br">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password" class="block text-xs font-bold text-[#31404B] uppercase tracking-wider mb-2 ml-1">Senha de Acesso</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#FFCC00] focus:border-transparent transition-all duration-300 text-[#31404B] placeholder-gray-400 outline-none"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="flex justify-center py-2">
                        <div class="g-recaptcha" data-sitekey="{{ config('app.data_site_key') }}"></div>
                    </div>

                    <div class="flex flex-col gap-6 pt-4">
                        <button type="submit" id="btnSubmit" class="btn-primary-custom w-full py-4 rounded-2xl text-lg font-black tracking-widest shadow-lg flex items-center justify-center gap-3">
                            <span class="loading-text">IDENTIFICAR</span>
                            <div class="loading-spinner"></div>
                        </button>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-gray-500 hover:text-[#31404B] text-center transition-colors duration-300" href="{{ route('password.request') }}">
                                Problemas com o acesso?
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center">
                <p class="text-gray-400 text-xs font-bold flex items-center justify-center gap-2 uppercase tracking-tighter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Segurança SINPOL Protegida
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });
    </script>
</x-guest-layout>




