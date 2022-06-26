<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('diagnosis.index')}}">{{ __('Diagnosis') }}</a> / Result
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl">Possible diagnoses based on selected symptoms</h2>

            <x-diagnoses :diagnoses="$diagnoses" />
        </div>
    </div>
</x-app-layout>
