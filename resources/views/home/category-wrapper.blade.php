<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category }} - Morven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50">
    @livewireScripts
    <x-livewire-alert::scripts />

    @include('templates.navbar')

    @livewire('home.category', ['category' => $category, 'categorySlug' => $categorySlug])

    @include('Components.footer')
    @livewire('modal-manager')

    <!-- Auth Modals -->
    <livewire:auth.checkout-options-modal />
    <livewire:auth.login-modal />
    <livewire:auth.register-modal />
</body>

</html>
