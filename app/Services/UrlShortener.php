<?php
/**
 * User: nabil
 * Date: 31-Dec-18
 * Time: 11:29 PM
 */

namespace App\Services;

use App\Url;


class UrlShortener
{
    private $map;
    private $base;

    public function __construct()
    {
        $this->map = array_merge(
            range('A', 'Z'),
            range('a', 'z'),
            range(0, 9)
        );
        $this->base = count($this->map);
    }

    public function shorten(string $str): string
    {
        /* @var Url $url */
        $url = new Url;

        $url->value = $str;
        $url->save();

        $arr = $this->encode($url->id);
        $str = $this->wrap($arr);

        $url->key = $str;
        $url->save();

        return $str;
    }

    public function encode(int $id): array
    {
        $arr = [];

        while ($id > 0) {
            $remainder = $id % $this->base;
            $id = intdiv($id, $this->base);
            $arr[] = $remainder;
        }

        return array_reverse($arr);
    }

    public function wrap(array $encoded): string
    {
        $shorted = '';

        foreach ($encoded as $value) {
            $shorted .= $this->map[$value];
        }

        return $shorted;
    }

    public function unshorten(string $str)
    {
        /* @var Url $url */
        $arr = $this->decode($str);
        $id = $this->unwrap($arr);

        $url = Url::find($id);
        $url->visited += 1;
        $url->save();

        return $url->value;
    }

    public function decode(string $str): array
    {
        $arr = [];

        foreach (str_split($str) as $value) {
            $arr[] = array_search($value, $this->map);
        }

        return array_reverse($arr);
    }

    public function unwrap(array $decoded): int
    {
        $id = 0;

        foreach ($decoded as $key => $value) {
            $id += $value * ($this->base ** $key);
        }

        return $id;
    }

    public function getBase(): int
    {
        return $this->base;
    }
}