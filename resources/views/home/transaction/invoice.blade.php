@extends('layouts.main')

@section('title', 'Invoice')
@section('breadcrumb-item', 'Invoice')

@section('breadcrumb-item-active', 'Daftar Invoice')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="transaction_table" class="table table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Pembeli</th>
                            <th>Total Harga</th>
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
        let table = $('#transaction_table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('transaction.list') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    className: 'text-center',
                    orderable: false,
                },
                {
                    data: "buyer",
                    name: "buyer",
                },
                {
                    data: "total",
                    name: "total",
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
    </script>
@endsection
