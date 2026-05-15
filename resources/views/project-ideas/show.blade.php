<x-layout>
    <h1 class="mb-1 font-medium">Project Idea</h1>
    @if ($projectIdea && !empty($projectIdea->description))
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{ $projectIdea->description }}</p>
        <a href="{{ url('/project-ideas/' . $projectIdea->id . '/edit') }}" class="font-medium">
            <span style='font-size:20px;'>&#x270D;</span>
        </a>
    @else
    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">No project idea available.</p>
@endif
</x-layout>
