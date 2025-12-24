<x-guest-layout>
    <div class="max-w-md mx-auto mt-16 text-center">

    <h1 class="text-3xl font-bold mb-10">ユーザーログイン画面</h1>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

         <div class="mb-6 text-left">
                <x-input-label for="email" :value="__('アドレス')" />
                <x-text-input id="email" class="block mt-1 w-full"
                    type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-10 text-left">
                <x-input-label for="password" :value="__('パスワード')" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-between items-center mt-8">

             <a href="{{ route('register') }}"
                   class="px-6 py-2 rounded-full  text-black font-bold">
                    新規登録
            </a>

            <button type="submit"
                        class="px-8 py-2 rounded-full  text-black font-bold">
                    ログイン
            </button>
    
        </div>
    </form>
</x-guest-layout>
