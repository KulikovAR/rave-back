<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div class="filament-forms-text-input-component group flex items-center space-x-2 rtl:space-x-reverse">
        <div class="flex-1">
            <input wire:model.defer="{{ $getStatePath() }}"  id="{{ $getStatePath() }}" disabled
                class="filament-forms-input block w-full rounded-lg shadow-sm outline-none transition duration-75 focus:ring-1 focus:ring-inset 
                      disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 
                      dark:border-gray-600 dark:focus:border-primary-500">
            @livewire('chunkuploader', ['inputId' => $getStatePath()])
        </div>
    </div>
</x-dynamic-component>