@extends('layouts/admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#datatable').DataTable({
            "sScrollX": "100%",
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
            "rowCallback": function(row, data, index) {
                if(data[3]> 0.5){
                    $(row).find('td:eq(3)').css('color', '#E46074');
                }
            },
            "order": [[ 3, "desc" ]]
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
@endsection

@section('content')

<?php
    // Drug Purchasing Amount
    //TPU
    //2562
    $top5Amount = DB::select("select TOP 5 BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Total_Real_Amount as To_Total_Real_Amount, FORMAT(Total_Real_Amount, N'N2') as Total_Real_Amount, cast(Wavg_Unit_Price as decimal(10,2)) as Wavg_Unit_Price from TPU where BUDGET_YEAR = 2562 order by To_Total_Real_Amount DESC;");
    $totalAmount = DB::select("select FORMAT(sum(Total_Real_Amount), N'N2') as total FROM TPU WHERE BUDGET_YEAR=2562;");
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
    $a1 = $top5Amount[0]->To_Total_Real_Amount;
    $a2 = $top5Amount[1]->To_Total_Real_Amount;
    $a3 = $top5Amount[2]->To_Total_Real_Amount;
    $a4 = $top5Amount[3]->To_Total_Real_Amount;
    $a5 = $top5Amount[4]->To_Total_Real_Amount;
    $TA = $totalAmount[0]->total;
    // set parameter
    $a11 = $top5Amount[0]->Total_Real_Amount;
    $a22 = $top5Amount[1]->Total_Real_Amount;
    $a33 = $top5Amount[2]->Total_Real_Amount;
    $a44 = $top5Amount[3]->Total_Real_Amount;
    $a55 = $top5Amount[4]->Total_Real_Amount;
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
        background-color: #EAEFF3;
        color: grey;
        position: inline;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
    #TPU{
        border-radius: 4px;
        padding: 8px;
        border: none;
        font-size: 16px;
        background-color: #6179E1;
        color: white;
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
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Welcome!</h3>
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
                    <option selected>2562</option>
                    <!-- <option value="1">Feb 20</option> -->
                    <!-- <option value="2">Jan 20</option> -->
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
                        <input type=button id="TPU_to_GPU" onClick="location='/policy/GPU'" value='GPU'>
                        <input type=button id="TPU" value='TPU'>
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
                                        <th width="5%">TPU</th>
                                        <th width="65%">Name</th>
                                        <th width="15%">Method</th>
                                        <th width="15%">Gini coeff</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $query = DB::select('select TPU_ID, TPU_NAME, Method, cast(Gini as decimal(10,3)) as Gini from Gini_drugs_TPU
                                                                where BUDGET_YEAR = 2562
                                                                order by Gini DESC;');
                                        $GPU_count = DB::select('select count(distinct TPU_ID) as Gcount from Gini_drugs_TPU WHERE BUDGET_YEAR=2562;');
                                        for ($i = 0; $i < $GPU_count[0]->Gcount; $i+=1) {
                                            // echo "The number is: $i <br>";s
                                    ?>
                                            <tr>      
                                    <?php
                                            foreach($query[$i] as $x => $val) {
                                    ?>
                                                <td>{{ $val }}</td>
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
        <!-- Top10 drug unit price  -->
    
        <div class="col-lg-12 font-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 5 Unit Price</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-striped table-bordered" id="datatable2" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                        <th width="5%" >TPU</th>
                                        <th width="65%">Name</th> 
                                        <th width="15%">Method</th> 
                                        <th width="15%" >Avg Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $query = DB::select("select TPU_ID, TPU_NAME, REAL_METHOD_NAME, FORMAT(cast(sum(CAST(Real_Amount as float) * CAST(Real_Unit_Price as float))/sum(CAST(Real_Amount as float)) as decimal(18,4)), N'N3') as Wavg_Unit_Price from drugs where BUDGET_YEAR=2562 group by REAL_METHOD_NAME, TPU_ID, TPU_NAME 
                                                                order by Wavg_Unit_Price DESC;");
                                        $TPU_count = DB::select('select count(distinct TPU_NAME) as Tcount from TPU where BUDGET_YEAR = 2562;');
                                        for ($i = 0; $i < 131; $i+=1) {
                                                // echo "The number is: $i <br>";
                                        ?>
                                                <tr>      
                                        <?php
                                                foreach($query[$i] as $x => $val) {
                                        ?>
                                                    <td>{{ $val }}</td>
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
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align:center;">Total Annual Spending</h4>
                    <div id="curve_chart"></div>
                </div>
            </div>
        </div>        

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
                //   curveType: 'function',
                titleTextStyle: {
                    color: 'black',
                    fontName: 'Rubik', 
                    fontSize: 15
                },
                fontName:'Rubik',
                legend: { position: 'none' },
                width:430,
                height:300,
                colors: ['#5f76e8'],
                vAxis: {gridlines: { count: 5 }}
                };
                window.onload = resize;
                window.onresize = resize;
                function resize () {
                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                    chart.draw(data, options);
                };
            }
        </script>
    <!-- *************************************************************** -->
    <!-- End Google line chart -->
    <!-- *************************************************************** -->

    <!-- ============================================================== -->
    <!-- Drug Purchasing Amount -->
    
        <!-- Drug Purchasing Amount -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="text-align:center;">Drug Purchasing Quantity</h4>

                    <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                    <table>
                        <thead>
                            <tr role="row">
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;">TPU</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Avg Unit Price</th>
                                <th style="text-align:center;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="5%" class="ellipsis"><i class="fas fa-circle font-10 mr-2" style="color:#5f76e8;"></i></td>
                                <td width="10%">{{ $id1 }}</td>
                                <td width="50%" class="ellipsis">{{ $n1 }}</td>
                                <td width="15%" style="text-align:center;">{{ $w1 }}</td>
                                <td width="20%" style="text-align:right; padding-right:8px;">{{ $a11 }}</td>
                            </tr>
                            <tr>
                                <td width="5%" class="ellipsis"><i class="fas fa-circle font-10 mr-2" style="color:#01caf1;"></i></td>
                                <td width="10%">{{ $id2 }}</td>
                                <td width="50%" class="ellipsis">{{ $n2 }}</td>
                                <td width="15%" style="text-align:center;">{{ $w2 }}</td>
                                <td width="20%" style="text-align:right; padding-right:8px;">{{ $a22 }}</td>
                            </tr>
                            <tr>
                                <td width="5%" class="ellipsis"><i class="fas fa-circle font-10 mr-2" style="color:#60C687;"></i></td>
                                <td width="10%">{{ $id3 }}</td>
                                <td width="50%" class="ellipsis">{{ $n3 }}</td>
                                <td width="15%" style="text-align:center;">{{ $w3 }}</td>
                                <td width="20%" style="text-align:right; padding-right:8px;">{{ $a33 }}</td>
                            </tr>
                            <tr>
                                <td width="5%" class="ellipsis"><i class="fas fa-circle font-10 mr-2" style="color:#F5C378;"></i></td>
                                <td width="10%">{{ $id4 }}</td>
                                <td width="50%" class="ellipsis">{{ $n4 }}</td>
                                <td width="15%" style="text-align:center;">{{ $w4 }}</td>
                                <td width="20%" style="text-align:right; padding-right:8px;">{{ $a44 }}</td>
                            </tr>
                            <tr>
                                <td width="5%" class="ellipsis"><i class="fas fa-circle font-10 mr-2" style="color:#ff4f70;"></i></td>
                                <td width="10%">{{ $id5 }}</td>
                                <td width="50%" class="ellipsis">{{ $n5 }}</td>
                                <td width="15%" style="text-align:center;">{{ $w5 }}</td>
                                <td width="20%" style="text-align:right; padding-right:8px;">{{ $a55 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
        <!-- End Drug Purchasing Amount -->
    <!-- End Drug Purchasing Amount -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12" >
            <div class="card" style="background-color:#e5e6eb; height:10px;" >
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Cost Saving -->
    <div class="row">
        <div class="col-md-12" id="CostSave_Hos">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="color:black; text-align:center;">Cost Saving</h4>
                    <div class="card col-md-5 center" style="background-color:#8CDFAC;">
                        <span id="total_sc" style="text-align:center; color:black;">Total potential cost saving = {{ $totalPotentialSave_TPU }} THB</span>
                    </div>
                    <!-- Cost Saving table -->
                    <div class="center" style="width: 100%;">
                    <table class="table-striped table-bordered" id="datatable3" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">GPU</th>
                                    <th style="text-align:center;">GPU Name</th>
                                    <th style="text-align:center;">TPU</th>
                                    <th style="text-align:center;">TPU Name</th>
                                    <th style="text-align:center;">Method</th>
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