<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    @foreach($diagnosis as $loopedDiagnosis)
        @php
            $issue = $loopedDiagnosis['Issue'];
            $specialisations = $loopedDiagnosis['Specialisation'];
            $accuracy = number_format($issue['Accuracy'], 2);
        @endphp
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="mb-4"><strong>{{$issue['Name']}} (or {{$issue['ProfName']}})</strong></p>
                <p class="mb-4">{{$issue['IcdName']}}</p>
                <p>Level of accuracy:</p>
                <div class="pie animate no-round" style="--p:{{$accuracy}};--c:lightgreen"> {{$accuracy}}%</div>
                
                @if (count($specialisations))
                    <p class="mt-4">Specialisations:</p>
                    <ul class="ul-list">
                        @foreach($specialisations as $specialisation)
                            <li>{{$specialisation['Name']}}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <hr>
    @endforeach
</div>