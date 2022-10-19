<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use App\UseCases\Import\ImportUseCase;
use App\UseCases\ImportDetail\ImportDetailUseCase;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;
use Session;

class AdminImportComponent extends Component
{
    use WithPagination;
    private $importUseCase;
    private $importDetailUseCase;
    private $imports;
    public $importDetails;
    public $show = false;
    public $date;
    private $filtered = false;
    public $take;
    public $sortType;
    public $importsTotal;


    public function boot(ImportUseCase $importUseCase, ImportDetailUseCase $importDetailUseCase)
    {
        $this->importUseCase = $importUseCase;
        $this->importDetailUseCase = $importDetailUseCase;
        $this->sortType = 'desc';
        // if(!$this->filtered) {
        //     $this->imports = $this->importUseCase->getAllByDate(date("Y-m-d"));
        // }
        if(strpos(request()->headers->get('referer'), 'import/add') !== false) {
            $this->date = date("Y-m-d");
        }
        $this->filterByDate();
        
        
    }

    public function filterByDate() {        
        $this->imports = $this->importUseCase->getAllByDate($this->date ?? Session::get('date_search') ?? date("Y-m-d"));
        if(!empty($this->date)) {
            Session::put('date_search', $this->date);
            if(empty($this->imports)) {
                $this->dispatchBrowserEvent('alert', 
                ['type' => 'error',  'message' => 'Dữ liệu không được tìm thấy!']);
            } else {
                $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => "".count($this->imports)." kết quả được tìm thấy!"]);
            }
        }
        $this->take = count($this->imports);
        $this->importsTotal = count($this->imports);
    }

    public function filterByRange($value) {
        $this->take = $value;
    }

    public function filterByCol($value) {
        if($this->sortType === 'desc' && $this->take > 1) {
            $this->sortType = 'asc';
        } elseif ($this->sortType === 'asc' && $this->take > 1) {
            $this->sortType = 'desc';
        }
        if($this->take > 1) {
            $this->imports = $this->importUseCase->getAllByDate($this->date ?? Session::get('date_search') ?? date("Y-m-d"), $value, $this->sortType);
            if($this->take < count($this->imports)) {
                if($this->sortType === 'asc'){
                    $revertKey = count($this->imports) - $this->take;
                    // dd($revertKey);
                }
                foreach ($this->imports as $key => $value) {
                    if($this->sortType === 'desc' && $key >= $this->take) {
                        unset($this->imports[$key]);
                    }elseif($this->sortType === 'asc' && $key <= $revertKey - 1){
                        // dd('cc');
                        unset($this->imports[$key]);
                    }
                }         
            }
        }
    }

    public function getImportDetail($id)
    {
        $this->importDetails = $this->importDetailUseCase->getImportDetail($id);
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        $pageTitle = 'Danh sách nhập hàng';
        return view('livewire.warehouse.admin-import-component', ['imports' => $this->imports])
            ->layout(
                'layouts.base',
                [
                    'pageTitle' => $pageTitle,
                    'commandsOfUser' => Config::get('commands'),
                    'account' =>  Config::get('user'),
                ]
            );
    }
}
