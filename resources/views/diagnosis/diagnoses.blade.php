<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-nav-link class="mb-4" :href="route('diagnosis.index')">Go back</x-nav-link>

            <h2 class="text-xl">Possible diagnoses based on selected symptoms</h2>

            <x-diagnoses :diagnoses="$diagnoses" />
        </div>
    </div>
</x-app-layout>
