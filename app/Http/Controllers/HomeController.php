<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function download(Request $request)
    {
        $url = $request->input('url');
        $type = $request->input('type');
        $yt = new YoutubeDl();
        $Dir = public_path('downloads');

        $Options = Options::create()->downloadPath($Dir)->url($url)->output('%(title)s.%(ext)s');
        if ($type == 'mp3') $Options = $Options->format('bestaudio/best')->extractAudio(true)->audioFormat('mp3');

        $collection = $yt->download($Options);
        foreach ($collection->getVideos() as $video) {
            if ($video->getError() !== null) {
                continue;
            }
            $name = $video->getTitle();
            if ($type == 'mp3') $name .= '.mp3';
            else $name .= '.webm';

            return response()->download("$Dir/$name", $name);
        }
    }

    // ---------------------------
    // pip3 install -U yt-dlp
}
