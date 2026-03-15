<x-layout>
    <div class="w-full home bg-white overflow-x-hidden">
        {{-- @dd($page_content); --}}
        <x-product-card :page_content="$page_content" />
        <x-categories :page_content="$page_content" />
        <x-trending :page_content="$page_content" />
        <x-collections />
        <x-brand_logos />
    </div>

</x-layout>
