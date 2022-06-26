<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('previous-diagnoses.index')}}">{{ __('Previous Diagnoses') }}</a> / {{$userDiagnosis->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-diagnoses :diagnoses="$userDiagnosis->diagnosis" />
        </div>
    </div>
</x-app-layout>
