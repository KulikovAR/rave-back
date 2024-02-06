<x-filament::widget>
    <x-filament::card>
        {{-- Widget content --}}
        <div
            class="flex items-center space-x-2 text-sm font-medium text-gray-500 rtl:space-x-reverse dark:text-gray-200">
            <span>Пользователи с 5 и более уствойствами</span>
        </div>

        <div class="user-device-widget-wrap">
            @if(!$users->count()) 
                <span>0</span>
            @endif

            @foreach ($users as $user)
                <div class="user-device-widget-item">
                    <a href="{{ route('filament.resources.users.edit', $user->id) }}">
                        {{ $user->userProfile?->firstname }}
                        {{ $user->userProfile?->lastname }}</a>
                    <b>{{ $user->user_devices_count }}</b>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>

<style>
    .user-device-widget-wrap {
        display: flex;
        flex-direction: column;
        color: white;
    }

    .user-device-widget-item {
        display: flex;
        justify-content: space-between;
    }

    .user-device-widget-item a {
        transition: 0.2s;
    }

    .user-device-widget-item:hover {
        color: rgb(234, 91, 61)
    }
</style>
