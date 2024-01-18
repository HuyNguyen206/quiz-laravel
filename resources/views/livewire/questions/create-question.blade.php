<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editing ? 'Edit Question' : 'Create Question' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form wire:submit.prevent="save" novalidate>
                        <div>
                            <x-input-label for="question_text" value="Question text" />
                            <x-textarea wire:model.defer="form.question_text" id="question_text" class="block mt-1 w-full" type="text" />
                            @error('form.question_text')
                                 <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="code_snippet" value="Code snippet" />
                            <x-textarea wire:model.defer="form.code_snippet" id="code_snippet" class="block mt-1 w-full" type="text"/>
                            @error('form.code_snippet')
                             <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="answer_explanation" value="Answer explanation" />
                            <x-textarea wire:model.defer="form.answer_explanation" id="answer_explanation" class="block mt-1 w-full" type="text"/>
                            @error('form.answer_explanation')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="more_info_link" value="More info link" />
                            <x-text-input wire:model.defer="form.more_info_link" id="more_info_link" class="block mt-1 w-full" type="text"/>
                            @error('form.more_info_link')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                Save
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
