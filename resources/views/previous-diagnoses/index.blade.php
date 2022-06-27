<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Previous Diagnoses') }}
        </h2>
    </x-slot>

    <x-main-container>
        <h2 class="text-xl mb-4">History of previous diagnoses</h2>

        <table class="w-full text-sm text-gray-500 dark:text-gray-400 previous-diagnoses-table border mb-4">
            <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-2">Date of diagnosis</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($diagnoses as $diagnosis)
                    <tr class="bg-white border-b border-t dark:border-gray-700">
                        <td class="px-4 py-2">{{$diagnosis->created_at->format('m/d/Y H:i')}}</td>
                        <td class="px-4 py-2">
                            <div>
                                @if(!$diagnosis->marked_as_correct)
                                    <form action="{{route('previous-diagnoses.mark-as-correct', [$diagnosis])}}" method="POST">
                                        @csrf
                                        <x-button>
                                            Mask as correct
                                        </x-button>
                                    </form>
                                @else
                                    {{$diagnosis->displayWhenMarkedAsCorrect()}}
                                @endif
                            </div>
                        
                            <x-link class="mt-2" :href="route('previous-diagnoses.show', [$diagnosis])">Check diagnosis</x-link>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b border-t dark:border-gray-700">
                        <td class="px-4 py-2" colspan="4">No previous diagnoses found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{$diagnoses->links()}}
    </x-main-container>
</x-app-layout>
