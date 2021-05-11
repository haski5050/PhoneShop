<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Дякуєм за реєстрацію! Перед початком, чи не могли б ви підтвердити email по кліку на посилання яке ми відправили вам? Якщо ви не отримали лист, ми відправим вам ще один.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Новий лист був відправлений на email який ви вказали при реєстрації.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Відправити ще раз') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Вийти') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
