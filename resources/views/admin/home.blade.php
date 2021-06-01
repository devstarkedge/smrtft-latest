@extends('layouts.app')
@section('content')
<div class="page-inner">
    <div class="col-sm-6">
        <div class="page-title">
            <h4>Today Bookings</h4>  
        </div>
        <div class="table-responsive">
            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Sub Service Name</th>
                        <th>Service Name</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer Name</th>
                        <th>Sub Service Name</th>
                        <th>Service Name</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>  
        </div>
    </div>
</div>
@endsection