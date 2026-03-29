<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add Company') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-md ">
            <form action="{{ route('company.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="name" id="name" class=" {{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }} block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('name') }}" >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Company Address</label>
                    <input type="text" name="address" id="address" class=" {{ $errors->has('address') ? 'outline-red-500 outline outline-1' : '' }} block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('address') }}" >
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700">Company Industry</label>
                    <input type="text" name="industry" id="industry" class=" {{ $errors->has('industry') ? 'outline-red-500 outline outline-1' : '' }} block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('industry') }}" >
                    @error('industry')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="website" class="block text-sm font-medium text-gray-700">Company Website</label>
                    <input type="text" name="website" id="website" class=" {{ $errors->has('website') ? 'outline-red-500 outline outline-1' : '' }} block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('website') }}" >
                    @error('website')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-4">
                    <a href="{{ route('company.index') }}" class="px-4 py-2 text-gray-500 rounded-md hover:text-gray-700">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Add Company</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
