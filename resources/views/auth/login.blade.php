<x-layout title="Login" >
    <h2 class="text-2xl font-bold mb-6 text-center">Login to Your Account</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                    <x-form.error name="email" />
            </div>
            <div class="mb-4">
                <label for="password" class="block">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                    <x-form.error name="password" />
            </div>
            <button type="submit"
                class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                Login
            </button>
        </form>
    <p class="mt-4 text-center">
        Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register here</a>.
</x-layout>