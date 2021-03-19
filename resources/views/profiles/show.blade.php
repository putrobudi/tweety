@extends('layouts.app')

@section('content')
    <header class="mb-6 relative">
        <img src="/images/default-profile-banner.jpg" alt="" class="mb-2 rounded-lg">

        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="font-bold text-2xl mb-0">{{ $user->name }}</h2>
                <p class="text-sm">Joined {{ $user->created_at->diffForHumans() }}</p>
            </div>

            <div>
                <a href="" class="rounded-full border border-gray-300 py-2 px-4 text-black text-xs mr-2">Edit Profile</a>
                <a href="" class="bg-blue-500 rounded-full shadow py-2 px-4 text-white text-xs">Follow Me</a>
            </div>
        </div>
        <p class="text-sm">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum voluptas nesciunt autem a sapiente repellat,
            minima illum soluta odit facilis asperiores eos iste voluptate quod neque sed. Maiores nemo vero et praesentium
            voluptas reiciendis, accusamus repellat quam fugiat amet itaque, saepe doloribus ea eaque sint? Eveniet
            doloremque pariatur quisquam error.
        </p>
        <img src="{{ $user->avatar }}" alt="" class="rounded-full mr-2 absolute"
            style="width: 150px; left: calc(50% - 75px); top: 292px;">

    </header>

    {{-- tweets has to be known for _timeline --}}
    @include('_timeline', [
    'tweets' => $user->tweets
    ])
@endsection
