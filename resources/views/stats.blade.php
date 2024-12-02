<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-12 px-4 sm:px-0">
                @foreach ($files as $system => $games)
                    <div class="grid gap-4">
                        <div class="font-bold"><span class="sr-only">System:</span> {{ $system }}</div>

                        <div>
                            <span class="sr-only">Games for {{ $system }}:</span>

                            <ul class="grid gap-4 justify-start">
                                @foreach ($games as $filename)
                                    <x-stats :$system :$filename />
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
