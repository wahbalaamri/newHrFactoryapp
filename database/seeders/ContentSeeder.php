<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if Content table is empty
        if (Content::count() > 0) {
            return;
        }
        //get content from Api
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        //insert content to database
        // Log::info($contents);
        foreach ($contents['contents'] as  $content) {
            $new_content = new Content();
            $new_content->d_id = $content['Id'];
            $new_content->ArabicText = $content['ArabicText'];
            $new_content->EnglishText = $content['EnglishText'];
            $new_content->save();
        }

        $test = Content::whereIn('d_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 47, 48, 49, 50, 122, 123, 124, 125])->update(['page' => 'home']);
        $test = Content::whereIn('d_id', [104 ,96,97,98,99,100,101,102,103])->update(['page' => 'aboutus']);
        $test = Content::whereIn('d_id', [68,69,70,116,117,118,119,120,121])->update(['page' => 'startup']);
        $test = Content::whereIn('d_id', [63,64])->update(['page' => 'login']);
        $test = Content::whereIn('d_id', [79,80,81])->update(['page' => 'manualbuilder']);

    }
}
