/**
 * ProductHelpers.js
 * Author: Loc Huynh
 * Date: 2022-06-24
 * Purpose: Function helpers for product component
 */

 $(document).ready(function() {
    // Process dynamic table
    $('#tblProductOption').dynamicTable({
        delAction: 'delete',
        preAddCallback: function () {
            // Handle logic before adding 
        },
        postAddCallback: function (insertedRow) {
            // Handle logic after adding
            resetRowNumber(); 
			
            insertedRow.find('.optionDetail').tagify({
                duplicates: false,
                tagTextProp: 'value',
                trim:true,
            });
        },
        preDelCallback: function (selectedRow) {
            // Handle logic before deleting
            var result = confirmDelete();

            if(result == false){
                return false;
            }
        },
        postDelCallback: function () {
            // Handle logic after deleting
            resetRowNumber();
			$('#tblProductOptionDetails').hide();
        }
    });

    // Process option details
    $('#tblProductOption').find('tbody .optionDetail').tagify({
        duplicates: false,
        tagTextProp: 'value',
        trim:true,
    });

    processChooseProductOption();
    processCreateOption();
	processCreatePriceForOption();
	
    // Process events for option products
    function processChooseProductOption() {
        $('[name="is_option"]').change(function(e, trigger = true) {
            if (!trigger) return;

            var haveOption = $(this).val();

            if (haveOption == 'Have option') {
                $('#productHaveOption').show();
                $('#noOptionPrice').hide();
                $('[name="noOptionPrice"]').val('');
            }
            else {
                $('#productHaveOption').hide();
                $('#noOptionPrice').show();
            }
        }).trigger('change');
    }

    // Process create there options of product
    function processCreateOption() {
        $('.btnCreateOption').click(function() {
            let optionDetail = getOptionDetails();
            let attrs = [];

            // Livewire.set('productOptionDetail', dateText);
            $('[name="productOptionDetail"]').val(JSON.stringify(optionDetail));
			window.livewire.emit("setProductOption", optionDetail);

            for (const [attr, values] of Object.entries(optionDetail))
                attrs.push(values.map(v => ({[attr]:v})));

                attrs = attrs.reduce((a, b) => a.flatMap(d => b.map(e => ({...d, ...e})))
            );

            $('#tblProductOptionDetails').css('display', 'table');
            $('#tblProductOptionDetails tbody').html(''); 
			
			console.log(attrs);

            $.each(attrs, function(index, value) {
                var optionName = '';

                $.each(value, function(optionKey, optionValue) {
                    optionName += `${optionKey} ${optionValue} - `;
                })

                var cloneOption = $('.tblOptionTemplate tr').clone();
                optionName = optionName.substring(0, optionName.length - 2);

                cloneOption.find('.optionNum').text(index + 1);
                cloneOption.find('.optionName').text(optionName);

                $('#tblProductOptionDetails tbody').append(cloneOption);
            })
        })
    }

    function getOptionDetails() {
        var optionDetails = {};

        $('#tblProductOption').find('tbody tr').each((index, value) => {
            var optionName = $(value).find('[name="optionName"]').val();
            optionDetails[optionName] = [];

            $(value).find('.tagify__tag ').each((tagIndex, item) => {
                optionDetails[optionName].push($(item).attr('value'));
            })
        })

        return optionDetails;
    }

	function processCreatePriceForOption() {
		$(document).on('change', '.inputPrice', function() {
			let optionPrice = [];

			$('#tblProductOptionDetails').find('tbody tr').each(function(element) {
				let currentPrice = $(this).find('.inputPrice').val();

				optionPrice.push(currentPrice);
			})

			window.livewire.emit("setProductOptionPrice", optionPrice);
		})
	}

    // Confirm delete
    function confirmDelete () {
        return confirm('Bạn có chắc chắn muốn xóa?');
    };

    // Reset row no
    function resetRowNumber () {
        var count = 1;
        $('tbody tr').each(function (e) {
            $(this).find('.num').text(count);

            count++;
        })
    }
})