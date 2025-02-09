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

        $dir = Dialog::new()->title('¿Dónde guardar los archivos?')->folders()->open();
        if (!$dir) return redirect()->route('home');

        $binPath = __DIR__ . "/../../bin";
        $isWindows = PHP_OS_FAMILY === 'Windows';

        $pythonExists = shell_exec(($isWindows ? "where python" : "which python3") . " 2>&1");
        if (!$pythonExists) {
            if ($isWindows) {
                $pythonZipPath = "$binPath/python.zip";
                $pythonExtractPath = "$binPath/python";
                shell_exec("powershell -command \"Expand-Archive -Path '$pythonZipPath' -DestinationPath '$pythonExtractPath' -Force\"");
            } else {
                shell_exec("sudo apt update && sudo apt install -y python3 || sudo yum install -y python3 || brew install python3");
            }
        }

        $yt = new YoutubeDl();
        if ($isWindows && !$pythonExists) $yt->setPythonPath("$binPath/python/python.exe");
        $yt->setBinPath($isWindows ? "$binPath/win/yt-dlp.exe" : "$binPath/lin/yt-dlp");

        $Options = Options::create()->downloadPath($dir)->url($url)->output('%(title)s.%(ext)s');
        if ($type == 'mp3') $Options = $Options->format('bestaudio/best')->extractAudio(true)->audioFormat('mp3');

        $yt->download($Options);

        Notification::title('Descarga Completada')->message('El archivo se ha descargado con éxito')->show();
        return redirect()->route('home');
    }
}
