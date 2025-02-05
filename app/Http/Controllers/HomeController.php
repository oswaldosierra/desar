<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $Options = Options::create()->downloadPath('./')->url($url)->output('%(title)s.%(ext)s');

        if ($type == 'mp3') $Options = $Options->format('bestaudio/best')->extractAudio(true)->audioFormat('mp3');

        $collection = $yt->download($Options);

        foreach ($collection->getVideos() as $video) {
            if ($video->getError() !== null) {
                echo "Error downloading video: {$video->getError()}.";
            } else {
                echo $video->getTitle(); // Will return Phonebloks
                // $video->getFile(); // \SplFileInfo instance of downloaded file
            }
        }
    }

    // ---------------------------
    // pip3 install -U yt-dlp
}
