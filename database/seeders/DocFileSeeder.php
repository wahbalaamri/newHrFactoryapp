<?php

namespace Database\Seeders;

use App\Models\DocFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //check if DocFile table is empty
        if (DocFile::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        //insert content to database
        foreach ($contents['docFiles'] as  $category) {
            $new_docFile= new DocFile();
            $new_docFile->country_id = $category['CountryId'];
            $new_docFile->category_id = $category['CategoryId'];
            $new_docFile->name = $category['Name'];
            $new_docFile->name_ar = $category['NameAr'];
            $new_docFile->eng_doc_path = $category['EngDocPath'];
            $new_docFile->arb_doc_path = $category['ArbDocPath'];
            $new_docFile->eng_vedio = $category['EngVedio'];
            $new_docFile->arb_vedio = $category['ArbVedio'];
            $new_docFile->isFileFree = $category['isFileFree'];
            $new_docFile->isFileActive = $category['isFileActive'];
            $new_docFile->isvedioYouTube = $category['isvedioYouTube'];
            $new_docFile->save();


        }
        //
    }
}
