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
                            <h4 class="card-title">Requsition</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            {{ Auth::user()->name }} > Requsition
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive border rounded">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row mt-4" style="margin-left: 75px;">
                                            <div class="col-md-4">
                                                <label for="">Contractor</label>
                                                <select name="project_contractor"
                                                    class="form-control form-select contractorSelect" data-trigger
                                                    id="selectNow" required>
                                                    <option value="">Choose Contractor</option>
                                                    @foreach ($contractors as $contractor)
                                                        <option value="{{ $contractor->id }}">
                                                            {{ $contractor->contractorName->name ?? $contractor->project_contractor }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Project Code</label>
                                                <select name="project_code" class="form-control form-select account"
                                                    id="orderId" required>
                                                    <option value="">Choose Project Code</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="" style="" class=""></label>
                                                <button type="submit" class="btn btn-primary form-control mt-2"
                                                    id="filter">
                                                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"
                                                        style="display: none;" id="loader"></i>Filter</button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-body">
                                            <form id="frm_main" method="post" onsubmit="signUp(event)">
                                                @csrf
                                                <div class="col-xl-12">
                                                    <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                                                        <hr class="hr-horizontal">
                                                        <div class="header-title">
                                                            <h4 class="card-title">Material</h4>
                                                        </div>
                                                        <div class="invoice-to-wrap pb-20">
                                                            <div class="row">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table  table-bordered table-review review-table mb-0"
                                                                        id="table_alterations">
                                                                        <tr>
                                                                            {{--  <th style="width: 50px;text-align: center;">S/N</th>  --}}
                                                                            <th style="width: 230px;text-align: center;">
                                                                                Stock</th>
                                                                            <th style="width: 110px;text-align: center;">
                                                                                Price</th>
                                                                            <th style="width: 110px;text-align: center;">
                                                                                Quantity</th>
                                                                            <th style="width: 110px;text-align: center;">
                                                                                Supplied Price</th>
                                                                            <th style="width: 110px;text-align: center;">
                                                                                Supplied Quantity</th>
                                                                            <th style="width: 110px;text-align: center;">
                                                                                Amount</th>
                                                                        </tr>
                                                                        <tbody id="table_alterations_tbody">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="hr-horizontal">
                                                        <div class="header-title">
                                                            <h4 class="card-title">Labour</h4>
                                                        </div>
                                                        <div class="invoice-to-wrap pb-20">
                                                            <div class="row">
                                                                <div class="table-responsive">
                                                                    <table id=""
                                                                        class="table  table-bordered table-review review-table mb-0"
                                                                        id="table_alterations">
                                                                        <tr>
                                                                            <th style="width: 230px; text-align: center;">
                                                                                Name</th>
                                                                            <th style="width: 230px; text-align: center;">
                                                                                Amount</th>
                                                                            {{--  <th style="width: 64px;"><button type="button"
                                                                                    class="btn btn-primary btn-add-row2">Add</button>
                                                                            </th>  --}}
                                                                        </tr>
                                                                        <tbody id="table_alterations_tbody2">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm">

                                                                <div class="form-group row">
                                                                    <label for="inputPassword3"
                                                                        class="col-sm-2 col-form-label"></label>
                                                                    <div class="col-sm-4">
                                                                        <!-- <input type="number" style="text-align: right;" class="form-control" id="inputPassword3" name="all_sum"> -->
                                                                    </div>
                                                                    <label for="inputPassword3" style="text-align: end;"
                                                                        class="col-sm-2 col-form-label">Total Amount
                                                                        :</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" readonly
                                                                            style="text-align: right;" required
                                                                            class="form-control" id="total_sum"
                                                                            name="project_estimate">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <ul class="invoice-terms-wrap font-14 list-ul">
                                                            <button type="submit" class="btn btn-primary mr-2"
                                                                id="submit">
                                                                Submit<span class="spinner-border loader spinner-border-sm"
                                                                    role="status" aria-hidden="true"
                                                                    style="display:none"></span>
                                                            </button>
                                                        </ul>
                                                    </section>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("form").on('submit', async function(e) {
                var loader = $(".loader2");
                //alert('here');
                loader.show();
            })

            $(".contractorSelect").on("change", function(e) {
                $("#orderId").empty()
                var id = $(this).val(); // $(this).data('id');
                // alert(id)
                $(".preloader").show()
                $.ajax({
                    url: '{{ route('get-requisition-pending-order') }}?id=' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var len = 0;
                        len = response['data'].length;

                        if (len > 0) {

                            for (var i = 0; i < len; i++) {
                                $("#orderId").append(
                                    `<option value="${response['data'][i].project_code}">
                                    ${response['data'][i].project_code}
                                </option>`
                                );
                            }
                            $("#orderId").prepend(
                                "<option value='' selected='selected'>Choose Project</option>"
                            );
                            $(".preloader").hide()
                        } else {
                            $("#orderId").append(
                                "<option value='' selected='selected'>Choose Project</option>"
                            );
                            $(".preloader").hide()
                        }
                    }
                });
            });
            var loader = $("#loader")
            $('#filter').on('click', async function(e) {
                e.preventDefault();

                var contractorid = $('.contractorSelect option:selected').val();
                var orderId = $('#orderId option:selected').val();
                if (contractorid == "") {
                    swal("Kindly choose contractor !");
                }
                if (orderId == "") {
                    swal("Kindly choose Project !");
                }
                if (orderId == "" || contractorid == "") {
                    event.preventDefault();
                    swal("Kindly check inputs !");
                } else {

                    loader.show();
                    // preLoader.show();

                    // $(".table").DataTable().clear().destroy();
                    function makeid(length) {
                        var result = '';
                        var characters =
                            'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                        var charactersLength = characters.length;
                        for (var i = 0; i < length; i++) {
                            result += characters.charAt(Math.floor(Math.random() *
                                charactersLength));
                        }
                        return result;
                    }
                    try {
                        const getApplications = await request(
                            "{{ route('get-requisition-by-id') }}?id=" +
                            orderId +
                            "&contractorid=" +
                            contractorid);
                        loader.hide();
                        console.log(getApplications);
                        const randomId = makeid(5);
                        var len = 0;
                        len = getApplications['data'][0].length;
                        const tbodyEl = $('#table_alterations_tbody');
                        const tbodyEl2 = $('#table_alterations_tbody2');
                        tbodyEl.empty()
                        if (len == 0) {
                            swal("No Record Found !");
                        } else {
                            getApplications.data[0].forEach((records, index) => {

                                tbodyEl.append(
                                    `<tr>
                                      <input type="hidden" name="id[]" value="${records.id}">
                                      <td class="col-md-2 mt-3">${records.description}</td>
                                    <td class="col-md-2 mt-3">${records.material_price}</td>
                                    <td class="col-md-2 mt-3">${records.material_quantity}</td>
                                    <td class="col-md-2 mt-3">
                                        <input type="number" name="supplied_price[]" id="unit-${randomId}" class="form-control" required>
                                    </td>
                                    <td class="col-md-2 mt-3">
                                        <input type="number" name="supplied_quantity[]" id="unit-${randomId}" class="form-control" required>
                                    </td>
                                    <td class="col-md-2 mt-3">
                                        <input type="number" name="supplied_amount[]" id="unit-${randomId}" class="form-control" required>
                                    </td>
                                    <td style="height:30px;display:none"><input style="text-align: right; height:30px;" id="amount-${randomId}" type="text" readonly name="total_amount[]" class="form-control input" value=""></td>
                                </tr>`
                                );
                                tbodyEl2.append(
                                    `<tr>
                                      <input type="hidden" name="id[]" value="${records.id}">
                                      <td class="col-md-5 mt-3">${records.description}
                                        <input type="text" name="[]" class="form-control" required>
                                    </td>
                                    <td class="col-md-5 mt-3">
                                        <input type="number" name="labour_amount[]" class="form-control pricelist" onkeyup="calculateTotalAmountForRows()" required>
                                    </td>
                                    <td style="height:30px;display:none"><input style="text-align: right; height:30px;" id="amount-${randomId}" type="text" readonly name="total_amount[]" class="form-control input" value=""></td>
                                </tr>`
                                );
                            });

                            swal("Transaction Succesful !");
                            loader.hide();
                        }
                    } catch (e) {
                        loader.hide();
                        swal("Opss", e.message, "error");
                    }
                }
            });

        });
    </script>
@endsection
