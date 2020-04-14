@extends('layouts/admin')
@section('content')

<!-- set parameter -->
<?php
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
    <!-- *************************************************************** -->
    <!-- Top10 drug price dispersion  -->
    <!-- *************************************************************** -->
    
    <!-- *************************************************************** -->
    <!-- End Top10 drug price dispersion -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Drug Purchasing Amount -->
    <!-- *************************************************************** -->
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
    <!-- *************************************************************** -->
    <!-- End Drug Purchasing Amount -->
    <!-- *************************************************************** -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@stop
