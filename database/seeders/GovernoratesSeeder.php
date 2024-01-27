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
            ["id"=>"1","name"=>["ar"=>"القاهرة","en"=>"Cairo"]],
            ["id"=>"2","name"=>["ar"=>"الجيزة","en"=>"Giza"]],
            ["id"=>"3","name"=>["ar"=>"الأسكندرية","en"=>"Alexandria"]],
            ["id"=>"4","name"=>["ar"=>"الدقهلية","en"=>"Dakahlia"]],
            ["id"=>"5","name"=>["ar"=>"البحر الأحمر","en"=>"Red Sea"]],
            ["id"=>"6","name"=>["ar"=>"البحيرة","en"=>"Beheira"]],
            ["id"=>"7","name"=>["ar"=>"الفيوم","en"=>"Fayoum"]],
            ["id"=>"8","name"=>["ar"=>"الغربية","en"=>"Gharbiya"]],
            ["id"=>"9","name"=>["ar"=>"الإسماعلية","en"=>"Ismailia"]],
            ["id"=>"10","name"=>["ar"=>"المنوفية","en"=>"Menofia"]],
            ["id"=>"11","name"=>["ar"=>"المنيا","en"=>"Minya"]],
            ["id"=>"12","name"=>["ar"=>"القليوبية","en"=>"Qaliubiya"]],
            ["id"=>"13","name"=>["ar"=>"الوادي الجديد","en"=>"New Valley"]],
            ["id"=>"14","name"=>["ar"=>"السويس","en"=>"Suez"]],
            ["id"=>"15","name"=>["ar"=>"اسوان","en"=>"Aswan"]],
            ["id"=>"16","name"=>["ar"=>"اسيوط","en"=>"Assiut"]],
            ["id"=>"17","name"=>["ar"=>"بني سويف","en"=>"Beni Suef"]],
            ["id"=>"18","name"=>["ar"=>"بورسعيد","en"=>"Port Said"]],
            ["id"=>"19","name"=>["ar"=>"دمياط","en"=>"Damietta"]],
            ["id"=>"20","name"=>["ar"=>"الشرقية","en"=>"Sharkia"]],
            ["id"=>"21","name"=>["ar"=>"جنوب سيناء","en"=>"South Sinai"]],
            ["id"=>"22","name"=>["ar"=>"كفر الشيخ","en"=>"Kafr Al sheikh"]],
            ["id"=>"23","name"=>["ar"=>"مطروح","en"=>"Matrouh"]],
            ["id"=>"24","name"=>["ar"=>"الأقصر","en"=>"Luxor"]],
            ["id"=>"25","name"=>["ar"=>"قنا","en"=>"Qena"]],
            ["id"=>"26","name"=>["ar"=>"شمال سيناء","en"=>"North Sinai"]],
            ["id"=>"27","name"=>["ar"=>"سوهاج","en"=>"Sohag"]]
        ];

        foreach($data as $item){
            Governorate::create($item);
        }
        
    }
}
