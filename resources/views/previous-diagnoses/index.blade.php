<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Previous Diagnoses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl mb-4">This is a history of all your previous diagnoses</h2>

            <table class="w-full text-sm text-gray-500 dark:text-gray-400 previous-diagnoses-table border">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Date of diagnosis</th>
                        <th class="px-6 py-4">Marked as correct</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diagnoses as $diagnosis)
                        <tr class="bg-white border-b border-t dark:border-gray-700">
                            <td class="px-6 py-4">{{$diagnosis->created_at->format('m/d/Y H:i')}}</td>
                            <td class="px-6 py-4">{{$diagnosis->isMarkedAsCorrect()}}</td>
                            <td class="px-6 py-4">
                                <x-nav-link :href="route('previous-diagnoses.edit', [$diagnosis])">
                                    Check diagnosis
                                </x-nav-link>
                            </td>
                        </tr>
                    @empty
                        <td colspan="2">No previous diagnoses where found</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
