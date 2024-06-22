<?php

namespace App\Http;

use App\Models\Content;

class PagesContent
{
    public static function get($page)
    {
        return Content::where('page', '=', $page)->get();
    }
}