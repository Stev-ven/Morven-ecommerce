<div class="w-full overflow-x-hidden">
    @include('templates.header')
    @include('templates.navbar')
    
    <!-- Email Verification Banner -->
    <livewire:email-verification-banner />

    {{ $slot }}

    @include('templates.footer')
    
    <!-- Auth Modals -->
    <livewire:auth.checkout-options-modal />
    <livewire:auth.login-modal />
    <livewire:auth.register-modal />
</div>
