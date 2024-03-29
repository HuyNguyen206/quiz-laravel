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
                            <x-input-label for="question_options" value="Question options"/>
                            @foreach($form->question_options as $index => $questionOption)
                                <div class="flex mt-2">
                                    <x-text-input type="text" wire:model.defer="form.question_options.{{ $index }}.option" class="w-full" name="questions_options_{{ $index }}" id="questions_options_{{ $index }}" autocomplete="off"/>

                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-1 ml-4" wire:model.defer="form.question_options.{{ $index }}.correct"> Correct
                                        <button wire:click="removeQuestionsOption({{ $index }})" type="button" class="ml-4 rounded-md border border-transparent bg-red-200 px-4 py-2 text-xs uppercase text-red-500 hover:bg-red-300 hover:text-red-700">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                @error('form.question_options.' . $index . '.option')
                                <x-input-error :messages="$message" class="mt-2" />
                                @enderror
                            @endforeach

                            <x-input-error :messages="$errors->get('form.question_options')" class="mt-2" />

                            <x-primary-button wire:click="addQuestionsOption" type="button" class="mt-2">
                                Add
                            </x-primary-button>
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
