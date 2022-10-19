<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\ProductSupplier;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminEditSupplierComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];
    
    public $supplier_name;
    public $supplier_slug;
    public $image;
    public $status;
    public $description;

    public $newImage;
    public $supplier_id;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'supplier_name' => 'Tên nhà cung ứng',
        'supplier_slug' => 'Liên kết tĩnh'
    ];

    public function setRules() {
        return [
            'supplier_name' => 'required',
            'supplier_slug' => 'required|unique:shop_suppliers,supplier_slug,' . $this->supplier_id,
        ];
    }

    public function mount($sup_slug) {
        $supplier = ProductSupplier::where('supplier_slug', $sup_slug)->first();

        $this->supplier_id = $supplier->id;
        $this->supplier_name = $supplier->supplier_name;
        $this->supplier_slug = $supplier->supplier_slug;
        $this->image = $supplier->image;
        $this->status = $supplier->status;
        $this->description = $supplier->description;
    }

    public function generateslug() {
        $this->supplier_slug = Str::slug($this->supplier_name);
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateSupplier() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $supplier = ProductSupplier::find($this->supplier_id);
        $supplier->supplier_name = $this->supplier_name;
        $supplier->supplier_slug = $this->supplier_slug;
        $supplier->status = $this->status;
        $supplier->description = $this->description;

        if ($this->newImage) {
            $imageName = $this->supplier_slug.Carbon::now()->timestamp. '.' .$this->newImage->extension();
            $this->newImage->storeAs('public/uploads/suppliers', $imageName);

            $supplier->image = $imageName;
        }

        $supplier->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật nhà cung ứng thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('suppliers');
    }

    public function render() {
        $pageTitle = 'Cập nhật nhà cung ứng';

        return view('livewire.suppliers.admin-edit-supplier-component')->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
