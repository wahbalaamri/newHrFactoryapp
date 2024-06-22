<?php

namespace App\Enums;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class NumberOfEmployees
{
    private $List = [
        1 => 'From 1 to 10',
        2 => 'From 11 to 49',
        3 => 'From 50 to 99',
        4 => 'From 100 to 499',
        5 => 'From 500 to 1000',
        6 => 'More than 1000',
    ];
    //arabic list
    private $List_ar = [
        1 => 'من 1 إلى 10',
        2 => 'من 11 إلى 49',
        3 => 'من 50 إلى 99',
        4 => 'من 100 إلى 499',
        5 => 'من 500 إلى 1000',
        6 => 'أكثر من 1000',
    ];
    public function getValues()
    {
        return array_keys($this->List);
    }
    public function getValuesAr()
    {
        return array_keys($this->List_ar);
    }
    public function getList()
    {
        return App()->isLocale('en') ? $this->List : $this->List_ar;
    }
    public function getListAr()
    {
        return $this->List_ar;
    }
    public function getName($case)
    {
        return $this->List[$case];
    }
}
