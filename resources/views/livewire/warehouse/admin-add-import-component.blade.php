<main id="main" class="main">

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('import')}}">Danh sách nhập</a></li>
                <li class="breadcrumb-item active">Nhập hàng</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-6">
                                <h5 class="card-title">Nhập hàng</h5>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('import')}}" class="btn btn-primary btnRedirect">Danh sách nhập</a>
                            </div>
                        </div>

                        <!-- Vertical Form -->
                        <form class="row g-3">
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Cửa Hàng</label>
                                <select class="form-select store">
                                    <option value="1">Techchains Ecommerce</option>
                                </select>

                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Người nhập</label>
                                <select class="form-select">
                                    <option>Hoàng Gia Khánh</option>
                                </select>

                            </div>

                            <div class="col-12 product_option_form">
                                <label for="inputNanme4" class="form-label">Sản phẩm</label>
                                <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" id="search_input">
                                <div class="product_option_true d-none">

                                </div>
                                <ul class="product_option d-none">

                                </ul>

                            </div>

                            <div class="row g-3 show-option">

                            </div>

                            <div class="col-5">
                                <label for="inputNanme4" class="form-label">Số lượng</label>
                                <input id="quantity_input" type="number" class="form-control" placeholder="Nhập số lượng">

                            </div>
                            <div class="col-5">
                                <label for="inputNanme4" class="form-label">Giá cả</label>
                                <input id="price_input" type="number" class="form-control" placeholder="Nhập giá">

                            </div>

                            <div class="col-2" style="align-items: flex-end; display: flex;">
                                <button type="button" onclick="addProduct()" class="btn btn-primary">Thêm</button>
                            </div>
                            <div class="col-12">
                                <div style="max-height:400px; overflow:auto;">
                                    <table class="table-custom">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Biến thể</th>
                                                <th scope="col">Giá trị</th>
                                                <th scope="col">Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="import-button" class="btn btn-primary">Thêm mới</button>
                                <button type="reset" class="btn btn-secondary">Tạo lại</button>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    const searchInput = document.querySelector('#search_input');
    const productOptionSelected = document.querySelector('.product_option_true');
    const productOption = document.querySelector('.product_option');
    const tableProduct = document.querySelector('.table-custom tbody');
    var id = 0;

    const BASE_URL = '{{ url("/") }}' + '/';
    var importData = {
        store_id: 1,
        employee_id: 1,
        import_detail: [

        ]
    }

    const removeByAttr = function(arr, attr, value) {
        var i = arr.length;
        while (i--) {
            if (arr[i] &&
                arr[i].hasOwnProperty(attr) &&
                (arguments.length > 2 && arr[i][attr] === value)) {

                arr.splice(i, 1);

            }
        }
        return arr;
    }

    function addProduct() {
        const selectedOption = document.querySelector('.select-option');
        const quantity = document.querySelector('#quantity_input');
        const price = document.querySelector('#price_input');
        const productSelected = document.querySelector('#product_id');
        const productOptionTextSelected = document.querySelector('.product_option_true p:nth-child(2)');

        let str = "";

        if (quantity.value == '' || price.value == '' || productSelected == null) {
            console.log('cannot added product');
            Swal.fire(
                'Lỗi!',
                'Vui lòng nhập đầy đủ thông tin!',
                'error'
            )
            return;
        }

        importData.import_detail.push({
            id: ++id,
            quantity: quantity.value,
            unit_price: price.value,
            product_option: (selectedOption != undefined) ? selectedOption.options[selectedOption.selectedIndex].value : 0,
            product_id: productSelected.dataset.product
        })

        str += `<tr id="productAdded-${id}">
                    <td>${productOptionTextSelected.innerHTML}</td>

                    <td class="text-center">${(selectedOption != undefined) ? (selectedOption.options[selectedOption.selectedIndex].text).replace('|', '') : ''}</td>
                    <td class="text-center">${formatNumber(price.value)}<br>${quantity.value}</td>
                    <td class="text-center">
                        <span onclick="deteleProductAdded(${id})">
                            <i class="bi bi-x-circle text-danger" style="cursor: pointer;"></i>
                        </span>
                    </td>
                </tr>`
        tableProduct.innerHTML += str;

    }

    function deteleProductAdded(id) {
        document.querySelector('#productAdded-' + id).remove();
        removeByAttr(importData.import_detail, 'id', id);
    }

    document.querySelector('#import-button').onclick = () => {
        let API_URL = BASE_URL + 'api/warehouse';
        fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                body: JSON.stringify(importData),
            })
            .then(res => res.json())
            .then(res => {
                if (res.code === 201) {
                    Swal.fire({
                            type: 'success',
                            title: 'Thành công',
                            confirmButtonText: 'OK',
                            text: 'Nhập hàng thành công!!!',
                            footer: '',
                            showCloseButton: true
                        })
                        .then(function(result) {
                            if (result.value) {
                                window.location = BASE_URL + 'import';
                            }
                        })
                } else {
                    Swal.fire(
                        'Lỗi!',
                        'Vui lòng nhập đầy đủ thông tin!',
                        'error'
                    )
                }
            })
    }


    window.onchange = () => {
        const optionElement = document.querySelectorAll('.product_option li');
        optionElement.forEach(element => {
            element.onclick = () => {
                productOptionSelected.classList.remove('d-none');
                productOptionSelected.innerHTML = getBlockProductOptionSelected(element.dataset.product, element.innerHTML);
                searchInput.value = '';
                searchInput.removeAttribute("placeholder");
                searchInput.setAttribute('readonly', true);
                productOption.innerHTML = '';
                productOption.classList.add('d-none');
                productDetail(element.dataset.product);
            }
        })
    }

    function productDetail(id) {
        let API_URL = BASE_URL + 'api/product/' + id;
        fetch(API_URL)
            .then(res => res.json())
            .then(res => {
                if (res.code !== 200 || !res.data.list_option.length) {
                    return;
                }
                document.querySelector('.show-option').innerHTML = getBlockProductOption(res.data.list_option);
            })
    }

    searchInput.onkeyup = () => {
        let API_URL = BASE_URL + 'api/product/?q=' + searchInput.value;

        if (!searchInput.value) {
            productOption.classList.add('d-none');
            return;
        }

        fetch(API_URL)
            .then(res => res.json())
            .then(res => {

                if (res.code !== 200) {
                    productOption.classList.add('d-none');
                    return;
                }

                productOption.classList.remove('d-none');
                productOption.innerHTML = getBlockProduct(res.data);
            })
            .catch(err => console.log(err))
    }

    function getBlockProductOption(arrayOption) {
        str = `
                <div class="col-12" id="option">
                    <label class="form-label">Biến thể</label>
                    <select class="form-select select-option">
                        {replace}
                    </select>
                </div>
            `;

        let strOption = "";

        arrayOption.forEach((element) => {
            let dataOption = "";
            let id = "";
            element.forEach((ele, index) => {
                if(ele.option_id != undefined) {
                    if (index == element.length - 1) return;
                    dataOption += `${ele.detail}`;
                    id += `${ele.option_id}`
                    if (index < element.length - 3) {
                        dataOption += '  |  ';
                        id += ',';
                    }
                } 
            })
            strOption += `<option class="text-center" value="${id}">${dataOption}</option>`
        });

        str = str.replace('{replace}', strOption);

        return str;
    }

    function getBlockProduct(data) {
        let str = '';
        data.forEach(element => {
            str += `
                <li data-product="${element.id}">
                    <p>
                        ${element.product_name}
                    </p>
                </li>
            `;
        });
        return str;
    }

    function getBlockProductOptionSelected(id, name) {
        return `
            <p id="product_id" data-product="${id}">
                ${name}
                <i class="bi bi-x-circle text-danger" onclick="removeOptionSelected()" id="remove-option" style="cursor: pointer;"></i>
            </p>
        `;
    }


    function removeOptionSelected() {
        productOptionSelected.classList.add('d-none');
        productOptionSelected.innerHTML = '';
        searchInput.removeAttribute('readonly');
        searchInput.setAttribute("placeholder", 'Nhập tên sản phẩm');
        document.querySelector('.show-option').innerHTML = '';
    }

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }
</script>