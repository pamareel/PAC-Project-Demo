@extends('layouts/admin')
@section('content')

<div class="container-fluid">
    <h1>Insert Record ID</h1>
    <br>
    <form action="{{ url('ebiddingAny') }}" method="POST">
        <!-- add csrf to avoid page expired -->
        {{ csrf_field() }}
        
        <input type="text" name="Record_id"><br>
        <input type="submit" value="GO"><br>
    </form>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@stop
