<div class="border border-gray-300 rounded-lg mb-4">
  @forelse ($tweets as $tweet)
      @include('_tweet')
  @empty
      <p class="p-4">No tweets yet.</p>
  @endforelse

  {{-- You'd also need to instruct pagination for TweetsController on User method just like what you did to ProfilesController. --}}
  {{ $tweets->links('pagination::tailwind') }}
</div>