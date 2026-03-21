<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Category') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        {{-- Job Category Table --}}
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                {{-- Edit Button --}}
                                <a href="{{ route('job_category.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">✍🏼 Edit</a>
                                {{-- Delete Button --}}
                                <form action="{{ route('job_category.destroy', $category->id) }}" method="post" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex text-red-500 hover:text-red-700">🗃️ Archive</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>
