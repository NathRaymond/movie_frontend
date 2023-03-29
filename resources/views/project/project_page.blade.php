@extends('layouts.master')
@section('headlinks')
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
                            <h4 class="card-title">Project List</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            <a href="{{ route('add-project') }}" class="btn btn-primary mt-2">
                                + Add Project
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive border rounded">
                            <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Project Name</th>
                                        <th>Description</th>
                                        <th>Contractor</th>
                                        <th>Project Estimated</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Project Status</th>
                                        <th>Approval Status</th>
                                        <th style="min-width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $loop->iteration ?? '' }}</td>
                                            <td>{{ $project->project_name ?? '' }}</td>
                                            <td>{{ $project->project_description ?? '' }}</td>
                                            <td>{{ $project->project_contractor ?? '' }}</td>
                                            <td>{{ $project->project_estimate ?? '' }}</td>
                                            <td>{{ $project->project_start_date ?? '' }}</td>
                                            <td>{{ $project->project_end_date ?? '' }}</td>
                                            <td>
                                                @if ($project->status == 0)
                                                    <span class="badge badge-soft-success"
                                                        style="color: rgb(255, 106, 0); font-size:14px; background-color:#e5e5e5">Pending</span>
                                                @elseif($project->status == 1)
                                                    <span class="badge badge-soft-info"
                                                        style="color: rgb(84, 12, 218); font-size:14px; background-color:#e5e5e5">Ongoing</span>
                                                @else
                                                    <span class="badge badge-soft-danger"
                                                        style="color: green; font-size:14px; background-color:#e5e5e5">Finished</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if ($project->approval_status == 0)
                                                    <span class="badge badge-soft-success"
                                                        style="color: rgb(255, 106, 0); font-size:14px; background-color:#e5e5e5">Pending</span>
                                                @elseif($project->approval_status == 1)
                                                    <span class="badge badge-soft-info"
                                                        style="color: green; font-size:14px; background-color:#e5e5e5">Approve</span>
                                                @else
                                                    <span class="badge badge-soft-danger"
                                                        style="color: red; font-size:14px; background-color:#e5e5e5">Declined</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <button class="btn btn-sm btn-success rounded"
                                                        data-id="{{ $project->id }}" data-bs-toggle="modal"
                                                        data-bs-target="" id="approve_btn"><span class="btn-inner">
                                                            approve
                                                        </span></button>
                                                    {{--  call the reject_btn class ID in the javascript below  --}}
                                                    <button
                                                        class="btn btn-sm btn-danger rejectConsultant rounded reject_btn"
                                                        data-id="{{ $project->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit"><span class="btn-inner">
                                                            decline
                                                        </span></button>
                                                    <a class="btn btn-sm btn-icon btn-success rounded"
                                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                                        data-bs-original-title="View" href="#">
                                                        <span class="btn-inner">
                                                            <svg width="32" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M9.87651 15.2063C6.03251 15.2063 2.74951 15.7873 2.74951 18.1153C2.74951 20.4433 6.01251 21.0453 9.87651 21.0453C13.7215 21.0453 17.0035 20.4633 17.0035 18.1363C17.0035 15.8093 13.7415 15.2063 9.87651 15.2063Z"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M9.8766 11.886C12.3996 11.886 14.4446 9.841 14.4446 7.318C14.4446 4.795 12.3996 2.75 9.8766 2.75C7.3546 2.75 5.3096 4.795 5.3096 7.318C5.3006 9.832 7.3306 11.877 9.8456 11.886H9.8766Z"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M19.2036 8.66919V12.6792" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M21.2497 10.6741H17.1597" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <a href="{{ route('project-details', [$project->id]) }}"
                                                        class="btn btn-sm btn-icon btn-warning rounded" data-placement="top"
                                                        title="" data-bs-original-title="Edit" id="edit-project"
                                                        data-id="{{ $project->id }}">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M15.1655 4.60254L19.7315 9.16854"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-danger rounded" data-placement="top"
                                                        title="" data-bs-original-title="Delete" id="deleteRecord"
                                                        data-id="{{ $project->id }}"><i class="fa fa-trash">
                                                            <span class="btn-inner">
                                                                <svg width="20" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    stroke="currentColor">
                                                                    <path
                                                                        d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M20.708 6.23975H3.75" stroke="currentColor"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('store-stock') }}" onsubmit="$('.preloader').show()"
                            id="createStock">
                            @csrf
                            <div class="form-group">
                                <label class="form-label"> Stock Name:</label>
                                <input type="text" name="stock_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description:</label>
                                <input type="text" name="description" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Price:</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quantity:</label>
                                <input type="text" name="quantity" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Categories</label>
                                <input type="text" name="categories" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save <span
                                        class="spinner-border loader1 spinner-border-sm" role="status"
                                        aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </form>
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
                        swal("Stock will not be added  :)");
                    }
                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        swal("Opss", e.message, "error");
                        loader.hide();
                    }
                }
            })

            /* When click delete button */
            $('body').on('click', '#deleteRecord', function() {

                var user_id = $(this).data('id');

                var token = $("meta[name='csrf-token']").attr("content");
                var el = this;
                // alert(user_id);
                resetAccount(el, user_id);
            });

            async function resetAccount(el, user_id) {

                const willUpdate = await swal({
                    title: "Confirm Stock Delete",
                    text: `Are you sure you want to delete this record?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Delete"]
                });
                if (willUpdate) {
                    performDelete(el, user_id);
                } else {
                    swal("Stock will not be deleted  :)");
                }
            }

            function performDelete(el, user_id) {
                try {
                    $.get('{{ route('delete-stock') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = swal("Stock deleted successfully.");
                                $(el).closest("tr").remove();

                            }
                        }
                    );
                } catch (e) {
                    let alert = swal(e.message);
                }
            }

            /* When click delete button */
            $('body').on('click', '#approve_btn', function() {
                var id = $(this).data('id');
                console.log(id)
                var token = $("meta[name='csrf-token']").attr("content");
                var el = this;
                // alert(user_id);
                resetAccount(el, id);
            });

            async function resetAccount(el, id) {
                const willUpdate = await swal({
                    title: "Confirm Consultant Applicant Approval",
                    text: `Are you sure you want to validate this request?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Validate"]
                });
                if (willUpdate) {
                    //performReset()
                    performDelete(el, id);
                } else {
                    swal("Request not validated :)");
                }
            }

            function performDelete(el, id) {
                //alert(user_id);
                try {
                    $.get('{{ route('project_approve') }}?id=' + id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = swal("Request validated successfully!.");
                                window.location.reload();
                                $(el).closest("tr").remove();
                            }
                        }
                    );
                } catch (e) {
                    let alert = swal(e.message);
                }
            }
        })
    </script>
@endsection
