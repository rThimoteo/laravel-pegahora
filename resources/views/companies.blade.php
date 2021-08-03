@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row">
        <div class="col-4">
            <h4>Companies List</h4>
        </div>
    </div>
    <div class="table-responsive">
        <table id="companies-table" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>BS</th>
                    <th>Catch Phrase</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@endsection


@section ('js')

<script src="/js/company.js"></script>

@endsection
