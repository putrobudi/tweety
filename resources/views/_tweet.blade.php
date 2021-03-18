<div class="flex p-4 border-b border-b-gray-400">
  {{-- You can do <aside> or just simple <div> --}}
  <div class="mr-2 flex-shrink-0"> {{-- flex-shrink so it's not affected by flex p-4 above so you can resize it. --}}
      <img src="{{ $tweet->user->avatar }}" alt="" class="rounded-full mr-2">
  </div>
  <div>
      <h5 class="font-bold mb-4">{{ $tweet->user->name }}</h5>
      <p class="text-sm">
          {{ $tweet->body }}
      </p>
  </div>
</div>