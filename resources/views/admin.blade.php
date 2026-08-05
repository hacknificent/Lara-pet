<x-layout title="Admin" hideDecoration="true" :scripts="['js/admin-page.js']">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">List of all users and their projects.</p>
    </div>

    <div class="space-y-6">
        @foreach ($users as $user)
            <section class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff] dark:bg-[#121212] p-5 shadow-sm">
                <div class="mb-4 flex flex-col gap-1">
                    <h2 class="text-lg font-medium">{{ $user->name }}</h2>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $user->email }}</p>
                </div>

                @if ($user->projects->isEmpty())
                    <p class="text-sm text-[#444] dark:text-[#ccc]">No projects available.</p>
                @else
                    <div class="mb-3 text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Projects</div>
                    <ul class="space-y-3">
                        @foreach ($user->projects as $project)
                        
                            <li class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-4 bg-[#f8f7f4] dark:bg-[#171717]">
                                <a href="{{ route('project.show', $project->uuid) }}" class="block">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="font-medium">{{ $project->title }}</span>
                                        <span class="text-xs uppercase tracking-wide text-[#706f6c] dark:text-[#A1A09A]">Project #{{ $project->id }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endforeach
    </div>

    @if ($users->hasPages())
        <div class="mt-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#f8f7f4] dark:bg-[#171717] p-4">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <span class="text-sm text-[#444] dark:text-[#ccc]">
                    Showing up to {{ $perPage }} users per page
                </span>
                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    @endif
</x-layout>
