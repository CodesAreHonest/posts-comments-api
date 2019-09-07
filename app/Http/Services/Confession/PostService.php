<?php


namespace App\Http\Services\Confession;


use Illuminate\Http\Request;

class PostService
{
    public function __construct(){}

    /**
     * @param Request $request
     */
    public function createPost ($request) {

        $stripContent = strip_tags($request['content']);
        $trimContent = trim($stripContent);
        $firstImage  = $request->file('first-image');
        $secondImage = $request->file('second-image');
        $thirdImage  = $request->file('third-image');

        var_dump ($firstImage); exit();
    }
}
