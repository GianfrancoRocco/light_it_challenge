<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosis') }}
        </h2>
    </x-slot>

    <x-main-container>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                @if(!empty($symptoms))
                    <form method="POST">
                        @csrf

                        <div class="mt-4">
                            <x-label for="symptoms" :value="__('Symptoms')" />

                            <x-select class="block mt-1 w-full" name="symptoms[]" id="symptoms" multiple>
                                <x-slot name="content">
                                    @foreach($symptoms as $symptom)
                                        <option value="{{$symptom['ID']}}">{{$symptom['Name']}}</option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Run diagnosis') }}
                            </x-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </x-main-container>
</x-app-layout>
