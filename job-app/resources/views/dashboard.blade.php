<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('Job Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="p-6 mx-auto bg-black rounded-lg shadow-lg max-w-7xl">
            <h3 class="mb-6 text-xl font-bold text-white">{{ __('Welcome back ,  ') }} {{ Auth::user()->name }} !</h3>
            {{-- Search & Filters --}}
            <div class="flex items-center justify-between">
                {{-- Search Bar --}}
                <form action="{{ 'dashboard' }}" method="get" class="flex items-center justify-center w-1/4">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 text-white bg-gray-800 rounded-l-lg " placeholder="Search for a job">
                    <button type="submit" class="p-2 text-white bg-indigo-500 border border-indigo-500 rounded-r-lg">Search</button>
                    @if(request('search'))
                        <a href="{{ route('dashboard', ['filter' => request('filter')]) }}" class="p-2 ml-2 text-white border rounded-lg">Clear</a>
                    @endif

                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                </form>
                {{-- Filters --}}
                <div class="flex space-x-2">
                    <a href="{{ route('dashboard', ['filter'=>'full-time', 'search' => request('search')]) }}" class="p-2 text-white bg-indigo-500 rounded-lg">Full-Time</a>
                    <a href="{{ route('dashboard', ['filter'=>'remote', 'search' => request('search')]) }}" class="p-2 text-white bg-indigo-500 rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter'=>'hybrid', 'search' => request('search')]) }}" class="p-2 text-white bg-indigo-500 rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter'=>'contract', 'search' => request('search')]) }}" class="p-2 text-white bg-indigo-500 rounded-lg">Contract</a>
                    @if(request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}" class="p-2 text-white border rounded-lg">Clear</a>
                    @endif
                </div>
            </div>

            {{-- Job List --}}
            <div class="mt-6 space-y-4">
                {{-- Job Item --}}
                @forelse ($jobs as $job)
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <a href="" class="text-lg font-semibold text-blue-400 truncate hover:underline">{{ $job->title }}</a>
                            <p class="text-sm text-white truncate">{{ $job->company->name }} - {{ $job->location }}</p>
                            <p class="text-sm text-white truncate">{{ '$' . number_format($job->salary) }} / Year</p>
                        </div>
                        <span class="px-3 py-2 text-white truncate bg-blue-500 rounded-lg text:sm">{{ $job->type }}</span>
                    </div>
                @empty
                    <p class="text-2xl font-bold text-white">No Jobs found!</p>
                @endforelse
            </div>
            <div class="mt-6">
                {{-- Pagination --}}
                {{ $jobs->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
