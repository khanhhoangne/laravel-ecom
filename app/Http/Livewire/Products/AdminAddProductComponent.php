<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\ProductSupplier;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AdminAddProductComponent extends Component
{
    use WithFileUploads;
	
	protected $listeners = [
		'redirect' => 'redirectToListView',
		'setProductOption' => 'setProductOption',
		'setProductOptionPrice' => 'setProductOptionPrice'
	];

    public $product_name;
    public $product_slug;
    public $product_code;
    public $image;
    public $short_description;
    public $description;
    public $is_continued;
    public $is_featured;
    public $is_new;
    public $category_id;
    public $supplier_id;
    public $images = [];

    public $productOptionDetail;

    public $noOptionPrice;
    public $optionPriceDetail;

    protected $rules = [
        'product_name' => 'required',
        'product_slug' => 'required|unique:shop_products',
		'product_code' => 'unique:shop_products'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'product_name' => 'Tên sản phẩm',
        'product_slug' => 'Liên kết tĩnh',
		'product_code' => 'Mã sản phẩm'
    ];

    public function generateSlug() {
        $this->product_slug = Str::slug($this->product_name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeProduct() {
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $product = new Product();
        $product->product_name = $this->product_name;
        $product->product_slug = $this->product_slug;
        $product->product_code = $this->product_code;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->is_continued = $this->is_continued;
        $product->is_featured = $this->is_featured;
        $product->is_new = $this->is_new;
        $product->category_id = $this->category_id;
        $product->supplier_id = $this->supplier_id;

        // process value of position field
        if (!empty($this->image)) {
            $imageName = $this->product_slug . 'main' . Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('public/uploads/products', $imageName);

            $product->image = $imageName;
        }

        $product->save();

        if (count($this->images)) {
            foreach ($this->images as $key => $img) {
                $imageName = $this->product_slug . Carbon::now()->timestamp . $key. '.' . $img->extension();
                $img->storeAs('public/uploads/products', $imageName);
                $productGallery = new ProductGallery();
                $productGallery->product_id = $product->id;
                $productGallery->image = $imageName;
                $productGallery->save();
            }
        }

        $productId = $product->id;

        // process product price and option
        if (!empty($this->noOptionPrice)) {
            $this->storeProductPrice($productId, '', $this->noOptionPrice);
        }
        else {
            $productOption = $this->storeProductOption($productId);
            $this->storeProductPrice($productId, $productOption, $this->optionPriceDetail);
        }

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm sản phẩm thành công!',
            'text' => ''
        ]);

        $product = $this->reset();
    }

    public function storeProductOption($productId) {
        $optionDetail = $this->productOptionDetail;
        $optionDetailArray = [];

        foreach ($optionDetail as $optionKey => $optionValue) {
            $dataForDetail = [];

            for ($i = 0; $i < count($optionValue); $i++) {
                $productOption = new ProductOption();
                $productOption->product_id = $productId;
                $productOption->option = $optionKey;
                $productOption->detail = $optionValue[$i];
                $productOption->save();

                $dataForDetail[] = $productOption->id;
            }

            $optionDetailArray[] = $dataForDetail;
        }

        $result = $this->cartesian($optionDetailArray);

        return $result;
    }

    public function storeProductPrice($productId, $productOption, $productPrice) {
        if (!is_array($productPrice)) {
            $newProductPrice = new ProductPrice();
            $newProductPrice->product_id = $productId;
            $newProductPrice->price = $productPrice;
            $newProductPrice->save();
        }
        else {
            foreach ($productOption as $optionKey => $optionValue) {
                $productOptionPrice = new ProductPrice();
                $productOptionPrice->product_id = $productId;
                $productOptionPrice->option_id = implode(',', $optionValue);
                $productOptionPrice->price = floatval($productPrice[$optionKey]);

                $productOptionPrice->save();
            }
        }
    }

    public function storeProductGallery() {

    }

    function cartesian($input) {
        $result = array(array());
    
        foreach ($input as $key => $values) {
            $append = array();
    
            foreach($result as $product) {
                foreach($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }
    
            $result = $append;
        }
    
        return $result;
    }

	public function setProductOption($optionDetail) {
		$this->productOptionDetail = $optionDetail;
	}

	public function setProductOptionPrice($priceDetail) {
		$this->optionPriceDetail = $priceDetail;
	}

	public function redirectToListView() {
        return redirect()->route('products');
    }

    public function render() {
        $pageTitle = 'Thêm mới sản phẩm';

        $categories = ProductCategory::where('status', 'display')->get();
        $suppliers = ProductSupplier::where('status', 'Collab')->get();

        return view('livewire.products.admin-add-product-component', [
            'categories' => $categories,
            'suppliers' => $suppliers
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
