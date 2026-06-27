<x-layout title="Create Project">
    <h1 class="mb-1 font-medium">Create Project</h1>
    <form method="POST" action="{{ route('project.store') }}" class="space-y-4">
        @csrf
        <div>
            <label for="title">Project Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="title" />
        </div>

        <div>
            <label class="block mb-2">Project Statuses</label>
            <div id="statuses-container" class="space-y-2">
                @foreach ($statuses as $status)
                    <div class="status-item flex items-center gap-3">
                        <input type="text" name="statuses[]" value="{{ old('statuses.'.($loop->index), $status) }}"
                            class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
                        <button type="button" class="remove-status px-3 py-1 bg-[#f3f2ee] dark:bg-[#272726] rounded-sm text-sm">Remove</button>
                    </div>
                @endforeach
            </div>
            <button id="add-status" type="button"
                class="mt-3 inline-block px-5 py-1.5 bg-[#1b1b18] text-white rounded-sm border border-black text-sm leading-normal hover:bg-black">
                Add Status
            </button>
            <x-form.error name="statuses" />
            <x-form.error name="statuses.*" />
        </div>

        <button type="submit"
            class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
            Create Project
        </button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('statuses-container');
            const addButton = document.getElementById('add-status');

            function createStatusRow(value = '') {
                const wrapper = document.createElement('div');
                wrapper.className = 'status-item flex items-center gap-3';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'statuses[]';
                input.value = value;
                input.className = 'w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal';

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.textContent = 'Remove';
                remove.className = 'remove-status px-3 py-1 bg-[#f3f2ee] dark:bg-[#272726] rounded-sm text-sm';
                remove.addEventListener('click', function () {
                    wrapper.remove();
                });

                wrapper.appendChild(input);
                wrapper.appendChild(remove);
                return wrapper;
            }

            addButton.addEventListener('click', function () {
                container.appendChild(createStatusRow(''));
            });

            container.querySelectorAll('.remove-status').forEach(function (button) {
                button.addEventListener('click', function () {
                    button.closest('.status-item')?.remove();
                });
            });
        });
    </script>
</x-layout>
