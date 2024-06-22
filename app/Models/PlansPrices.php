<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlansPrices extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'plans_prices';
    protected $fillable = [
        'plan',
        'country',
        'annual_price',
        'currency',
        'payment_methods',
        'is_active'
    ];
    //belongs to relationship with plans
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }
    //belongs to relationship with countries
    public function Country()
    {
        return $this->belongsTo(Countries::class, 'country','id');
    }
    //get plan price currency
    public function getCurrencySymbolAttribute()
    {
        $currency="";
        switch ($this->currency) {
            case '1':
                $currency = 'ر.ع.';
                break;
            case '2':
                $currency = '$';
                break;
            case '3':
                //UAE Dirham
                $currency = 'د.إ';
                break;
            case '4':
                //Saudi Riyal
                $currency = 'ر.س';
                break;
            case '5':
                //Kuwaiti Dinar
                $currency = 'د.ك';
                break;
            case '6':
                //Bahraini Dinar
                $currency = 'د.ب';
                break;
            case '7':
                //Qatari Riyal
                $currency = 'ر.ق';
                break;
            case '8':
                //Jordanian Dinar
                $currency = 'د.ا';
                break;
            case '9':
                //Egyptian Pound
                $currency = 'ج.م';
                break;
            case '10':
                //Lebanese Pound
                $currency = 'ل.ل';
                break;
            }
        return $currency;
    }

}
