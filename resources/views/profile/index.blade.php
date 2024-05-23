@extends('layouts.app')

@section('content')
    <div class="bg-image" style="background-image: url('assets/media/photos/photo10@2x.jpg');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/avatar0.jpg') }}"
                        alt="">
                </div>
                <h1 class="h2 text-white mb-0">{{ auth()->user()->name }}</h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{-- {{ auth()->user()->roles->pluck('name')->implode(',') }} --}}
                </h2>
                <a class="btn btn-alt-secondary" href="/">
                    <i class="fa fa-fw fa-arrow-left text-danger"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <!-- User Profile -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">User Profile</h3>
            </div>
            <div class="block-content">
                <form action="#" method="POST" id="userForm" name="userForm">
                    @csrf
                    <input id="id" type="hidden" class="form-control" name="id"
                        value="{{ auth()->user()->id }}">
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Your account's vital info. Your username will be publicly visible.
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4 validate">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-4 validate">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            {{-- <div class="mb-4">
                                <label class="form-label">Your Avatar</label>
                                <div class="mb-4">
                                    <img class="img-avatar"
                                        src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/media/avatars/avatar13.jpg') }}"
                                        alt="">
                                </div>
                                <div class="mb-4">
                                    <label for="photo" class="form-label">Choose a new avatar</label>
                                    <input class="form-control" type="file" id="photo" name="photo">
                                </div>
                            </div> --}}
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" id="saveBtn" name="saveBtn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END User Profile -->

        <!-- Change Password -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Change Password</h3>
            </div>
            <div class="block-content">
                <form action="#" method="POST" id="passwordForm" name="passwordForm">
                    @csrf
                    <div class="row push">
                        <input id="id" type="hidden" class="form-control" name="id"
                            value="{{ auth()->user()->id }}">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Changing your sign in password is an easy way to keep your account secure.
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="row mb-4">
                                <div class="col-12 validate">
                                    <label class="form-label" for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 validate">
                                    <label class="form-label" for="password_confirm">Confirm New
                                        Password</label>
                                    <input type="password" class="form-control" id="password_confirm"
                                        name="password_confirm">
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" id="passwordBtn" name="passwordBtn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Change Password -->

    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let id = $('#id').val();
            show(id)

            function show(id) {
                let url = "{{ route('profile.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);

                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#userForm").valid();
                if (isValid) {
                    $('#saveBtn').text('Update...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#userForm')[0]);
                    $.ajax({
                        url: "{{ route('profile.update') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            ).then(function(result) {
                                $('#saveBtn').text('Save');
                                $('#saveBtn').attr('disabled', false);
                                location.reload();
                            });
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#passwordBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#passwordForm").valid();
                if (isValid) {
                    $('#passwordBtn').text('Update...');
                    $('#passwordBtn').attr('disabled', true);
                    var formData = new FormData($('#passwordForm')[0]);
                    $.ajax({
                        url: "{{ route('profile.changePassword') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            ).then(function(result) {
                                $('#passwordBtn').text('Update');
                                $('#passwordBtn').attr('disabled', false);
                                location.reload();
                            });
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#passwordBtn').text('Update');
                            $('#passwordBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    }
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#passwordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
