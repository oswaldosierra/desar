<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;
use Native\Laravel\Dialog;
use Native\Laravel\Facades\Notification;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'type' => 'required|in:mp3,mp4'
        ]);

        $url = $request->input('url');
        $type = $request->input('type');

        $dir = Dialog::new()->title('Donde guardar los archvios?')->folders()->open();
        if (!$dir) return redirect()->route('home');

        $yt = new YoutubeDl();
        $yt->setPythonPath(__DIR__ . "/../../bin/lin/python3.10");
        $yt->setBinPath(__DIR__ . "/../../bin/lin/yt-dlp");

        $Options = Options::create()->downloadPath($dir)->url($url)->output('%(title)s.%(ext)s');
        if ($type == 'mp3') $Options = $Options->format('bestaudio/best')->extractAudio(true)->audioFormat('mp3');

        $yt->download($Options);

        Notification::title('Descarga Completada')->message('El archivo se ha descargado con exito')->show();
        return redirect()->route('home');
    }
}
