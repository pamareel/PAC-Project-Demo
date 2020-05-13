@extends('layouts/admin')
@section('styles')
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('script')
<!-- 100%-stack bar chart -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!--<script src="{{ asset('dist/js/chartStacked.js') }}"></script>-->
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<style>
    #To_2562, #To_2561, #GPU, #TPU, #GPU_to_TPU, #TPU_to_GPU {
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
    .invisible {
        display: none;
    }
    .center {
        margin: auto;
        padding: 10px;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $Hname }} ({{ $Year }})</h3>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Hospital Information</h5>
                    <p>Type<span> {{ $Htype }} </span></p>
                    <p>Province<span> {{ $Hprovince }} </span></p>
                    <p>Region<span> {{ $Hregion }} </span></p>
                    <p>IP<span> {{ $Hip }} </span></p>
                    <p>OP<span> {{ $Hop }} </span></p>
                    <p>Number of purchasing drug (TPU unit)<span> {{ $Htpu }} </span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- for to_2561 button -->

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <div class="row">
        <!-- <div class="col-md-6"> -->
            <div class="card">
                <div class="card-body" style="padding-top:10px; padding-bottom:10px;">
                        <span id="change-level">Please Choose level :</span>
                        <button class="btn invisible" id="GPU_to_TPU">GPU > TPU</button>
                        <button class="btn invisible" id="TPU_to_GPU">TPU > GPU</button>
                        <button class="btn" id="GPU">GPU</button>
                        <button class="btn" id="TPU">TPU</button>
                </div>
            </div>
        <!-- </div> -->
        <!-- <div class="col-md-5">    -->
            &nbsp;&nbsp;&nbsp;
            <div class="card">
                <div class="card-body center" style="padding-top:10px; padding-bottom:10px;">
                    Change year? : 
                    <!-- <button class="btn" id="To_2561">To 2561</button> -->
                    <input class="invisible" type=button id="To_2561" value='To 2561'>
                    <input class="invisible" type=button id="To_2562" value='To 2562'>
                </div>
            </div>
        <!-- </div> -->
    </div>
    <script>
        var btn = document.getElementById('To_2561');
        var link_to_2561 = '/hospitalDashboard/2561/' + {{ $HID }};
        btn.addEventListener('click', function() {
            document.location.href = link_to_2561;
        });
        var btn2 = document.getElementById('To_2562');
        var link_to_2562 = '/hospitalDashboard/2562/' + {{ $HID }};
        btn2.addEventListener('click', function() {
            document.location.href = link_to_2562;
        });
        if({{ $Year }} == 2561){
            $("#To_2562").toggleClass("invisible");
        }
        if({{ $Year }} == 2562){
            $("#To_2561").toggleClass("invisible");
        }
    </script>

    <div class="row">
        <div class="col-md-6 invisible" id="Donut_hoss">
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Drug Purchasing Quantity</h4>
                    <div class='row center'>
                        <!-- donut chart -->
                        <div id="hos_drug_donut" class="mt-2 center" style="height:283px; width:100%; display:inline-block;"></div>
                        <!-- table for donut -->
                        <div class="center" style="width: 100%;">
                            <table id="Table_quan_donut" style="width: 100%;" role="grid">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 invisible" id="Overall_Drug_Perf">
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Overall Drug Performance</h4>
                    <?php
                    if(isset($perfHighPercent) || isset($perfLowPercent)){
                    ?>
                        <canvas id="perfChart" style="margin: auto;"></canvas>
                    <?php
                    }else{
                    ?>
                        <canvas id="perfChart">No Data</canvas>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>  
        <div class="col-lg-6 invisible" id="Total_spend_chart">
            <div class="card">
                <div id="line_chart" style="width: 500px; height: 400px"></div>
            </div>
        </div>        
    </div>
    
    <div class="row">
        <div class="col-md-12 invisible" id="CostSave_Hos">
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Cost Saving</h4>
                    <div class="card col-md-5 center" style="background-color:pink;">
                        <span id="total_sc" style="text-align:center;"></span>
                    </div>
                    <!-- Cost Saving table -->
                    <div class="center" style="width: 100%;">
                            <table id="Cost_saving_table" style="width: 100%;" role="grid">
                                <thead>
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
</div>

<script>
   
    content_1 = {!! json_encode($donut_hos_drug_GPU) !!};

    top5_GPU_name_1 = {!! json_encode($top5_GPU_name[0]) !!};
    top5_GPU_name_2 = {!! json_encode($top5_GPU_name[1]) !!};
    top5_GPU_name_3 = {!! json_encode($top5_GPU_name[2]) !!};
    top5_GPU_name_4 = {!! json_encode($top5_GPU_name[3]) !!};
    top5_GPU_name_5 = {!! json_encode($top5_GPU_name[4]) !!};

    top5_GPU_amount_1 = {{ $top5_GPU_amount[0] }};
    top5_GPU_amount_2 = {{ $top5_GPU_amount[1] }};
    top5_GPU_amount_3 = {{ $top5_GPU_amount[2] }};
    top5_GPU_amount_4 = {{ $top5_GPU_amount[3] }};
    top5_GPU_amount_5 = {{ $top5_GPU_amount[4] }};
    top5_GPU_amount_other = {{ $top5_GPU_amount[5] }};
    total = {!! json_encode($total_drug) !!};

    top5_TPU_name_1 = {!! json_encode($top5_TPU_name[0]) !!};
    top5_TPU_name_2 = {!! json_encode($top5_TPU_name[1]) !!};
    top5_TPU_name_3 = {!! json_encode($top5_TPU_name[2]) !!};
    top5_TPU_name_4 = {!! json_encode($top5_TPU_name[3]) !!};
    top5_TPU_name_5 = {!! json_encode($top5_TPU_name[4]) !!};

    top5_TPU_amount_1 = {{ $top5_TPU_amount[0] }};
    top5_TPU_amount_2 = {{ $top5_TPU_amount[1] }};
    top5_TPU_amount_3 = {{ $top5_TPU_amount[2] }};
    top5_TPU_amount_4 = {{ $top5_TPU_amount[3] }};
    top5_TPU_amount_5 = {{ $top5_TPU_amount[4] }};
    top5_TPU_amount_other = {{ $top5_TPU_amount[5] }};

    GPU_table_Donut = {!! json_encode($GPU_table_Donut) !!};
    TPU_table_Donut = {!! json_encode($TPU_table_Donut) !!};

    Donut_thead_GPU = '<tr role="row"><th style="text-align:center;">GPU</th><th style="text-align:center; padding:5px;">Name</th>';
    Donut_thead_GPU += '<th style="text-align:center;">Unit Price</th><th style="text-align:center;">Quantity</th></tr>';

    Donut_thead_TPU = '<tr role="row"><th style="text-align:center;">TPU</th><th style="text-align:center; padding:5px;">Name</th>';
    Donut_thead_TPU += '<th style="text-align:center;">Unit Price</th><th style="text-align:center;">Quantity</th></tr>';

    HosName = {!! json_encode($Hname) !!};

    Cost_save_thead_GPU = '<tr role="row"><th style="text-align:center;">GPU</th><th style="text-align:center; padding:5px;">Name</th>';
    Cost_save_thead_GPU += '<th style="text-align:center;">Number of TPU</th><th style="text-align:center;">Real Total Spending</th>'
    Cost_save_thead_GPU += '<th style="text-align:center;">Potential Saving Cost</th><th style="text-align:center;">Saving (%)</th></tr>';

    Cost_save_thead_TPU = '<tr role="row"><th style="text-align:center;">GPU</th><th style="text-align:center; padding:5px;">GPU Name</th>';
    Cost_save_thead_TPU += '<th style="text-align:center;">TPU</th><th style="text-align:center; padding:5px;">TPU Name</th>';
    Cost_save_thead_TPU += '<th style="text-align:center;">Real Total Spending</th>'
    Cost_save_thead_TPU += '<th style="text-align:center;">Potential Saving Cost</th><th style="text-align:center;">Saving (%)</th></tr>';

    GPU_table_cost_save = {!! json_encode($GPU_Cost_saving_table_hos) !!};
    TPU_table_cost_save = {!! json_encode($TPU_Cost_saving_table_hos) !!};

    //for performance chart
    //PerformanceChart
    var optionGPU = {
        name: HosName,
        type:'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
            labels:[''],
            datasets:[
            {
                label:'Below Average',
                data: [{{ $perfLowPercent_GPU }}],
                backgroundColor:'red',
                borderWidth:1,
                borderColor:'#777',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            },{
                label:'Above Average',
                data:[{{ $perfHighPercent_GPU }}],
                backgroundColor:'green',
                borderWidth:1,
                borderColor:'#777',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            }],
        },
        options:{
            scales: {
                xAxes: [{ stacked: true,
                            ticks: {
                            beginAtZero: true,
                            max: 100
                            },
                            scaleLabel: {
                                display: true,
                                labelString: '%'
                            }
                        }],
                yAxes: [{ stacked: true, 
                            ticks: {
                            beginAtZero: true,
                            max: 100
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Performance'
                            }
                        }]
            },
            legend:{
                display:true,
                position:'bottom',
                labels:{
                    fontColor:'#000',
                } 
            },
            layout:{
                padding:{
                    left:0,
                    right:0,
                    bottom:0,
                    top:0
                }
            },
            tooltips:{
                enabled:true
            },
        }
    };
    var optionTPU = {
        name: HosName,
        type:'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
            labels:[''],
            datasets:[
            {
                label:'Below Average',
                data: [{{ $perfLowPercent_TPU }}],
                backgroundColor:'red',
                borderWidth:1,
                borderColor:'#777',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            },{
                label:'Above Average',
                data:[{{ $perfHighPercent_TPU }}],
                backgroundColor:'green',
                borderWidth:1,
                borderColor:'#777',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            }],
        },
        options:{
            scales: {
                xAxes: [{ stacked: true,
                            ticks: {
                            beginAtZero: true,
                            max: 100
                            },
                            scaleLabel: {
                                display: true,
                                labelString: '%'
                            }
                        }],
                yAxes: [{ stacked: true, 
                            ticks: {
                            beginAtZero: true,
                            max: 100
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Performance'
                            }
                        }]
            },
            legend:{
                display:true,
                position:'bottom',
                labels:{
                    fontColor:'#000',
                } 
            },
            layout:{
                padding:{
                    left:0,
                    right:0,
                    bottom:0,
                    top:0
                }
            },
            tooltips:{
                enabled:true
            },
        }
    };

    $(document).ready(function() {
        google.charts.load('current', {'packages':['corechart']});
        if(top5_GPU_name_1 != null && top5_GPU_name_1 != ''){
            $("#GPU").click(function() {
                $(this).toggleClass("invisible");
                $("#Donut_hoss").removeClass("invisible");
                $("#GPU_to_TPU").removeClass("invisible");
                $("#TPU").addClass("invisible");
                $("#Overall_Drug_Perf").removeClass("invisible");
                $("#Total_spend_chart").removeClass("invisible");
                $("#CostSave_Hos").removeClass("invisible");

                document.getElementById("change-level").innerHTML = "Change Level : ";
                //Donut chart
                $.chartX = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:[[top5_GPU_name_1, top5_GPU_amount_1], [top5_GPU_name_2, top5_GPU_amount_2],
                                    [top5_GPU_name_3, top5_GPU_amount_3], [top5_GPU_name_4, top5_GPU_amount_4],
                                    [top5_GPU_name_5, top5_GPU_amount_5], ['Others', top5_GPU_amount_other]],
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:40},
                    legend:{hide:!0},
                    color:{pattern:["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]}
                });
                //table for Donut
                $('#Table_quan_donut thead').html(Donut_thead_GPU);
                $('#Table_quan_donut tbody').html(GPU_table_Donut);
                //perf stack chart
                var myChart_pc = $("#perfChart").get(0).getContext("2d");
                $.myChart_pc2 = new Chart(myChart_pc, optionGPU);
                //Total spend
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Year', 'Annual spending'],
                    ['2560',  {!! json_encode($totalSpend_60) !!}],
                    ['2561',  {!! json_encode($totalSpend_61) !!}],
                    ['2562',  {!! json_encode($totalSpend_62) !!}]
                    ]);
                    var options = {
                    title: 'Total Annual Spending',
                    //   curveType: 'function',
                    legend: { position: 'bottom' }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
                //table for cost saving
                $('#total_sc').text('Total potential cost saving = '+{!! json_encode($totalPotentialSave_GPU) !!}+' THB');
                $('#Cost_saving_table thead').html(Cost_save_thead_GPU);
                $('#Cost_saving_table tbody').html(GPU_table_cost_save);
            });

            $("#TPU").click(function() {
                $(this).toggleClass("invisible");
                $("#Donut_hoss").removeClass("invisible");
                $("#TPU_to_GPU").removeClass("invisible");
                $("#GPU").addClass("invisible");
                $("#Overall_Drug_Perf").removeClass("invisible");
                $("#Total_spend_chart").removeClass("invisible");
                $("#CostSave_Hos").removeClass("invisible");

                document.getElementById("change-level").innerHTML = "Change Level : ";
                //Donut chart
                $.chartXL = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:[[top5_TPU_name_1, top5_TPU_amount_1], [top5_TPU_name_2, top5_TPU_amount_2],
                                    [top5_TPU_name_3, top5_TPU_amount_3], [top5_TPU_name_4, top5_TPU_amount_4],
                                    [top5_TPU_name_5, top5_TPU_amount_5], ['Others', top5_TPU_amount_other]],
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:40},
                    legend:{hide:!0},
                    color:{pattern:["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]}
                });
                //table for Donut
                $('#Table_quan_donut thead').html(Donut_thead_TPU);
                $('#Table_quan_donut tbody').html(TPU_table_Donut);
                //perf stack chart
                var myChart_pc = $("#perfChart").get(0).getContext("2d");
                $.myChart_pc2 = new Chart(myChart_pc, optionTPU);
                //Total spend
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Year', 'Annual spending'],
                    ['2560',  {!! json_encode($totalSpend_60) !!}],
                    ['2561',  {!! json_encode($totalSpend_61) !!}],
                    ['2562',  {!! json_encode($totalSpend_62) !!}]
                    ]);
                    var options = {
                    title: 'Total Annual Spending',
                    //   curveType: 'function',
                    legend: { position: 'bottom' }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
                //table for cost saving
                $('#total_sc').text('Total potential cost saving = '+{!! json_encode($totalPotentialSave_TPU) !!}+' THB');
                $('#Cost_saving_table thead').html(Cost_save_thead_TPU);
                $('#Cost_saving_table tbody').html(TPU_table_cost_save);
            });

            $("#GPU_to_TPU").click(function() { 
                $(this).toggleClass("invisible");
                $("#TPU_to_GPU").toggleClass("invisible");
                //Donut chart
                $.chartX.destroy();
                $.chartXL = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:[[top5_TPU_name_1, top5_TPU_amount_1], [top5_TPU_name_2, top5_TPU_amount_2],
                                    [top5_TPU_name_3, top5_TPU_amount_3], [top5_TPU_name_4, top5_TPU_amount_4],
                                    [top5_TPU_name_5, top5_TPU_amount_5], ['Others', top5_TPU_amount_other]],
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:40},
                    legend:{hide:!0},
                    color:{pattern:["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]}
                });
                //table for Donut
                $('#Table_quan_donut thead').html(Donut_thead_TPU);
                $('#Table_quan_donut tbody').html(TPU_table_Donut);
                //perf stack chart
                $.myChart_pc2.destroy();
                var myChart_pc = $("#perfChart").get(0).getContext("2d");
                $.myChart_pc2 = new Chart(myChart_pc, optionTPU);
                //Total spend
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Year', 'Annual spending'],
                    ['2560',  {!! json_encode($totalSpend_60) !!}],
                    ['2561',  {!! json_encode($totalSpend_61) !!}],
                    ['2562',  {!! json_encode($totalSpend_62) !!}]
                    ]);
                    var options = {
                    title: 'Total Annual Spending',
                    //   curveType: 'function',
                    legend: { position: 'bottom' }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
                //table for cost saving
                $('#total_sc').text('Total potential cost saving = '+{!! json_encode($totalPotentialSave_TPU) !!}+' THB');
                $('#Cost_saving_table thead').html(Cost_save_thead_TPU);
                $('#Cost_saving_table tbody').html(TPU_table_cost_save);
            });
            $("#TPU_to_GPU").click(function() { 
                $(this).toggleClass("invisible");
                $("#GPU_to_TPU").toggleClass("invisible");
                //Donut chart
                $.chartXL.destroy();
                
                $.chartX = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:[[top5_GPU_name_1, top5_GPU_amount_1], [top5_GPU_name_2, top5_GPU_amount_2],
                                    [top5_GPU_name_3, top5_GPU_amount_3], [top5_GPU_name_4, top5_GPU_amount_4],
                                    [top5_GPU_name_5, top5_GPU_amount_5], ['Others', top5_GPU_amount_other]],
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total ",width:40},
                    legend:{hide:!0},
                    color:{pattern:["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]}
                });
                //table for Donut
                $('#Table_quan_donut thead').html(Donut_thead_GPU);
                $('#Table_quan_donut tbody').html(GPU_table_Donut);
                //perf stack chart
                $.myChart_pc2.destroy();
                var myChart_pc = $("#perfChart").get(0).getContext("2d");
                $.myChart_pc2 = new Chart(myChart_pc, optionGPU);
                //Total spend
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Year', 'Annual spending'],
                    ['2560',  {!! json_encode($totalSpend_60) !!}],
                    ['2561',  {!! json_encode($totalSpend_61) !!}],
                    ['2562',  {!! json_encode($totalSpend_62) !!}]
                    ]);
                    var options = {
                    title: 'Total Annual Spending',
                    //   curveType: 'function',
                    legend: { position: 'bottom' }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
                //table for cost saving
                $('#total_sc').text('Total potential cost saving = '+{!! json_encode($totalPotentialSave_GPU) !!}+' THB');
                $('#Cost_saving_table thead').html(Cost_save_thead_GPU);
                $('#Cost_saving_table tbody').html(GPU_table_cost_save);
            });

        }else if(top5_GPU_name_1 == '' || top5_GPU_name_1 == NULL){
            alert('No data');
        }
    });
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@stop
