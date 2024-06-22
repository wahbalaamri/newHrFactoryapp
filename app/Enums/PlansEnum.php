<?php

namespace App\Enums;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

enum PlansEnum: int
{
    case WarmUp = 1;
    case Startup = 2;
    case ManualBuilder = 3;
    case PlugIn = 4;
    case Tech = 5;
    case Doctor = 6;

    // name
    public function name(): string
    {
        return match ($this->value) {
            self::WarmUp => __('Warm Up'),
            self::Startup => __('Start up'),
            self::ManualBuilder => __('Manual Builder'),
            self::PlugIn => __('Plug In'),
            self::Tech => __('Tech'),
            self::Doctor => __('Doctor'),
            default => 'unknown',
        };
    }
    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }
    // get name
    public static function getName($case)
    {
        return match ($case) {
            'WarmUp' => __('Warm Up'),
            'Startup' => __('Start up'),
            'ManualBuilder' => __('Manual Builder'),
            'PlugIn' => __('Plug In'),
            'Tech' => __('Tech'),
            'Doctor' => __('Doctor'),
            default => 'unknown',
        };
    }
    public static function getNameByVal($val)
    {
        Log::info($val);
        return match ($val) {
            1 => self::WarmUp,
            2 => self::Startup,
            3 => self::ManualBuilder,
            4 => self::PlugIn,
            5 => self::Tech,
            6 => self::Doctor,
        };
    }
}
