<?php

namespace App\Http\Livewire\Commands;

use App\UseCases\Command\CommandUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminCommandComponent extends Component
{
    protected $listeners = ['delete' => 'deleteCommand'];
    private $commandUseCase;
    public $commands;

    public function boot(
        CommandUseCase $commandUseCase,
    ) {
        $this->commandUseCase = $commandUseCase;
        $this->commands = $this->commandUseCase->getAll();
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteCommand($id) {
        $this->commandUseCase->delete($id);

        $this->commands = $this->commandUseCase->getAll();
    }

    public function render()
    {
        $pageTitle = 'Danh sách module quản lý';

        return view('livewire.commands.admin-command-component',[
            'commands' => $this->commands
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
