<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Governorate;
class GovernoratesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["id"=>"1","name"=>"القاهرة", "country_id"=>1],
            ["id"=>"2","name"=>"الجيزة", "country_id"=>1],
            ["id"=>"3","name"=>"الأسكندرية", "country_id"=>1],
            ["id"=>"4","name"=>"الدقهلية", "country_id"=>1],
            ["id"=>"5","name"=>"البحر الأحمر", "country_id"=>1],
            ["id"=>"6","name"=>"البحيرة", "country_id"=>1],
            ["id"=>"7","name"=>"الفيوم", "country_id"=>1],
            ["id"=>"8","name"=>"الغربية", "country_id"=>1],
            ["id"=>"9","name"=>"الإسماعلية", "country_id"=>1],
            ["id"=>"10","name"=>"المنوفية", "country_id"=>1],
            ["id"=>"11","name"=>"المنيا", "country_id"=>1],
            ["id"=>"12","name"=>"القليوبية", "country_id"=>1],
            ["id"=>"13","name"=>"الوادي الجديد", "country_id"=>1],
            ["id"=>"14","name"=>"السويس", "country_id"=>1],
            ["id"=>"15","name"=>"اسوان", "country_id"=>1],
            ["id"=>"16","name"=>"اسيوط", "country_id"=>1],
            ["id"=>"17","name"=>"بني سويف", "country_id"=>1],
            ["id"=>"18","name"=>"بورسعيد", "country_id"=>1],
            ["id"=>"19","name"=>"دمياط", "country_id"=>1],
            ["id"=>"20","name"=>"الشرقية", "country_id"=>1],
            ["id"=>"21","name"=>"جنوب سيناء", "country_id"=>1],
            ["id"=>"22","name"=>"كفر الشيخ", "country_id"=>1],
            ["id"=>"23","name"=>"مطروح", "country_id"=>1],
            ["id"=>"24","name"=>"الأقصر", "country_id"=>1],
            ["id"=>"25","name"=>"قنا", "country_id"=>1],
            ["id"=>"26","name"=>"شمال سيناء", "country_id"=>1],
            ["id"=>"27","name"=>"سوهاج", "country_id"=>1]
        ];

        foreach($data as $item){
            Governorate::create($item);
        }
        
    }
}
