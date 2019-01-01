<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Http\Requests\UnshortenRequest;
use App\Services\UrlShortener;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RestController extends Controller
{
    private $shortener;

    public function __construct()
    {
        $this->shortener = new UrlShortener;
    }

    //
    public function create(ShortenRequest $request)
    {
        $url = $request->input('url');
        $this->validateUrl($url);
        return response()->json([
            'url' => $this->shortener->shorten($url)
        ]);
    }

    public function find(UnshortenRequest $request)
    {
        $code = $request->input('code');
        try {
            $url = $this->shortener->unshorten($code);
            return response()->json([
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }

    private function validateUrl($url)
    {
        if (!preg_match('/^(http|https)(:\/\/)\w+(\.\w+)+$/', $url)) {
            throw new HttpException(400, 'invalid url');
        }
    }
}
