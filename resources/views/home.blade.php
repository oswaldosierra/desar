<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DESCAR</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="container h-full w-full mx-auto">
    <div class="w-full h-52 flex justify-center items-center flex-col">
        <h1 class="text-3xl mb-3">DESCAR</h1>
        <form action="{{ route('download') }}" method="post"
            class="card p-4 flex flex-row border border-gray-200 rounded-lg w-5/12">
            @csrf
            <input type="text" name="url" class="input input-bordered w-full" placeholder="Ingrese Url">
            <select name="type" class="select select-bordered">
                <option value="mp3">Musica(MP3)</option>
                <option value="mp4">Video(MP4)</option>
            </select>
            <button class="btn btn-info">Buscar</button>
        </form>
    </div>
</body>

</html>
