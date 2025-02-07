<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/png">
    <title>DESCAR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="w-screen h-screen flex justify-center items-center flex-col">
        <h1 class="text-3xl mb-3">DESCAR</h1>
        <form action="{{ route('home') }}" method="post" id="form"
            class="card p-4 flex flex-col border border-gray-200 rounded-lg w-10/12">
            @csrf
            <input type="text" name="url" class="input input-bordered w-full" placeholder="Ingrese Url del video"
                value="{{ old('text') }}">
            @error('url')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            <select name="type" class="select select-bordered">
                <option value="mp3">Musica</option>
                <option value="mp4">Video</option>
            </select>
            @error('type')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            <button class="btn btn-info text-white" onclick="my_modal_1.showModal()">Descargar</button>
        </form>
        <span class="opacity-50">Versión {{ Config::get('nativephp.version') }}</span>
    </div>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box text-center">
            <h3 class="text-lg font-bold">Descargando</h3>
            <span class="loading loading-spinner loading-lg"></span>
        </div>
    </dialog>
</body>

</html>
