<li x-data="{ open: false }">
    <div class="text-zinc-400" @click="open = !open" @click.away="open = false"><span class="sr-only">{{ $system }} game:</span> {{ $name }}</span>

    @if ($downloads > 0)
        <div aria-hidden="true" class="text-xs">
            <div class="text-black">Downloaded {{ number_format($downloads) }} {{ Str::plural('time', $downloads) }}</div>
            <div x-cloak x-show="open">{{ $stats }}</div>
        </div>
    @endif
</li>
