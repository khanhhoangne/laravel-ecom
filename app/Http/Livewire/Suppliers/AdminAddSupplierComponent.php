<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\ProductSupplier;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminAddSupplierComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $supplier_name;
    public $supplier_slug;
    public $image;
    public $status;
    public $description;

    public $category_id;

    protected $rules = [
        'supplier_name' => 'required',
        'supplier_slug' => 'required|unique:shop_suppliers'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'supplier_name' => 'Tên nhà cung ứng',
        'supplier_slug' => 'Liên kết tĩnh'
    ];

    public function generateslug() {
        $this->supplier_slug = Str::slug($this->supplier_name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeSupplier() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $supplier = new ProductSupplier();
        $supplier->supplier_name = $this->supplier_name;
        $supplier->supplier_slug = $this->supplier_slug;
        $supplier->status = $this->status;
        $supplier->description = $this->description;

        // process value of position field
        $maxCurrentPosition = ProductSupplier::max('position');
        $supplier->position = $maxCurrentPosition + 1;

        if (!empty($this->image)) {
            $imageName = $this->supplier_slug . Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('public/uploads/suppliers', $imageName);

            $supplier->image = $imageName;
        }
        
        $supplier->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm nhà cung ứng thành công!',
            'text' => ''
        ]);

        $supplier = $this->reset();
    }

    public function redirectToListView() {
        return redirect()->route('suppliers');
    }

    public function render()
    {
        $pageTitle = 'Thêm mới Nhà cung ứng';

        return view('livewire.suppliers.admin-add-supplier-component')->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
