<?php

namespace Database\Seeders;

use App\Models\Coupons;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // check if Coupons table is empty
        if (Coupons::count() > 0) {
            return;
        }

        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        // insert content to database
        foreach ($contents['coupons'] as  $coupon) {
            $new_coupon = new Coupons();
            $new_coupon->coupon_code = $coupon['coupon_code'];
            $new_coupon->coupon_discount_rate = $coupon['coupon_discount_rate'];
            //convert string to integer
            $new_coupon->coupon_stat =  intval($coupon['coupon_stat']) == 1 ? true : false;
            //convert timestring to carbon datatime
            $new_coupon->coupon_satrt_date = date("Y-m-d H:i:s", strtotime($coupon['coupon_satrt_date']));
            $new_coupon->coupon_end_date = date("Y-m-d H:i:s", strtotime($coupon['coupon_end_date']));
            $new_coupon->coupon_for = $coupon['coupon_for'];
            $new_coupon->save();
        }
    }
}
