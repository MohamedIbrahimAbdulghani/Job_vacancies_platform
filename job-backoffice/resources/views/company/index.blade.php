<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Company') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        {{-- To Show Success Message --}}
        <x-toast-notification />

        <div class="flex items-center justify-end space-x-2">
            @if(request()->input('archived') == 'true')
                {{-- Active Button --}}
                <a href="{{ route('company.index') }}" class="inline-flex items-center px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2">Active Company</a>
            @else
                {{-- Archived Button --}}
                <a href="{{ route('company.index', ['archived' => 'true']) }}" class="inline-flex items-center px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2">Archived Companies</a>
            @endif
            {{-- Add Job Category Button --}}
                <a href="{{ route('company.create') }}" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">Add Company</a>
        </div>

        {{-- Job Category Table --}}
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Address</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Website</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-500">{{ $company->name }}</span>
                            @else
                                <a href="{{ route('company.show', $company->id) }}" class="text-blue-500 underline hover:text-blue-700">{{ $company->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->website }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->input('archived') == 'true')
                                    {{-- Restore Button --}}
                                    <form action="{{ route('company.restore', $company->id) }}" method="post" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="flex text-red-500 hover:text-red-700">🔄 Restore</button>
                                    </form>
                                @else
                                    {{-- Edit Button --}}
                                    <a href="{{ route('company.edit', $company->id) }}" class="text-blue-500 hover:text-blue-700">✍🏼 Edit</a>
                                    {{-- Delete Button --}}
                                    <form action="{{ route('company.destroy', $company->id) }}" method="post" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex text-red-500 hover:text-red-700">🗃️ Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No Categories Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $companies->links() }}
        </div>

    </div>
</x-app-layout>
