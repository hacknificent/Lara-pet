<x-layout title="Project Ideas" hideDecoration="true" :scripts="['js/project-ideas-index-scripts.js']">
    <h1 class="mb-1 font-medium">Project Ideas</h1>
    @if (isset($project))
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Project: <strong>{{ $project->title }}</strong></p>
    @else
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">You have no project selected yet. Please create a project first.</p>
    @endif
    @php
        $ideasByStatus = $ideas->groupBy('status');
    @endphp

    <div class="project-ideas-grid" data-status-count="{{ count($statuses) }}">
        @foreach ($statuses as $statusValue => $statusLabel)
            <section
                class="rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-4 shadow-sm min-h-[220px]">
                <div class="space-y-3 dropzone" data-status="{{ $statusValue }}">
                    <p class="has-no-ideas-message text-sm text-[#706f6c] dark:text-[#A1A09A]">No ideas in this column yet.</p>
                    @foreach ($ideasByStatus->get($statusValue, collect()) as $idea)
                        <article
                            class="rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#f9f8f5] dark:bg-[#111110] p-3 draggable-idea"
                            draggable="true" data-id="{{ $idea->id }}" data-order="{{ $idea->order ?? 0 }}">
                            <a href="{{ url('/project-ideas/' . $idea->id) }}" class="font-medium">
                                {{ $idea->title }}
                            </a>
                            <div>
                                <a href="{{ url('/project-ideas/' . $idea->id . '/edit') }}" class="font-medium">
                                    <span style='font-size:20px;'>&#x270D;</span>
                                </a>
                            </div>
                            <p class="mt-2 text-xs text-[#706f6c] dark:text-[#A1A09A]">ID #{{ $idea->id }}</p>
                        </article>
                    @endforeach
                </div>
                <header class="mb-4 flex items-center justify-between gap-3">
                    <h2 class="text-sm font-semibold">{{ $statusLabel }}</h2>
                    <span
                        class="project-ideas-counter rounded-full bg-[#f3f2ee] dark:bg-[#272726] px-2 py-0.5 text-xs text-[#706f6c]"></span>
                </header>
            </section>
        @endforeach
    </div>

    @if (isset($project))
        <form method="POST" action="/create-idea">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div>
                <label for="input-title">Idea Title</label>
                <input id="input-title" name="title" type="text" placeholder="Project title"
                    value="{{ old('title') }}"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="title" />
        </div>
        <div class="mt-4">
            <label for="textarea-message">Idea Description</label>
            <textarea id="textarea-message" name="description" rows="10" placeholder="Your Idea"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">{{ old('description') }}</textarea>
            <x-form.error name="description" />
        </div>
            <button type="submit"
                class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Send</button>
        </form>
    @else
        <a href="{{ route('project.create') }}"
            class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Create your first project</a>
    @endif

    <p class="mt-6 lg:mt-10 text-[#706f6c] dark:text-[#A1A09A]">
        v{{ app()->version() }}
        <a href="https://github.com/laravel/framework/blob/13.x/CHANGELOG.md" target="_blank"
            class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
            <span>View changelog</span>
            <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="w-2.5 h-2.5">
                <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor"
                    stroke-linecap="square" />
            </svg>
        </a>
    </p>
</x-layout>
