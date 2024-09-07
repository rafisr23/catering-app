@extends('layouts.main')

@section('title', 'Menu')
@section('breadcrumb-item', 'Menu')

@section('breadcrumb-item-active', 'Daftar Menu')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Menu</h4>
                    <a type="button" href="{{ route('merchant.menu.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="card-body">
                    <table id="merchant_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table = $('#merchant_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('merchant.menu.list') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    className: 'text-center',
                    orderable: false,
                },
                {
                    data: "name",
                    name: "name",
                },
                {
                    data: "type",
                    name: "type",
                },
                {
                    data: "price",
                    name: "price",
                    className: 'text-start',
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                },
            ],
        });

        $('#merchant_table').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    let url = "{{ route('merchant.menu.delete') }}";
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        success: (response) => {
                            if (response.success) {
                                new window.Swal({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // table.ajax.reload();
                                        $('#merchant_table').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                new window.Swal({
                                    title: 'Failed!',
                                    text: response.message,
                                    icon: 'error',
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
