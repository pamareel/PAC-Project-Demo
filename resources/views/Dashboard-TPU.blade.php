@extends('layouts/admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Annual spending'],
          ['{{$y1 ?? ''}}',  {{$s1 ?? ''}}],
          ['{{$y2 ?? ''}}',  {{$s2 ?? ''}}],
          ['{{$y3 ?? ''}}',  {{$s3 ?? ''}}],
          ['{{$y4 ?? ''}}',  {{$s4 ?? ''}}],
          ['{{$y5 ?? ''}}',  {{$s5 ?? ''}}]
        ]);

        var options = {
          title: 'Total Annual Spending',
        //   curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#datatable').DataTable({
            "sScrollX": "100%",
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
            "rowCallback": function(row, data, index) {
                if(data[2]> 0.5){
                    $(row).find('td:eq(2)').css('color', 'red');
                }
            },
            "order": [[ 2, "desc" ]]
        });
    });
</script>
<script>
    $(document).ready( function () {
        $('#datatable2').DataTable({
            "sScrollX": "100%",
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
            "order": [[ 2, "desc" ]]
        });
    });
</script>
<script>
    $(document).ready( function () {
        TPU_table_cost_save = {!! json_encode($cs_table_TPU) !!};
        $('#datatable3 tbody').html(TPU_table_cost_save);
        $('#datatable3').DataTable({
            "sScrollX": "100%",
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
            "order": [[ 6, "desc" ]]
        });
    });
</script>
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

<style>
    #TPU_to_GPU{
        border-radius: 4px;
        padding: 8px;
        border: none;
        font-size: 16px;
        background-color: beige;
        color: grey;
        position: inline;
        top: 10px;
        right: 10px;
        cursor: pointer;
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
                <!-- <a class="customize-input float-right" href="/policy/GPU">
                    TPU -> GPU -->
                    <!-- ข้างล่างยังหาทางทำไม่ได้ ใช้อันบนไปก่อน-->
                    <!-- <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                        <label class="onoffswitch-label" for="myonoffswitch">                   
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </a> -->
                <div class="card-body float-right" style="padding-top:10px; padding-bottom:10px;">
                        <span id="change-level">Change level :</span>
                        <input type=button id="TPU_to_GPU" onClick="location='/policy/GPU'" value='TPU > GPU'>
                </div>
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
        <div class="col-lg-12 font-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 5 drug price dispersion</h4>
                    <h6 style="color:gray;">* Gini Coefficient higher than 0.5 indicates high inequality</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                                <th>Name</th>
                                                <th>GPU</th>
                                                <th>Gini coeff</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $query = DB::select('select TPU_NAME, TPU_ID, cast(Gini as decimal(10,3)) as Gini from Gini_drugs_TPU
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
    
        <div class="col-lg-12 font-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 5 Unit Price</h4>
                    <div class="row">
                    <div class="col-md-12">
                            <table class="table-striped table-bordered" id="datatable2" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                            <th>Name</th>
                                            <th>TPU</th>
                                            <th>Avg Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                    <?php
                                        $query = DB::select('select TPU_NAME, TPU_ID, cast(Wavg_Unit_Price as decimal(18,2)) as Wavg_Unit_Price from TPU
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
    </div>

    <!-- *************************************************************** -->
    <!-- Start Google line chart -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div id="curve_chart" style="width: 100%; height: 400px"></div>
            </div>
        </div>     
    </div>    
    <!-- *************************************************************** -->
    <!-- End Google line chart -->
    <!-- *************************************************************** -->

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

    <!-- ============================================================== -->
    <!-- Cost Saving -->
    <div class="row">
        <div class="col-md-12" id="CostSave_Hos">
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Cost Saving</h4>
                    <div class="card col-md-5 center" style="background-color:pink;">
                        <span id="total_sc" style="text-align:center;">Total potential cost saving = {{ $totalPotentialSave_TPU }} THB</span>
                    </div>
                    <!-- Cost Saving table -->
                    <div class="center" style="width: 100%;">
                    <table class="table-striped table-bordered" id="datatable3" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">GPU</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">TPU</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Real Total Spending</th>
                                    <th style="text-align:center;">Potential Saving Cost</th>
                                    <th style="text-align:center;">Saving (%)</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    <div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Cost Saving -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@endsection