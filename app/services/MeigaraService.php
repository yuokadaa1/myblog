<?php

namespace App\Services;
use App\Models\Meigara;

class MeigaraService{
    public function getMeigara(){
        return Meigara::all();
    }
}
