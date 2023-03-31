@extends('layouts.master')
@section('headlinks')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('contents')
    <div class="preloader" style="display: none">
        <div class="spinner-grow text-info m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Project</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateproject') }}" onsubmit="$('.preloader').show()">
                            @csrf
                            <input type="hidden" id="" name="id" value="{{ $project->id }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="project_name" value="{{ $project->project_name ?? '' }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="project_description" value="{{ $project->project_description ?? '' }}" required>{{ $project->project_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustomUsername" class="form-label">Start Date</label>
                                    <div class="form-group input-group">
                                        <input type="date" name="project_start_date"
                                            value="{{ $project->project_start_date ?? '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="project_end_date"
                                        value="{{ $project->project_end_date ?? '' }}"class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contractor</label>
                                    <select name="project_contractor" class="form-control" required>
                                        @foreach ($contractors as $contractor)
                                            <option value="{{ $project->project_contractor ?? '' }}">{{ $contractor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr class="hr-horizontal">
                            <div class="header-title">
                                <h4 class="card-title">Edit Materials</h4>
                            </div>
                            <div class="invoice-to-wrap pb-20">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-review review-table mb-0" id="table_alterations">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;text-align: center;">S/N</th>
                                                    <th style="width: 230px;text-align: center;">Material</th>
                                                    <th style="width: 110px;text-align: center;">Price</th>
                                                    <th style="width: 110px;text-align: center;">Quantity</th>
                                                    <th style="width: 64px;"><button type="button"
                                                            class="btn btn-primary btn-add-row">Add</button></th>
                                                </tr>
                                            </thead>
                                            @foreach ($materials as $material)
                                                <tbody id="table_alterations_tbody">
                                                    <td class="col-md-1 mt-3">{{ $loop->iteration ?? '' }}</td>
                                                    <td class="col-md-4 mt-3">
                                                        <select class="form-select stock" name="material_stock[]"
                                                            aria-label="select example"
                                                            onchange="handleSelectedStock('${randomId}')" required>
                                                            <option value="">Select Material</option>
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}"
                                                                    {{ $stock->id == $material->material_stock ? 'selected' : '' }}
                                                                    required>
                                                                    {{ $stock->description ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="col-md-4 mt-3">
                                                        <input type="number" name="material_price[]"
                                                            id="unit_price-${randomId}"
                                                            value="{{ $material->material_price ?? '' }}"
                                                            class="form-control pricelist"
                                                            onkeyup="calculateTotalAmountForRows()" required>
                                                    </td>
                                                    <td class="col-md-4 mt-3">
                                                        <input type="number" name="material_quantity[]"
                                                            id="unit-${randomId}"
                                                            value="{{ $material->material_quantity ?? '' }}"
                                                            class="form-control" required>
                                                    </td>
                                                    <td><button type="button" class="btn btn-danger"
                                                            id="comments_remove">remove</button></td>
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-horizontal">
                            <div class="header-title">
                                <h4 class="card-title">Edit Labour</h4>
                            </div>

                            <div class="invoice-to-wrap pb-20">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-review2 review-table mb-0" id="table2_alterations">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px; text-align: center;">S/N</th>
                                                    <th style="width: 230px; text-align: center;">Name</th>
                                                    <th style="width: 230px; text-align: center;">Amount</th>
                                                    <th style="width: 64px;"><button type="button"
                                                            class="btn btn-primary btn-add-row2">Add</button></th>
                                                </tr>
                                            </thead>
                                            @foreach ($labours as $labour)
                                                <tbody id="table2_alterations_tbody">
                                                    <input type="text" name="labour_id[]" value="{{ $labour->id }}"
                                                        hidden>
                                                    <td class="col-md-1 mt-3">{{ $loop->iteration ?? '' }}</td>
                                                    <td class="col-md-5 mt-3">
                                                        <input type="text" name="labour_name[]" class="form-control"
                                                            value="{{ $labour->labour_name ?? '' }}" required>
                                                    </td>
                                                    <td class="col-md-5 mt-3">
                                                        <input type="number" name="labour_amount[]"
                                                            value="{{ $labour->labour_amount ?? '' }}"
                                                            class="form-control pricelist"
                                                            onkeyup="calculateTotalAmountForRows()" required>
                                                    </td>
                                                    <td><button type="button" class="btn btn-danger"
                                                            id="comments_remove2">remove</button></td>
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-horizontal">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-4">
                                            <!-- <input type="number" style="text-align: right;" class="form-control" id="inputPassword3" name="all_sum"> -->
                                        </div>
                                        <label for="inputPassword3" style="text-align: end;"
                                            class="col-sm-2 col-form-label">Project Estimate
                                            :</label>
                                        <div class="col-sm-4">
                                            <input type="text" readonly style="text-align: right;" required
                                                class="form-control" id="total_sum" name="project_estimate"
                                                value="{{ $project->project_estimate }}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save <span
                                        class="spinner-border loader1 spinner-border-sm" role="status"
                                        aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </form>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-project', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get('{{ route('getstock') }}?id=' + id, function(data) {
                    // console.log(data[2]);
                    $('#uStockname').val(data.stock_name);
                    $('#uDescription').val(data.description);
                    $('#uPrice').val(data.price);
                    $('#uQuantity').val(data.quantity);
                    $('#uCategories').val(data.categories);
                    $('#uId').val(id);
                })
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#submitBTN").on('click', async function(e) {
                e.preventDefault();
                try {
                    const willUpdate = await new swal({
                        title: "Confirm Form submit",
                        text: `Are you sure you want to submit this form?`,
                        icon: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes!",
                        showCancelButton: true,
                        buttons: ["Cancel", "Yes, Submit"]
                    });
                    // console.log(willUpdate);
                    if (willUpdate) {
                        //performReset()
                        $("#createStock").submit();
                    } else {
                        swal("Project will not be added  :)");
                    }
                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        swal("Opss", e.message, "error");
                        loader.hide();
                    }
                }
            })
        })
    </script>

    <script>
        const getRow = ($id) => $(`#select2-${$id}`).closest("tr");

        const handleSelectedStock = ($id) => {
            const row = getRow($id);

            const unitEl = row.find(`#unit-${$id}`);
            const discountEl = row.find(`.unitDiscount-${$id}`);

            const unit = unitEl.val();

            handleInput(row, $id, unitEl, );

            $(".input").on("keyup change click", () => handleInput(row, $id, unitEl, ));

            const $select = row.find(`#select2-${$id}`);

            unitEl.val("");
            $.get('{{ 'here' }}?id=' + $($select).val(), function(data) {
                // route('get_stock_quantity')
                console.log(data.quantity)
                discountEl.val(data.quantity);

            })
        }

        $(function() {
            $(document).on("click", '.btn-add-row', function() {
                var id = $(this).closest("table.table-review").attr('id'); // Id of particular table
                //   console.log(id);
                var div = $("<tr />");
                console.log(div);
                div.html(GetDynamicTextBox(id));
                $("#" + id + "_tbody").append(div);
            });

            $(document).on("click", "#comments_remove", function() {
                $(this).closest("tr").prev().find('td:last-child').html(
                    '<button type="button" class="btn btn-danger" id="comments_remove">remove</button>'
                );
                $(this).closest("tr").remove();

                // Calculate the total sum for all available rows
                calculateTotalAmountForRows()

                // Calculate the total discount for all available rows
                calculateTotalDiscountForRows()
            });

            function makeid(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }

            function GetDynamicTextBox(table_id) {
                // $('#comments_remove').remove();
                const randomId = makeid(5);
                var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0]
                    .getElementsByTagName("tr").length + 1;
                return `<td>${rowsLength}</td>
        <td class="col-md-4 mt-3">
            <select class="form-select stock" id="select2-${randomId}" name="material_stock[]" aria-label="select example" onchange="handleSelectedStock('${randomId}')" required>
                <option value="">Select Stock</option>
                @foreach ($stocks as $stock)
                <option value="{{ $stock->id }}" required >{{ $stock->description }}</option>
                @endforeach
            </select>
        </td>
        <td class="col-md-4 mt-3">
            <input type="number" name="material_price[]" id="unit_price-${randomId}" class="form-control pricelist" onkeyup="calculateTotalAmountForRows()" required>
        </td>
        <td class="col-md-4 mt-3">
            <input type="number" name="material_quantity[]" id="unit-${randomId}" class="form-control" required>
        </td>
        <td style="height:30px;display:none"><input style="text-align: right; height:30px;" id="amount-${randomId}" type="text" readonly name="total_amount[]" class="form-control input" value=""></td>
        <td><button type="button" class="btn btn-danger" id="comments_remove">remove</button></td>`
            }
        });


        //Labour Cost
        $(function() {
            $(document).on("click", '.btn-add-row2', function() {
                var id = $(this).closest("table.table-review2").attr('id'); // Id of particular table
                //   console.log(id);
                var div = $("<tr />");
                console.log(div);
                div.html(GetDynamicTextBox(id));
                $("#" + id + "_tbody").append(div);
            });

            $(document).on("click", "#comments_remove2", function() {
                $(this).closest("tr").prev().find('td:last-child').html(
                    '<button type="button" class="btn btn-danger" id="comments_remove2">remove</button>'
                );
                $(this).closest("tr").remove();

                // Calculate the total sum for all available rows
                calculateTotalAmountForRows()

                // Calculate the total discount for all available rows
                calculateTotalDiscountForRows()
            });

            function makeid(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }

            function GetDynamicTextBox(table_id) {
                // $('#comments_remove').remove();
                const randomId = makeid(5);
                var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0]
                    .getElementsByTagName("tr").length + 1;
                return `<input type="text" name="labour_id[]" value="" hidden>
                <td>${rowsLength}</td>
        <td class="col-md-5 mt-3">
            <input type="text" name="labour_name[]" class="form-control" required>
        </td>
        <td class="col-md-5 mt-3">
            <input type="number" name="labour_amount[]" class="form-control pricelist" onkeyup="calculateTotalAmountForRows()" required>
        </td>
        <td style="height:30px;display:none"><input style="text-align: right; height:30px;" id="amount-${randomId}" type="text" readonly name="total_amount[]" class="form-control input" value=""></td>
        <td><button type="button" class="btn btn-danger" id="comments_remove2">remove</button></td>`
            }
        });

        function calculateTotalAmountForRows() {
            let totalSum = 0;
            $('.pricelist').each(function() {
                const $value = $(this).val();
                var val = !$value ? 0 : $value;
                if (!isNaN(val)) {
                    totalSum = totalSum + parseFloat(val);
                }
            });
            $("#total_sum").val(totalSum);
        }

        function calculateTotalDiscountForRows() {
            var totalUnit = 0;
            $('input[id^="discount-"][type="text"]').each(function() {
                const $value = $(this).val();
                var val = !$value ? 0 : $value;
                if (!isNaN(val)) {
                    totalUnit = totalUnit + parseFloat(val);
                }
            });

            $("#total_unit").val(totalUnit);
        }

        function getTotal(unit) {
            return unit;
        }

        function updateAmountField(row, $id, total) {
            row.find(`#amount-${$id}`).val(total);
        }

        function updateFields(row, $id, unit) {
            // Update the Discount field
            // updateDiscountField(row, $id, getDiscount(unit, unitDiscount));
            // Calculate the total amount for a single row
            updateAmountField(row, $id, getTotal(unit));

            // Calculate the total sum for all available rows
            calculateTotalAmountForRows()

            // Calculate the total discount for all available rows
            calculateTotalDiscountForRows()
        }

        function handleInput(row, $id, unitEl, ) {
            const unit = unitEl.val();
            const discountEl = row.find(`.unitDiscount-${$id}`).val();
            if (parseInt(unit) > parseInt(discountEl)) {
                unitEl.val('0');
                const unit = 0;
                var final = parseInt(discountEl) - parseInt(unit);
                new swal("Insufficient material !", ` ${final} quantity in material`, "error");
                // new swal("Insufficient Stock!. final");
            }
            updateFields(row, $id, unit)
        }
    </script>
@endsection
