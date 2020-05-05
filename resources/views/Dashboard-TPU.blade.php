@extends('layouts/admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
@endsection

@section('content')

<?php
    // // Total Annual Spending Not used
    // $total = DB::select('EXEC findTotalSpend5years');
    // // set parameter
    // $t1 = $total[0]->total;
    // $y1 = $total[0]->BUDGET_YEAR;
    // $t2 = $total[1]->total;
    // $y2 = $total[1]->BUDGET_YEAR;
    // $t3 = $total[2]->total;
    // $y3 = $total[2]->BUDGET_YEAR;
    // $t4 = $total[3]->total;
    // $y4 = $total[3]->BUDGET_YEAR;
    // $t5 = $total[4]->total;
    // $y5 = $total[4]->BUDGET_YEAR;

    // Drug Purchasing Amount
    //TPU
    //2561
    $top5Amount = DB::select('EXEC findTop5TPU61');
    $totalAmount = DB::select('select sum(Total_Real_Amount) as total FROM TPU WHERE BUDGET_YEAR=2561;');
    // set parameter
    $n1 = $top5Amount[0]->TPU_NAME;
    $n2 = $top5Amount[1]->TPU_NAME;
    $n3 = $top5Amount[2]->TPU_NAME;
    $n4 = $top5Amount[3]->TPU_NAME;
    $n5 = $top5Amount[4]->TPU_NAME;
    // set parameter
    $id1 = $top5Amount[0]->TPU_ID;
    $id2 = $top5Amount[1]->TPU_ID;
    $id3 = $top5Amount[2]->TPU_ID;
    $id4 = $top5Amount[3]->TPU_ID;
    $id5 = $top5Amount[4]->TPU_ID;
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
<div id="TPU" value = "TPU" style="display:none;">hello</div>
<!-- Drug Purchasing Amount -->
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

<!-- Not used-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- End Not used -->


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
                <!-- switch -->
                <a class="customize-input float-right" href="/policy/GPU">
                    TPU -> GPU
                    <!-- ข้างล่างยังหาทางทำไม่ได้ ใช้อันบนไปก่อน-->
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                        <label class="onoffswitch-label" for="myonoffswitch">                   
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </a>
                <!-- end switch -->
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="container-fluid">
    <div class="row">
        <!-- ============================================================== -->
        <!-- Top10 drug price dispersion  -->
        <!-- ============================================================== -->
        <div class="col-lg-8 font-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 10 drug price dispersion</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-cyan table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                                <th>Name</th>
                                                <th>GPU</th>
                                                <th>Price dis</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $query = DB::select('select TPU_NAME, TPU_ID, Gini from Gini_drugs_TPU
                                                                where BUDGET_YEAR = 2561
                                                                order by Gini DESC;');
                                        $GPU_count = DB::select('select count(distinct TPU_ID) as Gcount from Gini_drugs_TPU WHERE BUDGET_YEAR=2561;');
                                        for ($i = 0; $i < $GPU_count[0]->Gcount; $i+=1) {
                                            // echo "The number is: $i <br>";s
                                    ?>
                                            <tr>      
                                    <?php
                                            foreach($query[$i] as $x => $val) {
                                    ?>
                                                <td width="40%">{{ $val }}</td>
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

        <!-- ============================================================== -->
        <!-- Top10 drug price dispersion  -->
    
        <div class="col-lg-4 font-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 10 Unit Price</h4>
                    <div class="row">
                    <div class="col-md-12">
                            <table class="table table-striped table-bordered" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                            <th>Name</th>
                                            <th>TPU</th>
                                            <th>Avg Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    <?php
                                        $query = DB::select('select TPU_NAME, TPU_ID, Wavg_Unit_Price from TPU
                                                                where BUDGET_YEAR = 2561
                                                                order by Wavg_Unit_Price DESC;');
                                        $TPU_count = DB::select('select count(distinct TPU_NAME) as Tcount from TPU where BUDGET_YEAR = 2561;');
                                        for ($i = 0; $i < 131; $i+=1) {
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
        
        <!-- ============================================================== -->
        <!-- Total Annual Spending -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Annual Spending</h4>
                    <ul class="list-inline text-right">
                        <li class="list-inline-item">
                            <h5><i class="fa fa-circle mr-1 text-info"></i>Annaul Spending</h5>
                        </li>
                    </ul>
                    <div class="card-body py-3 px-3">
                        <?php
                        if(isset($annualSpendingChart)){
                        ?>
                            {!! $annualSpendingChart->container() !!}
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Total Annual Spending -->
        <!-- ============================================================== -->
    </div>

    <!-- ============================================================== -->
    <!-- Drug Purchasing Amount -->
    <div class="row">
        <!-- Drug Purchasing Amount -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Drug Purchasing Amount</h4>

                    <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;">
                    </div>
                    <ul class="list-style-none mb-0">
                        <li>
                            <span class="text-dark font-weight-medium" >Name</span>
                            <span class="text-dark font-weight-medium" >TPU</span>
                            <span class="text-dark font-weight-medium" >Avg Unit Price</span>
                            <span class="text-dark float-right font-weight-medium">Amount</span>
                        </li>
                        <li>
                            <i class="fas fa-circle text-primary font-10 mr-2"></i>
                            <span class="text-muted" >{{ $n1 }}</span>
                            <span class="text-dark font-weight-medium">{{ $id1 }}</span>
                            <span class="text-dark font-weight-medium">{{ $w1 }}</span>
                            <span class="text-dark float-right font-weight-medium">{{ $a1 }}</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle text-danger font-10 mr-2"></i>
                            <span class="text-muted">{{ $n2 }}</span>
                            <span class="text-darkfont-weight-medium">{{ $id2 }}</span>
                            <span class="text-dark font-weight-medium">{{ $w2 }}</span>
                            <span class="text-dark float-right font-weight-medium">{{ $a2 }}</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                            <span class="text-muted">{{ $n3 }}</span>
                            <span class="text-dark font-weight-medium">{{ $id3 }}</span>
                            <span class="text-dark font-weight-medium">{{ $w3 }}</span>
                            <span class="text-dark float-right font-weight-medium">{{ $a3 }}</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle text-danger font-10 mr-2"></i>
                            <span class="text-muted">{{ $n4 }}</span>
                            <span class="text-dark font-weight-medium">{{ $id4 }}</span>
                            <span class="text-dark font-weight-medium">{{ $w4 }}</span>
                            <span class="text-dark float-right font-weight-medium">{{ $a4 }}</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                            <span class="text-muted">{{ $n5 }}</span>
                            <span class="text-dark font-weight-medium">{{ $id5 }}</span>
                            <span class="text-dark font-weight-medium">{{ $w5 }}</span>
                            <span class="text-dark float-right font-weight-medium">{{ $a5 }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Drug Purchasing Amount -->
    </div>
    <!-- End Drug Purchasing Amount -->
    <!-- ============================================================== -->
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
                "sScrollX": "100%",
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
            });
        });
    </script>
@endsection

