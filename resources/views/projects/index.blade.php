<x-layout title="Projects">
    <h1 class="mb-1 font-medium">My Projects</h1>

    @if ($projects->isEmpty())
        <p class="mb-4 text-[#706f6c] dark:text-[#A1A09A]">You have no projects yet. Create one to start organizing your ideas.</p>
    @else
        <div class="space-y-3 mb-6">
            @foreach ($projects as $project)
                <div class="rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-4">
                    <a href="{{ route('project.show', $project) }}" class="font-medium text-base">
                        {{ $project->title }}
                    </a>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">ID #{{ $project->id }} · {{ $project->ideas()->count() }} ideas</p>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('project.create') }}"
        class="inline-block px-5 py-1.5 bg-[#1b1b18] text-white rounded-sm border border-black text-sm leading-normal hover:bg-black">
        Create New Project
    </a>
</x-layout>
