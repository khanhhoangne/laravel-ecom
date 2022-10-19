<?php

namespace App\Http\Livewire\Warehouse;

use Illuminate\Support\Facades\Config;

use Livewire\Component;

class AdminAddImportComponent extends Component
{
    public function render()
    {
        $pageTitle = 'Nhập hàng';
        return view('livewire.warehouse.admin-add-import-component')->layout('layouts.base',['pageTitle' => $pageTitle, 'commandsOfUser' => Config::get('commands'), 'account' =>  Config::get('user'),]);;
    }
   
}
