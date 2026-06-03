<x-layout>

    <h1 class="mb-1 font-medium">Edit Project Idea</h1>
    <form class="mb-2 text-[#706f6c] dark:text-[#A1A09A]" method="POST" action="/project-ideas/{{ $projectIdea->id }}" >
        @csrf
        @method('PATCH')
        <div>
            <label for="input-title">Idea Title</label>
            <input id="input-title" name="title" type="text" placeholder="Project title"
                value="{{ old('title', $projectIdea->title) }}"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="title" />
        </div>
        <div class="mt-4">
            <label for="textarea-message">Idea Description</label>
            <textarea id="textarea-message" name="description" rows="10" placeholder="Your Idea"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">{{ old('description', $projectIdea->description) }}</textarea>
        </div>
        <div class="mt-4 mb-4">
            <label for="status">Status</label>
            <select id="status" name="status"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                @foreach ($projectStatuses as $value => $label)
                    <option value="{{ $value }}" {{ $projectIdea->status == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
            class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Save</button>
    </form>

    <form method="POST" action="/project-ideas/{{ $projectIdea->id }}" >
        @csrf
        @method('DELETE')
        <button type="submit"
            class="border leading-normal px-5 py-1.5 rounded-sm text-sm text-white">Delete</button>
    </form>

</x-layout>
