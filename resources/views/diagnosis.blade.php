<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

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
                </div>
            </div>

            @if(session('diagnoses'))
                <h2>Possible diagnoses based on selected symptoms</h2>

                @foreach(session('diagnoses') as $diagnosis)
                    @php
                        $issue = $diagnosis['Issue'];
                        $specialisations = $diagnosis['Specialisation'];
                    @endphp
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p>Issue: {{$issue['Name']}}</p>
                            <p>ICD Name: {{$issue['IcdName']}}</p>
                            <p>Accuracy:</p>
                            <div class="pie animate no-round" style="--p:{{$issue['Accuracy']}};--c:lightgreen"> {{$issue['Accuracy']}}%</div>
                            
                            <p>Specialisations to treat it:</p>
                            @foreach($specialisations as $specialisation)
                                <p>{{$specialisation['Name']}}</p>
                            @endforeach
                        </div>
                    </div>      
                @endforeach 
            @endif
        </div>
    </div>
</x-app-layout>
