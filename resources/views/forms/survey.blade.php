<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $form->title }} <br>
                    <small>{{ $form->description }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('survey.submit') }}">
                        @csrf
                        @foreach ($form->inputs as $input)
                            <div class="mt-4">
                                <x-label for="$input->name" :value="str_replace('_', ' ', $input->name)" />

                                <x-input id="{{ $input->name }}" class="block mt-1 w-full"
                                                type="{{ $input->type }}"
                                                name="{{ $input->name }}"
                                                required />
                            </div>
                        @endforeach

                        <center class="mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>    
                        </center>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
