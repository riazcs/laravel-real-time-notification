<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideoController extends Controller
{
    private $a;
    public $global_variable;
    public function __construct()
    {
        // $this->a = $a;
        // $this->sendValue();
    }
    public function index()
    {
        $this->a = '20';
        $this->sendValue($this->a);
        $videos = Video::orderBy('created_at', 'DESC')->get();
        return view('video.videos')->with('videos', $videos);
    }

    public function uploader()
    {

        // $this->a = '20';
        // echo($this->sendValue());
        return view('video.uploader');
    }
    public function sendValue()
    {
        $this->global_variable = 100;
        return $a = 20;
        // echo $a;
    }
    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'disk'          => 'videos_disk',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $request->video->store('videos', 'videos_disk'),
            'title'         => $request->title,
        ]);

        $this->dispatch(new ConvertVideoForDownloading($video));
        $this->dispatch(new ConvertVideoForStreaming($video));

        return response()->json([
            'id' => $video->id,
        ], 201);
    }


    public function storeVideo(StoreVideoRequest $request)
    {
        $path = str_random(16) . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('public', $path);

        $video = Video::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->title,
        ]);

        ConvertVideoForStreaming::dispatch($video);

        return redirect('/')
            ->with(
                'message',
                'Your video will be available shortly after we process it'
            );
    }

    public function chunkVideo()
    {
        return view('video.chunk');
    }

    public function uploadLargeVideo(Request $request)
    {
        // return storage_path('app/videos/' . '127.0.0.1_8000_login_a4beb4fce26b020943942680be2da599.mp4');
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            return response()->json(['Failed']);
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            // $disk = Storage::disk(config('filesystems.default'));
            // $path = $disk->putFileAs('./public/uploads/videos/', $file, $fileName);

            //Code add Riaz
            // $videoDirectory = './uploads/videos/';
            // if (!file_exists($videoDirectory)) {
            //     mkdir($videoDirectory, 0777, true);
            // }
            // file_put_contents($videoDirectory . $fileName, $file);
            $path = $file->store('uploads/videos', ['disk' => 'videos']);

            //compress audio start
            $compress_audio_directory = './uploads/videos/compress/';
            if (!file_exists($compress_audio_directory)) {
                mkdir($compress_audio_directory, 0777, true);
            }
            $compress_file_name_no_ext = 'compress_record_' . date('D') . rand(10, 1000);
            $compress_file_name = $compress_file_name_no_ext . '.mp3';

            $inputAudio = $path . $fileName;
            $outputAudio = $compress_audio_directory . $fileName;
            exec("ffmpeg -i $inputAudio -ab 64 $outputAudio"); // for audio
            exec("ffmpeg -i $inputAudio -vcodec libx265 -crf 28 $outputAudio"); // for video
            //end 

            $video = new Video();
            $video->path = $path;
            $video->original_name = $fileName;
            $video->save();

            // Storage::move('old/file.jpg', 'new/file.jpg');
            // Storage::move( $path, './uploads/videos/'. $fileName);
            //End 

            // delete chunked file
            unlink($file->getPathname());
            return [
                // 'path' => asset('storage/' . $path), // //comment by riaz
                'path' => asset($path),  // add by riaz
                'filename' => $fileName
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
}
