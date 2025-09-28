<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-10 max-w-lg w-full text-center transform transition hover:scale-105 duration-300">
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
            Welcome 🎉
        </h1>

        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
            Check stock performances and manage everything in style 🚀
        </p>

        <a href="{{ url('/admin') }}"
           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            Go to Admin Panel
        </a>
    </div>

</body>
</html>
