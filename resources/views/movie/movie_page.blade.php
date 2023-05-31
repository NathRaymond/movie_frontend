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
                            <h4 class="card-title">Movie List</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                + Add Movie
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive border rounded">
                            <table id="user-list-table" class="table table-striped" role="grid" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Title</th>
                                        <th>Release Date Number</th>
                                        <th>Director</th>
                                        <th>Genre</th>
                                        <th style="min-width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movies as $movie)
                                        <tr>
                                            <td>{{ $loop->iteration ?? '' }}</td>
                                            <td>{{ $movie->title ?? '' }}</td>
                                            <td>{{ $movie->release_date ?? '' }}</td>
                                            <td>{{ $movie->director ?? '' }}</td>
                                            <td>{{ $movie->genre ?? '' }}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <button class="btn btn-sm btn-icon btn-warning rounded"
                                                        data-bs-original-title="Edit" data-placement="top"
                                                        data-bs-toggle="modal" id="edit-movie" data-id="{{ $movie->id }}"
                                                        data-bs-target="#editModal" style="width: 60px">Edit</button>

                                                    <button class="btn btn-sm btn-danger remove-item-btn"
                                                        data-id="{{ $movie->id }}" id="deleteRecord" style="width: 60px">delete</button>

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
                    <h5 class="modal-title" id="exampleModalLabel1">Add movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ url('store-movie') }}" method="post" id="createUser" onsubmit="showloader5()">
                            @csrf
                            <div class="form-group">
                                <label class="form-label"> Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Release:</label>
                                <input type="date" name="release_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Director:</label>
                                <input type="text" name="director" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Genre:</label>
                                <input type="text" name="genre" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-primary">Save<span
                                        class="spinner-border loader spinner-border-sm" id="thisLoader5" role="status"
                                        aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit movies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('updatemovie') }}">
                            @csrf
                            <input type="text" id="movieId" name="id" style="display: none">

                            <div class="form-group">
                                <label class="form-label">Title:</label>
                                <input type="text" name="title" id="titleId" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Release_date:</label>
                                <input type="text" name="release_date" id="release_dateId" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Director:</label>
                                <input type="text" name="director" id="directorId" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Genre:</label>
                                <input type="text" name="genre" id="genreId" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update <span
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
    {{--  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  --}}
    <script>
        @if ($errors->any())
            Swal.fire('Oops...', "{!! implode('', $errors->all('<p>:message</p>')) !!}", 'error')
        @endif

        @if (session()->has('message'))
            Swal.fire(
                'Success!',
                "{{ session()->get('message') }}",
                'success'
            )
        @endif
        @if (session()->has('success'))
            Swal.fire(
                'Success!',
                "{{ session()->get('success') }}",
                'success'
            )
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-movie', function() {
                var id = $(this).data('id');
                $.get('{{ route('get_movie') }}?id=' + id, function(data) {
                    $('#titleId').val(data.title);
                    $('#release_dateId').val(data.release_date);
                    $('#directorId').val(data.director);
                    $('#genreId').val(data.genre);
                    $('#movieId').val(id);
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
                        $("#createUser").submit();
                    } else {
                        swal("Record will not be added  :)");
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
                    title: "Confirm Record Delete",
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
                    swal("Record will not be deleted  :)");
                }
            }

            function performDelete(el, user_id) {
                try {
                    $.get('{{ route('delete_movies') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = swal("Movie deleted successfully.");
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
