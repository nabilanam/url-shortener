<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Http\Requests\UnshortenRequest;
use App\Services\UrlShortener;

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

        if (!$this->isValid($url)) {
            return response()->json([
                'errors' => [
                    'url' => ['Invalid URL.']
                ]
            ], 400);
        }

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

    private function isValid($url)
    {
        return preg_match('/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)/', $url);
    }
}
