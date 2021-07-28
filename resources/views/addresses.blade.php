@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row">
        <div class="col-4">
            <h4>Addresses List</h4>
        </div>
    </div>
    <div class="table-responsive">
        <table id="addresses-table" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Zipcode</th>
                    <th>Street</th>
                    <th>Suite</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@endsection

