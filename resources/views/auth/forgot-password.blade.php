<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Morven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-[#4F39F6] to-[#6366F1] bg-clip-text text-transparent">
                        Morven
                    </h1>
                </a>
                <p class="text-gray-600 mt-2">Reset your password</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <p class="text-green-800 text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6] transition-all"
                            placeholder="your@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#4F39F6] text-white py-3 rounded-lg hover:bg-[#3d2bc4] transition-colors font-semibold">
                        Send Reset Link
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-[#4F39F6] hover:text-[#3d2bc4] font-medium">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
