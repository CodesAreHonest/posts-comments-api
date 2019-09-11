<?php


namespace App\Http\Services\Confession;


use App\Http\Services\Storage\FileService;
use Illuminate\Http\Request;

class PostService
{
    private $fileService;
    private $diskName = 'posts';

    public function __construct(FileService $fileService){
        $this->fileService = $fileService;
    }

    /**
     * @param Request $request
     */
    public function createPost ($request) {

        $stripContent = strip_tags($request['content']);
        $trimContent = trim($stripContent);

        $imageArray = [];

        if ($request->file('first-image')) {
            $firstImage  = $request->file('first-image');
            $firstImageUrl = $this->fileService->storeFile($this->diskName, $firstImage);

            if ($firstImageUrl) {
                $imageArray['first-image'] = $firstImageUrl;
            }
        }

        if ($request->file('second-image')) {
            $secondImage  = $request->file('second-image');
            $secondImageUrl = $this->fileService->storeFile($this->diskName, $secondImage);

            if ($secondImageUrl) {
                $imageArray['second-image'] = $secondImageUrl;
            }
        }

        if ($request->file('third-image')) {
            $thirdImage  = $request->file('third-image');
            $thirdImageUrl = $this->fileService->storeFile($this->diskName, $thirdImage);

            if ($thirdImageUrl) {
                $imageArray['third-image'] = $thirdImageUrl;
            }
        }
    }
}
