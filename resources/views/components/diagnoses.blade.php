@foreach($diagnoses as $diagnosis)
    @php
        $issue = $diagnosis['Issue'];
        $specialisations = $diagnosis['Specialisation'];
        $accuracy = number_format($issue['Accuracy'], 2);
    @endphp
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
        <div class="p-6 bg-white border-b border-gray-200">
            <p>Diagnosis #{{$loop->iteration}}: {{$issue['Name']}}</p>
            <p>ICD Name: {{$issue['IcdName']}}</p>
            <p>Level of accuracy:</p>
            <div class="pie animate no-round" style="--p:{{$accuracy}};--c:lightgreen"> {{$accuracy}}%</div>
            
            @if (count($specialisations))
                <p>Specialisations:</p>
                <ul class="specialisations-list">
                    @foreach($specialisations as $specialisation)
                        <li>{{$specialisation['Name']}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>      
@endforeach