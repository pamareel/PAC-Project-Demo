@extends('layouts/admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
@endsection

@section('content')

<!-- set parameter -->
<?php
    //GPU
    //2561
    $top5Amount = DB::select('EXEC findTop5GPU61');
    $totalAmount = DB::select('select sum(Total_Real_Amount) as total FROM GPU WHERE BUDGET_YEAR=2561;');
    // set parameter
    $n1 = $top5Amount[0]->GPU_NAME;
    $n2 = $top5Amount[1]->GPU_NAME;
    $n3 = $top5Amount[2]->GPU_NAME;
    $n4 = $top5Amount[3]->GPU_NAME;
    $n5 = $top5Amount[4]->GPU_NAME;
    // set parameter
    $id1 = $top5Amount[0]->GPU_ID;
    $id2 = $top5Amount[1]->GPU_ID;
    $id3 = $top5Amount[2]->GPU_ID;
    $id4 = $top5Amount[3]->GPU_ID;
    $id5 = $top5Amount[4]->GPU_ID;
    // set parameter
    $w1 = $top5Amount[0]->Wavg_Unit_Price;
    $w2 = $top5Amount[1]->Wavg_Unit_Price;
    $w3 = $top5Amount[2]->Wavg_Unit_Price;
    $w4 = $top5Amount[3]->Wavg_Unit_Price;
    $w5 = $top5Amount[4]->Wavg_Unit_Price;
    // set parameter   
    $a1 = $top5Amount[0]->Total_Real_Amount;
    $a2 = $top5Amount[1]->Total_Real_Amount;
    $a3 = $top5Amount[2]->Total_Real_Amount;
    $a4 = $top5Amount[3]->Total_Real_Amount;
    $a5 = $top5Amount[4]->Total_Real_Amount;
    $TA = $totalAmount[0]->total;
?>

<!-- to send parameter to js file -->
<div id="GPU" value = "GPU" style="display:none;">hello</div>
<!-- Drug Purchasing Amount variable-->
    <div id="n1" value = {{ $n1 }} style="display:none;">hello</div>
    <div id="id1" value = {{ $id1 }} style="display:none;">hello</div>
    <div id="w1" value = {{ $w1 }} style="display:none;">hello</div>
    <div id="a1" value = {{ $a1 }} style="display:none;">hello</div>

    <div id="n2" value = {{ $n2 }} style="display:none;">hello</div>
    <div id="id2" value = {{ $id2 }} style="display:none;">hello</div>
    <div id="w2" value = {{ $w2 }} style="display:none;">hello</div>
    <div id="a2" value = {{ $a2 }} style="display:none;">hello</div>

    <div id="n3" value = {{ $n3 }} style="display:none;">hello</div>
    <div id="id3" value = {{ $id3 }} style="display:none;">hello</div>
    <div id="w3" value = {{ $w3 }} style="display:none;">hello</div>
    <div id="a3" value = {{ $a3 }} style="display:none;">hello</div>

    <div id="n4" value = {{ $n4 }} style="display:none;">hello</div>
    <div id="id4" value = {{ $id4 }} style="display:none;">hello</div>
    <div id="w4" value = {{ $w4 }} style="display:none;">hello</div>
    <div id="a4" value = {{ $a4 }} style="display:none;">hello</div>

    <div id="n5" value = {{ $n5 }} style="display:none;">hello</div>
    <div id="id5" value = {{ $id5 }} style="display:none;">hello</div>
    <div id="w5" value = {{ $w5 }} style="display:none;">hello</div>
    <div id="a5" value = {{ $a5 }} style="display:none;">hello</div>

    <div id="TA" value = {{ $TA }} style="display:none;">hello</div>
<!-- end send parameter -->
                 

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning cutie TY!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">
                <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
                    <option selected>Mar 20</option>
                    <option value="1">Feb 20</option>
                    <option value="2">Jan 20</option>
                </select>
                <br>
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
    <div class="row">
        <!-- ============================================================== -->
        <!-- Top10 drug price dispersion -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 10 drug price dispersion</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-cyan table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                                <th>BUDGET YEAR</th>
                                                <th>GPU ID</th>
                                                <th>GPU NAME</th>
                                                <th>Method</th>
                                                <th>Total Amount</th>
                                                <th>wavg unit price</th>
                                                <th>Total Spend</th>
                                                <th>Avg PAC</th>
                                                <th>Gini</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $query = DB::select('select * from Gini_drugs_GPU
                                                            order by Gini DESC;');
                                        $GPU_count = DB::select('select count(GPU_ID) as Gcount from Gini_drugs_GPU;');
                                        for ($i = 0; $i < $GPU_count[0]->Gcount; $i+=1) {
                                            // echo "The number is: $i <br>";
                                    ?>
                                            <tr>      
                                    <?php
                                            foreach($query[$i] as $x => $val) {
                                    ?>
                                                <td width="40%" class="ellipsis">{{ $val }}</td>
                                                <!-- echo "$x = $val<br>"; -->
                                    <?php
                                            };
                                    ?>
                                            </tr>
                                    <?php
                                        };
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- End Top10 drug price dispersion -->
        <!-- ============================================================== -->
    </div> 

    
    
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

@section('javascripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
@endsection