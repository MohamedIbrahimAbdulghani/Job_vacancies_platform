<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Categories') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="p-6 overflow-x-auto">
        {{-- To Show Success Message --}}
        <x-toast-notification />


        <div class="flex items-center justify-end space-x-2">
            @if(request()->input('archived') == 'true')
                {{-- Active Button --}}
                <a href="{{ route('job_category.index') }}" class="inline-flex items-center px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2">Active Categories</a>
            @else
                {{-- Archived Button --}}
                <a href="{{ route('job_category.index', ['archived' => 'true']) }}" class="inline-flex items-center px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2">Archived Categories</a>
            @endif
            {{-- Add Job Category Button --}}
                <a href="{{ route('job_category.create') }}" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">Add Job Category</a>
        </div>

        {{-- Job Category Table --}}
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->input('archived') == 'true')
                                    {{-- Restore Button --}}
                                    <form action="{{ route('job_category.restore', $category->id) }}" method="post" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="flex text-red-500 hover:text-red-700">🔄 Restore</button>
                                    </form>
                                @else
                                    {{-- Edit Button --}}
                                    <a href="{{ route('job_category.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">✍🏼 Edit</a>
                                    {{-- Delete Button --}}
                                    <form action="{{ route('job_category.destroy', $category->id) }}" method="post" class="inline-block">
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
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>
