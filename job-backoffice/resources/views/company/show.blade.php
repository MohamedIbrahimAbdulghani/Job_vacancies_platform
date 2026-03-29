<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('company.index') }}" class="px-4 py-2 text-white bg-gray-400 rounded-md hover:bg-gray-500">←  Back</a>
        </div>

        {{-- To Show Success Message --}}
        <x-toast-notification />

        <div class="w-full p-6 mx-auto bg-white rounded-lg shadow">
        {{-- Company Details --}}
            <div>
                <h3 class="text-lg font-bold">Company Information</h3>
                <p><strong>Name: </strong>{{ $company->name }}</p>
                <p><strong>Address: </strong>{{ $company->address }}</p>
                <p><strong>Industry: </strong>{{ $company->industry }}</p>
                <p><strong>Website: </strong><a href="{{ $company->website }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">{{ $company->website }}</a></p>
            </div>
            {{-- Edit And Archived Buttons --}}
            <div class="flex justify-end space-x-2 ">
                {{-- Edit Button --}}
                <a href="{{ route('company.edit', $company->id) }}" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2"> Edit</a>
                {{-- Delete Button --}}
                <form action="{{ route('company.destroy', $company->id) }}" method="post" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2">Archive</button>
                </form>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6">
                <ul class="flex space-x-2">
                    <li>
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'jobs']) }}" class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'applications']) }}" class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                    </li>
                </ul>
            </div>

            {{-- Tabs Content --}}
            <div>
                {{-- Jobs Tab --}}
                <div class="{{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full rounded-lg shadow bg-gray-50">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Title</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Type</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Location</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($company->Jobvacancy as $jobvacancy)
                                <tr>
                                    <td class="px-4 py-2">{{ $jobvacancy->title }}</td>
                                    <td class="px-4 py-2">{{ $jobvacancy->type }}</td>
                                    <td class="px-4 py-2">{{ $jobvacancy->location }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('job_vacancy.show', $jobvacancy->id) }}" class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Applications Tab --}}
                <div class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                    <table class="min-w-full rounded-lg shadow bg-gray-50">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 ">Application Name</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Job Title</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Status</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($company->jobApplications as $application)
                                <tr>
                                    <td class="px-4 py-2">{{ $application->user->name }}</td>
                                    <td class="px-4 py-2">{{ $application->Jobvacancy->title }}</td>
                                    <td class="px-4 py-2">{{ $application->status }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('job_vacancy.show', $application->id) }}" class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
