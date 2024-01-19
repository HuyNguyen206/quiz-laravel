<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $editing ? 'Edit Quiz' : 'Create Quiz' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form wire:submit.prevent="save" novalidate>
                        <div>
                            <x-input-label for="title" value="Title" />
                            <x-text-input wire:model.lazy="form.title" id="title" class="block mt-1 w-full" type="text" name="title" required />
                            @error('form.title')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="slug" value="Slug" />
                            <x-text-input wire:model.lazy="form.slug" id="slug" class="block mt-1 w-full" type="text" name="slug" />
                            @error('form.slug')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" value="Description" />
                            <x-textarea wire:model.defer="form.description" id="description" class="block mt-1 w-full" type="text" name="description" />
                            @error('form.description')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="questions" value="Questions" />
                            <x-select-list class="w-full" id="questions" name="questions" :options="$form->questions" wire:model="form.questionIds" multiple />
{{--                            @error('form.description')--}}
{{--                            <x-input-error :messages="$message" class="mt-2" />--}}
{{--                            @enderror--}}
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center">
                                <x-input-label for="published" value="Published"/>
                                <input type="checkbox" id="published" class="mr-1 ml-4" wire:model.defer="form.published">
                            </div>
                            @error('form.published')
                            <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center">
                                <x-input-label for="public" value="Public"/>
                                <input type="checkbox" id="public" class="mr-1 ml-4" wire:model.defer="form.public">
                            </div>
                            @error('form.public')
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
