<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('diagnosis.index')}}">{{ __('Diagnosis') }}</a> / Result
        </h2>
    </x-slot>

    <x-main-container>
        <h2 class="text-xl">Possible diagnosis based on selected symptoms</h2>

        <x-selected-symptoms :symptoms="$selectedSymptoms"/>
        
        <x-diagnosis :diagnosis="$diagnosis" />
    </x-main-container>
</x-app-layout>
