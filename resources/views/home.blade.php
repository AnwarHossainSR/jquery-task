@extends('layouts.master')


@section('styles')
<link href="{{ URL::to('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<!-- Sweet Alart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sweet alert animate Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')
<div class="d-flex justify-content-center align-items-center mt-4">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Open Form
    </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">User Info</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" onsubmit="handleSubmit()">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="address" class="form-control" id="address" name="address" placeholder="Enter your address">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone No</label>
                        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Enter your phone">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- sweet Alart CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
<script>
    function handleSubmit() {
        event.preventDefault();

        var formData = $('#userForm').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        // Perform an AJAX request
        $.ajax({
            type: 'POST',
            url: '{{ route("save.user") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                ...formData
            },
            success: function(response) {
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: "User saved successfully",
                    timer: 1500
                })

                setTimeout(function() {
                    $('#exampleModal').modal('hide');
                    $('#userForm').trigger("reset");
                }, 1500);

            },
            error: function(xhr, status, error) {
                console.error('save failed:', error);
                var responseObj = JSON.parse(xhr.responseText);

                if (responseObj && typeof responseObj === 'object') {
                    $.each(responseObj.errors, function(key, value) {
                        $('#' + key).after('<div class="alert alert-danger mt-1">' + value + '</div>');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: responseObj.message,
                        timer: 1500
                    })
                }
            }
        });
    }
</script>
@endsection