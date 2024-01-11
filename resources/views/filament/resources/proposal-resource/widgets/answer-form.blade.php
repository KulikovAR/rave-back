<x-filament::widget>
    <x-filament::card>
        <form wire:submit.prevent="submit">
            {{ $this->form }}
            <div class="py-2">
                <x-filament::button
                        type='submit'
                >
                    Оветить
                </x-filament::button>
            </div>

        </form>
    </x-filament::card>
</x-filament::widget>
