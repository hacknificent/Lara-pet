@props(['name'])

@error($name)
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-[#f53003] dark:text-[#FF4433]']) }}>
        {{ $message }}
    </p>
@enderror
