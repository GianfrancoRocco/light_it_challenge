
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 bg-white border-b border-gray-200">
        Selected symptoms:
        
        <ul class="ul-list">
            @foreach($symptoms as $symptom)
                <li>{{$symptom['Name']}}</li>
            @endforeach
        </ul>
    </div>
</div>   