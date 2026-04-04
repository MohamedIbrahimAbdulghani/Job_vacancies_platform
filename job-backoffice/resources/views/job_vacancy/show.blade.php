<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $job_vacancies->title }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('job_vacancy.index') }}" class="px-4 py-2 text-white bg-gray-400 rounded-md hover:bg-gray-500">←  Back</a>
        </div>

        {{-- To Show Success Message --}}
        <x-toast-notification />

        <div class="w-full p-6 mx-auto bg-white rounded-lg shadow">
        {{-- Company Details --}}
            <div>
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>Title: </strong>{{ $job_vacancies->title }}</p>
                <p><strong>Company Name: </strong>{{ $job_vacancies->company->name }}</p>
                <p><strong>Location: </strong>{{ $job_vacancies->location }}</p>
                <p><strong>Type: </strong>{{ $job_vacancies->type }}</p>
                <p><strong>Salary: </strong>${{ number_format($job_vacancies->salary, 2) }}</p>
                <p><strong>Description: </strong>{{ $job_vacancies->description }}</p>
            </div>
            {{-- Edit And Archived Buttons --}}
            <div class="flex justify-end space-x-2 ">
                {{-- Edit Button --}}
                <a href="{{ route('job_vacancy.edit', ['job_vacancy' => $job_vacancies->id, 'redirectToList' => 'false']) }}" class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2"> Edit</a>
                {{-- Delete Button --}}
                <form action="{{ route('job_vacancy.destroy', $job_vacancies->id) }}" method="post" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2">Archive</button>
                </form>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6">
                <ul class="flex space-x-2">
                    <li>
                        <a href="{{ route('job_vacancy.show', ['job_vacancy' => $job_vacancies->id, 'tab' => 'applications']) }}" class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                    </li>
                </ul>
            </div>

            {{-- Tabs Content --}}
            <div>
                {{-- Applications Tab --}}
                <div class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
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
                            @foreach ($job_vacancies->jobApplications as $application)
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
