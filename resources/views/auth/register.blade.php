<x-layout title="Account Registration">
    <h1 class="mb-1 font-medium">Register</h1>
    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Create an account to share your project ideas and collaborate with
        others.</p>

    <form method="POST" action="/register">
        @csrf
        <div>
            <label for="input-name">Name</label>
            <input required id="input-name" name="name" type="text" placeholder="Your Name" value="{{ old('name') }}"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="name" />
        </div>
        <div class="mt-4">
            <label for="input-email">Email</label>
            <input required id="input-email" name="email" type="email" placeholder="Your Email" value="{{ old('email') }}"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="email" />
        </div>
        <div class="mt-4">
            <label for="input-password">Password</label>
            <input required id="input-password" name="password" type="password" placeholder="Your Password"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
            <x-form.error name="password" />
        </div>
        <div class="mt-4">
            <label for="input-password-confirmation">Confirm Password</label>
            <input required id="input-password-confirmation" name="password_confirmation" type="password"
                placeholder="Confirm Your Password"
                class="w-full inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal" />
        </div>
        <button type="submit"
            class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal mt-4">Register</button>
    </form>
</x-layout>