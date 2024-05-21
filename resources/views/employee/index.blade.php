@extends('layouts.app')

@section('content')
    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModal" aria-hidden="true"
        data-bs-focus="false">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <form method="POST" action="#" id="employeeForm" name="employeeForm">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Form Karyawan</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            @csrf
                            <input id="id" name="id" type="hidden" class="form-control">
                            <div class="row">
                                <div class="col mb-3 validate">
                                    <label for="name" class="form-label">Nama Karyawan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-3 validate">
                                    <label for="birth_date" class="form-label">Tanggal Lahir<span
                                            style="color:red;">*</span></label>
                                    <input type="text" id="birth_date" name="birth_date" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-3 validate">
                                    <label for="address" class="form-label">Alamat <span
                                            class="text-danger">*</span></label>
                                    <textarea name="address" id="address" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-3 validate">
                                    <label for="marital_status" class="form-label">Status Pernikahan <span
                                            class="text-danger">*</span></label>
                                    <select name="marital_status" id="marital_status" class="form-select"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="1">Menikah</option>
                                        <option value="0">Belum Menikah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-3 validate image">
                                    <label for="photo" class="form-label">Foto <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <img id="previewImg" src="{{ asset('assets/media/avatars/avatar0.jpg') }}"
                                            class=" mb-3" style="max-width: 30%;">
                                    </div>
                                    <input type="file" class="form-control gambar" data-preview="#previewImg"
                                        id="photo" accept="image/*" name="photo">
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-primary" name="createBtn"
                                id="createBtn">Save</button>
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Karyawan
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item" aria-current="page">
                            Karyawan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <a href="javascript:void(0)" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#employeeModal" id="addNew" name="addNew"><i class="fas fa-plus"></i> Add
                    Data</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="employeeTable" name="employeeTable"
                    width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>Status Pernikahan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            const base_url = {!! json_encode(url('/')) !!};

            let request = {
                start: 0,
                length: 10
            };

            var employeeTable = $('#employeeTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-right"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>'
                    }
                },
                "aaSorting": [],
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('employee.getData') }}",
                    "type": "POST",
                    "headers": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
                    },
                    "Content-Type": "application/json",
                    "data": function(data) {
                        request.draw = data.draw;
                        request.start = data.start;
                        request.length = data.length;
                        request.searchkey = data.search.value || "";

                        return (request);
                    },
                },
                "columns": [{
                        "data": null,
                        "width": '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "name",
                        "width": '20%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "birth_date",
                        "width": '15%',
                        "defaultContent": "-",
                        "className": "text-center",
                        render: function(data, type, row) {
                            let details =
                                `${moment(data).locale('id').format('DD MMMM YYYY')} <br/> (${calculateAge(data)} Tahun)`
                            return "<div class='text-wrap'>" + details + "</div>";
                        },
                    },
                    {
                        "data": "address",
                        "width": '30%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "photo",
                        "width": '10%',
                        "defaultContent": "-",
                        "className": "text-center",
                        render: function(data, type, row) {
                            const path = `{{ asset('storage/images/employee') }}`
                            let photoImage =
                                `<img src="${path}/${data}"  alt="" class="img img-fluid" style="max-width: 150px; max-height: 50px;" />`
                            return "<div class='text-wrap'>" + photoImage + "</div>";
                        }
                    },
                    {
                        "data": "marital_status",
                        "width": '10%',
                        "defaultContent": "-",
                        "className": "text-center",
                        render: function(data, type, row) {
                            if (data == true) {
                                martialStatus = "Menikah"
                            } else {
                                martialStatus = "Belum Menikah"
                            }
                            return "<div class='text-wrap'>" + martialStatus + "</div>";
                        }
                    },
                    {
                        "data": "id",
                        "width": "10%",
                        render: function(data, type, row) {
                            let btnEdit = "";
                            let btnDelete = "";

                            btnEdit += '<button name="btnEdit" data-id="' + data +
                                '" type="button" class="btn btn-warning btn-sm btnEdit me-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash"></i></button>';
                            return btnEdit + btnDelete;
                        },
                    },
                ]
            });

            function reloadTable() {
                employeeTable.ajax.reload(null, false); //reload datatable ajax
            }

            $('#marital_status').select2({
                theme: "default",
                dropdownParent: $('#employeeModal'),
                placeholder: "Pilih Opsi",
            });

            $('#birth_date').flatpickr({
                dateFormat: "Y-m-d",
            });

            function calculateAge(data) {
                var today = new Date();
                var birthDate = new Date(data);
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            $(document).on('click', '#photo', function() {
                var target = $(this).data('target');
                if (typeof target === 'undefined' || target == '' || target == null)
                    target = '.gambar';
                $(this).closest('.image').find(target).click();
            })

            $(document).on('change', '.gambar', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    var preview = $(this).data('preview');

                    reader.onload = function(e) {
                        $(preview).attr('src', e.target.result);
                        $(preview).attr('width', '150px');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            })

            $('#createBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#employeeForm").valid();
                if (isValid) {
                    $('#createBtn').text('Save...');
                    $('#createBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('employee.store') }}";
                    } else {
                        var url = "{{ route('employee.update') }}";
                    }
                    var formData = new FormData($('#employeeForm')[0]);
                    $.ajax({
                        url: url,
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
                            )
                            $('#createBtn').text('Save');
                            $('#createBtn').attr('disabled', false);
                            reloadTable();
                            $('#employeeModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#createBtn').text('Save');
                            $('#createBtn').attr('disabled', false);
                        }
                    });
                }
            });

            $('#employeeTable').on("click", ".btnEdit", function() {
                isUpdate = true;
                $('#employeeModal').modal('show');
                $('label[for="photo"] .text-danger').hide();
                $("#photo").rules('remove', 'required');
                var id = $(this).attr('data-id');
                var url = "{{ route('employee.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#birth_date').val(response.data.birth_date);
                        $('#address').val(response.data.address);
                        $('#marital_status').val(response.data.marital_status).trigger(
                            'change');
                        if (response.data.photo != '' && response.data.photo != null)
                            $('#previewImg').attr('src', base_url +
                                '/storage/images/employee/' +
                                response.data.photo);
                        else
                            $('#previewImg').attr('src', base_url +
                                '/assets/media/avatars/avatar0.jpg');
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            });

            $('#employeeTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this data. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('employee.delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            url: url,
                            type: "POST",
                            success: function(data) {
                                Swal.fire(
                                    (data.status) ? 'Success' : 'Error',
                                    data.message,
                                    (data.status) ? 'success' : 'error'
                                )
                                reloadTable();
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error',
                                    'A system error has occurred. please try again later.',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

            $('#employeeForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    birth_date: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    marital_status: {
                        required: true,
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
            $('#addNew').on('click', function() {
                $('#name').val("");
                $('#birth_date').val("");
                $('#address').val("");
                $('#marital_status').val('').trigger('change');
                $('#photo').val("");
                $('#previewImg').attr('src', base_url + '/assets/media/avatars/avatar0.jpg');
                $('label[for="photo"] .text-danger').show();
                $("#photo").rules("add", {
                    required: true,
                });
                isUpdate = false;
            });
        })
    </script>
@endpush
