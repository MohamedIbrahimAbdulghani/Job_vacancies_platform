<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    {{-- Application logo --}}
    <div class="flex items-center px-6 py-4 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="w-auto h-6 mr-2 text-gray-800 fill-current" />
            <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>
    {{-- Navigation links --}}
    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.index')">
            Companies
        </x-nav-link>

        <x-nav-link :href="route('job_application.index')" :active="request()->routeIs('job_application.index')">
            Job Application
        </x-nav-link>

        <x-nav-link :href="route('job_category.index')" :active="request()->routeIs('job_category.index')">
            Job Categories
        </x-nav-link>

        <x-nav-link :href="route('job_vacancy.index')" :active="request()->routeIs('job_vacancy.index')">
            Job Vacancies
        </x-nav-link>

        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
            Users
        </x-nav-link>

        <hr>

        <form action="{{ route('logout') }}" method="post">
            @csrf
            <x-nav-link :href="route('logout')" :active="false" class="text-red-500" style="color: red;" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-nav-link>
            {{--
                1- المستخدم يضغط Logout

                2- preventDefault() يمنع فتح الرابط

                3- closest('form') يجيب الفورم الأب

                4- submit() يرسل الفورم
            --}}
        </form>

    </ul>
</nav>
