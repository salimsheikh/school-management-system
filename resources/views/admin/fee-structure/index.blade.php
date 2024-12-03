@extends('admin.layout')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('Fee Structures') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Add Fee Structure') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-success">{{ Session::get('error') }}</div>
                        @endif                       

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">{{ __('Fee Structures') }}</h3>
                                    <a href="{{ route('fee-structure.create') }}"
                                        class="btn btn-primary float-right">{{ __('Add Fee Structure') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-body-filter mb-5">
                                    <form method="GET" action="{{ route('fee-structure.index') }}">                                       
                                        <div class="grid-three-column-filter">                                            
                                            <div class="grid-item">
                                                <label for="year">{{ __('Academic Year') }}</label>
                                                <select name="year" id="year" class="form-control">
                                                    <option value="" selected>{{ __('Select One') }}
                                                    </option>
                                                    @foreach ($academicYears as $option)
                                                        <option value="{{ $option->id }}" @selected($option->id == old('year', $academic_year_id))>
                                                            {{ $option->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid-item">
                                                <label for="class">{{ __('Class') }}</label>
                                                <select name="class" id="class" class="form-control">
                                                    <option value="" selected>{{ __('Select One') }}
                                                    </option>
                                                    @foreach ($classes as $option)
                                                        <option value="{{ $option->id }}" @selected($option->id == old('class', $class_id))>
                                                            {{ $option->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="filter-button">
                                                <button class="btn btn-success">{{ __('Search') }} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <table id="items-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>{{ __('ID') }}</th> --}}
                                            @foreach ($columns as $column_label)
                                                <th>{{ $column_label }}</th>
                                            @endforeach
                                            <th>{{ __('Edit') }}</th>
                                            <th>{{ __('Delete') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                {{-- <td>{{ $item->id }}</td> --}}
                                                <td>{{ $item->AcademicYear?->name }}</td>
                                                <td>{{ $item->Classes?->name }}</td>
                                                <td>{{ $item->FeeHead?->name }}</td>

                                                @foreach ($months as $column_name => $column_label)
                                                    <td>{{ $item->$column_name }}</td>
                                                @endforeach
                                                {{-- <td>{{ $item->created_at }}</td> --}}
                                                <td><a href="{{ route('fee-structure.edit', $item->id) }}"
                                                        class="btn btn-primary">{{ __('Edit') }}</a></td>
                                                <td>
                                                    <form action="{{ route('fee-structure.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Do you want to delete?')">{{ __('Delete') }}</button>
                                                    </form>
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

        </section>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('footer')
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function() {
            $("#items-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "stateSave": true,
                dom: 'Bfrtip', // Add export buttons
                buttons: [{
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':not(:nth-last-child(-n+2))' // Exclude last two columns
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':not(:nth-last-child(-n+2))' // Exclude last two columns
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':not(:nth-last-child(-n+2))' // Exclude last two columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':not(:nth-last-child(-n+2))' // Exclude last two columns
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':not(:nth-last-child(-n+2))' // Exclude last two columns
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Column Visibility'
                    }
                ],
                columnDefs: [{
                        targets: [0],
                        orderable: false
                    },
                    {
                        targets: [15],
                        orderable: false
                    },
                    {
                        targets: [16],
                        orderable: false
                    }
                ]
            }).buttons().container().appendTo('#items-table_wrapper .col-md-6:eq(0)');
        });
    </script>
    <style>
        .card-body-filter {
            width: 400px;
            margin: auto;
            text-align: center;
            transition: all 0.3s ease;
            /* Smooth transitions for layout changes */
        }

        .card-body-filter .grid-three-column-filter {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            /* Two flexible columns and one auto-sized column */
            gap: 20px;
            /* Space between columns */

        }

        .card-body-filter .grid-item {
            text-align: left;
        }

        .card-body-filter .filter-button {
            display: flex;
            justify-content: end;
            align-items: flex-end;
        }

        @media screen and (max-width: 500px) {
            .card-body-filter {
                width: auto;
            }

            .card-body-filter .grid-three-column-filter {
                grid-template-columns: 1fr;
            }

            .card-body-filter .filter-button {
                text-align: center;
                justify-content: center;
                align-items: center;
            }
        }
    </style>
@endsection
