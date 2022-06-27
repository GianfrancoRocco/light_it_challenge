<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{url()->previous()}}">{{ __('Previous Diagnoses') }}</a> / {{$userDiagnosis->id}}
        </h2>
    </x-slot>

    <x-main-container>
        <x-diagnoses :diagnoses="$userDiagnosis->diagnosis" />
    </x-main-container>
</x-app-layout>
