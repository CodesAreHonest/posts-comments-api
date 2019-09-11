<?php


namespace App\Http\Services\Confession;


use App\Http\Services\Storage\FileService;
use Illuminate\Http\Request;

class PostService
{
    private $fileService;
    public function __construct(FileService $fileService){
        $this->fileService = $fileService;
    }

    /**
     * @param Request $request
     */
    public function createPost ($request) {

        $stripContent = strip_tags($request['content']);
        $trimContent = trim($stripContent);

        if ($request->has('first-image')) {
            $diskName = 'public';
            $firstImage  = $request->file('first-image');
            $firstImageUrl = $this->fileService->storeFile($diskName, $firstImage);
        }

//        $firstImage  = $request->file('first-image');
//
//        $secondImage = $request->file('second-image');
//        $thirdImage  = $request->file('third-image');
    }
}
