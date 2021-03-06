@extends('layouts/admin')
@section('styles')
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
@endsection
@section('content')
<style>
    #sub {
        border-radius: 4px;
        padding: 5px;
        border: none;
        font-size: 14px;
        background-color: #EAEFF3;
        color: black;
        position: inline;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
    .invisible {
        display: none;
    }
    .center {
        margin: auto;
        padding: 10px;
    }
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Controller</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0"></ol>
                        </nav>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="searchHos" method="get">
                        {{ csrf_field() }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Year&nbsp;
                        <select name="year" id="year">
                            <option value="2562">2562</option>
                            <option value="2561">2561</option>
                        </select>
                        <p></p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Region&nbsp;
                        <select name="region" id="region">
                            <option value="All">All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                        &nbsp;
                        Province&nbsp;
                        <select name="province" id="province">
                            <option value="All">All</option>
                            <?php
                            for($i=0 ; $i<count($Province_name) ; $i++){
                            ?>
                                <option value={{ $Province_name[$i] }}>
                                    {{ $Province_name[$i] }}
                                </option>

                            <?php
                            }
                            ?>
                        </select>
                        <p></p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Service Type&nbsp;
                        <select name="type" id="type">
                            <option value="All">All</option>
                            <option value="A">A</option>
                            <option value="S">S</option>
                            <option value="M1">M1</option>
                            <option value="M2">M2</option>
                            <option value="F1">F1</option>
                            <option value="F2">F2</option>
                            <option value="F3">F3</option>
                            <option value="Undefined">Undefined</option>
                        </select>
                        <p></p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="drugname">Name</label>
                        <input type="text" name="Hname" values="" id="Hname">
                        &nbsp;
                        <button type="submit" id="sub";>&nbsp;Search&nbsp;</button>
                        <br>
                        <br>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

<div class="container-fluid">
    <!-- Start Search Filter -->
    <?php
    $i=0;
    if(!empty($resultSearch)){
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php
                if($resultSearch != 'No value'){
                ?>
                    <div class="card-body" style="text-align:center;">
                        <div style="text-align:left;">
                            Result : {{ $resultState }}
                            <br/>
                            Found result : {{ count($resultSearch) }} values
                        </div>
                        <b style="text-align:center; font-size:22px; color:#243447;">List of Hospital</b>
                        <br/>
                        <br/>
                        <table class="table-striped table-bordered" id="tableSearch" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                            <thead>
                            <tr role="row">
                                <th style="text-align:center;">ID</th>
                                <th style="text-align:center;">NAME</th>
                                <th style="text-align:center;">Type</th>
                                <th style="text-align:center;">Province</th>
                                <th style="text-align:center;">Region</th>
                                <th style="text-align:center;">IP</th>
                                <th style="text-align:center;">OP</th>
                                <th style="text-align:center;">Total Spend</th>
                                <th style="text-align:center;">Dashboard</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                <?php
                }else{
                ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <th>No data</th>
                    <script>alert('No Data, Please select again');</script>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        var content_1 = {!! json_encode($table_resultSearch) !!};
        if(content_1 != null || content_1 != ''){
            $(document).ready( function () {
                $('#tableSearch tbody').html(content_1);
                $('#tableSearch').DataTable({
                    "sScrollX": "100%",
                    "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
                    "order": [[ 5, "desc" ]]
                });
            });
        }
    </script>
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: none;
            border: none;
            color: black!important;
            /*change the hover text color*/
        }
        /*below block of css for change style when active*/
        .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        background: none;
        border: none;
        color: black!important;
        }
    </style>
    
    <?php
    }
    ?>
    <!-- *************************************************************** -->
    <!-- End Search Filter -->
    <!-- *************************************************************** -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@stop
