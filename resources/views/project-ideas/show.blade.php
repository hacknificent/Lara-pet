<x-layout>
    <h1 class="mb-1 font-medium">{{ $projectIdea->title ?: 'Project Idea' }}</h1>
    @if (!empty($projectIdea->description))
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{ $projectIdea->description }}</p>
    @else
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">No project idea description available.</p>
    @endif
    <a href="{{ url('/project-ideas/' . $projectIdea->uuid . '/edit') }}" class="font-medium">
        <span style='font-size:20px;'>&#x270D;</span>
    </a>
</x-layout>
