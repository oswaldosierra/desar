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

<body>
    <div class="w-screen h-screen flex justify-center items-center flex-col">
        <h1 class="text-3xl mb-3">DESCAR</h1>
        <form action="{{ route('home') }}" method="post" id="form"
            class="card p-4 flex flex-col border border-gray-200 rounded-lg w-5/12">
            @csrf
            <input type="text" name="url" class="input input-bordered w-full" placeholder="Ingrese Url">
            <select name="type" class="select select-bordered">
                <option value="mp3">Musica</option>
                <option value="mp4">Video</option>
            </select>
            <button class="btn btn-info" onclick="my_modal_1.showModal()">Buscar</button>
        </form>
    </div>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box text-center">
            <h3 class="text-lg font-bold">Descargando</h3>
            <span class="loading loading-spinner loading-lg"></span>
        </div>
    </dialog>
</body>

</html>
