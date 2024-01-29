<?php

namespace App\Livewire;

use App\Models\City as ModelsCity;
use App\Services\CityService;
use Livewire\Component;
class City extends Component
{
    public $governorate_id = null;
    public $cities = null;
    public $selected_city = null;
    public $field_name = 'city_id';
    public $title = "cities";

    public function mount()
    {
        $this->cities = \App\Models\City::all()->where("governorate_id", $this->governorate_id);
    }

    public function updatedSelectedCity()
    {
        $this->emit('citySelected', $this->selected_city);
    }
    
    public function render()
    {
        return view('livewire.city');
    }
}
