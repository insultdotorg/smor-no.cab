<li>
  @auth
    <form action="{{ route('download') }}" method="POST">
      @csrf

      <input type="hidden" name="file" value="{{ $system }}/{{ $filename }}" />

      <button class="text-sky-600 text-left focus:underline hover:underline decoration-2" type="submit"><span class="sr-only">Download {{ $system }} game:</span> {{ $name }} ({{ $size }})</button>
    </form>
  @else
    <span class="text-zinc-500"><span class="sr-only">{{ $system }} game:</span> {{ $name }} ({{ $size }})</span>
  @endauth
</li>
