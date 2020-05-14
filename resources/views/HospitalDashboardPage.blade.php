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
            <h3 class="card-title"  style="color:#090b17;">{{ $Hname }} ({{ $Year }})</h3>
        </div>
    </div>
    <div class="row col-lg-12">
        <div class="col-md-12 col-lg-5">
            <div class="card">
                <div class="card-body" style="font-size:15px;">
                    <p><b style="color:#1c2345;">Hospital Information</b></p>
                    <p><b>Type</b><span style="padding-left:10px;"> {{ $Htype }} </span></p>
                    <p><b>Province</b><span style="padding-left:10px;"> {{ $Hprovince }} </span></p>
                    <p><b>Region</b><span style="padding-left:10px;"> {{ $Hregion }} </span></p>
                    <p><b>IP</b><span style="padding-left:16px;"> {{ $Hip }} </span></p>
                    <p><b>OP</b><span style="padding-left:10px;"> {{ $Hop }} </span></p>
                    <p><b>Number of purchasing drug</b><span style="padding-left:10px;"> {{ $Htpu }} </span> (TPU unit)</p>
                </div>
            </div>
        </div>
    <!-- </div> -->
        <div>
        <!-- <div class="col-lg-6"> -->
            <div class="card">
                <div class="card-body" style="padding-top:10px; padding-bottom:10px;">
                        <span id="change-level">Please Choose level :</span>
                        <button class="btn invisible" id="GPU_to_TPU" style="background-color:#5c5cb8; color:white;">GPU > TPU</button>
                        <button class="btn invisible" id="TPU_to_GPU" style="background-color:#5cb85c; color:white;">TPU > GPU</button>
                        <button class="btn" id="GPU" style="background-color:#5cb85c; color:white;">GPU</button>
                        <button class="btn" id="TPU" style="background-color:#5c5cb8; color:white;">TPU</button>
                </div>
            </div>
        </div>
        &nbsp;&nbsp;&nbsp;
        <div>   
            <div class="card">
                <div class="card-body center" style="padding-top:10px; padding-bottom:10px;">
                    Change year? : 
                    <!-- <button class="btn" id="To_2561">To 2561</button> -->
                    <input class="invisible" type=button id="To_2561" style="background-color:#f0ad4e; color:white;" value='To 2561'>
                    <input class="invisible" type=button id="To_2562" style="background-color:#f0ad4e; color:white;" value='To 2562'>
                </div>
            </div>
        </div>
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
    <div class="row invisible" id="divide">
        <div class="col-md-12" >
            <div class="card" style="background-color:#e5e6eb; height:10px;" >
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
        <div class="col-md-7 invisible" id="Donut_hoss">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="color:black; text-align:center;">Drug Purchasing Quantity</h4>
                    <div class='row center'>
                        <!-- donut chart -->
                        <div id="hos_drug_donut" class="mt-2 center" style="height:210px; width:100%; display:inline-block;"></div>
                        <!-- table for donut -->
                        <div class="center" style="width: 100%;">
                        
                            <table id="Table_quan_donut" class="table-striped" style="width: 100%; font-size:13px" role="grid">
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
        <div class="row col-lg-5">
            <div class="col-lg-12 invisible" id="Overall_Drug_Perf_Total_spend_chart">
                <div class="card">
                    <div class="card-body" style="width: 100%;">
                        <h4 class="card-title" style="color:black; text-align:center;">Total Annual Spending</h4>
                        <div id="line_chart" style="width: 100%; font-size:15px"></div>
                    </div>
                </div>
            
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="color:black; text-align:center;">Overall Drug Performance</h4>
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
        </div> 
             
    </div>

    <div class="row">
        <div class="col-md-12" >
            <div class="card" style="background-color:#e5e6eb; height:10px;" >
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 invisible" id="CostSave_Hos">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="color:black; text-align:center;">Cost Saving</h4>
                    <div class="card col-md-5 center" style="background-color:#8CDFAC;">
                        <span id="total_sc" style="text-align:center; color:black; font-size:16px;"></span>
                    </div>
                    <!-- Cost Saving table -->
                    <div class="center" style="width: 100%;">
                            <table id="Cost_saving_table" class="table-striped" style="width: 100%;" role="grid">
                                <thead style="font-size:13px">
                                </thead>
                                <tbody style="font-size:13px">
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
    
    var Top5Donut_GPU = {!! json_encode($top5_GPU) !!};
    var Top5Donut_TPU = {!! json_encode($top5_TPU) !!};
    
    total = {!! json_encode($total_drug) !!};
    
    GPU_table_Donut = {!! json_encode($GPU_table_Donut) !!};
    TPU_table_Donut = {!! json_encode($TPU_table_Donut) !!};

    Donut_thead_GPU = '<tr role="row"><th style="text-align:center;"></th><th style="text-align:center;">GPU</th><th style="text-align:center; padding:5px;">Name</th>';
    Donut_thead_GPU += '<th style="text-align:center;">Unit Price</th><th style="text-align:center;">Quantity</th></tr>';

    Donut_thead_TPU = '<tr role="row"><th style="text-align:center;"></th><th style="text-align:center;">TPU</th><th style="text-align:center; padding:5px;">Name</th>';
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
                backgroundColor:'#D73737',
                borderWidth:1,
                borderColor:'#B5B5B5',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            },{
                label:'Above Average',
                data:[{{ $perfHighPercent_GPU }}],
                backgroundColor:'#45CA76',
                borderWidth:1,
                borderColor:'#B5B5B5',
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
                backgroundColor:'#D73737',
                borderWidth:1,
                borderColor:'#B5B5B5',
                hoverBorderWidth:3,
                hoverBorderColor:'#000'
            },{
                label:'Above Average',
                data:[{{ $perfHighPercent_TPU }}],
                backgroundColor:'#45CA76',
                borderWidth:1,
                borderColor:'#B5B5B5',
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
        Chart.defaults.global.defaultFontFamily = '"Rubik", sans-serif';
        google.charts.load('current', {'packages':['corechart']});
        if(content_1 != null && content_1 != ''){
            $("#GPU").click(function() {
                $(this).toggleClass("invisible");
                $("#Donut_hoss").removeClass("invisible");
                $("#GPU_to_TPU").removeClass("invisible");
                $("#TPU").addClass("invisible");
                $("#Overall_Drug_Perf_Total_spend_chart").removeClass("invisible");
                $("#CostSave_Hos").removeClass("invisible");
                $("#divide").removeClass("invisible");

                document.getElementById("change-level").innerHTML = "Change Level : ";
                //Donut chart
                $.chartX = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:Top5Donut_GPU,
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:20},
                    legend:{hide:!0},
                    color:{pattern:["#5f76e8","#01caf1","#60C687","#F5C378","#ff4f70","#edf2f6"]}
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
                    fontName:'Rubik',
                    legend: { position: 'bottom' },
                    colors: ['#5f76e8', '#ff4f70']
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
                $("#Overall_Drug_Perf_Total_spend_chart").removeClass("invisible");
                $("#CostSave_Hos").removeClass("invisible");
                $("#divide").removeClass("invisible");

                document.getElementById("change-level").innerHTML = "Change Level : ";
                //Donut chart
                $.chartXL = c3.generate({ 
                    bindto:"#hos_drug_donut",
                    data:{columns:Top5Donut_TPU,
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:20},
                    legend:{hide:!0},
                    color:{pattern:["#5f76e8","#01caf1","#60C687","#F5C378","#ff4f70","#edf2f6"]}
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
                    fontName:'Rubik',
                    legend: { position: 'bottom' },
                    colors: ['#5f76e8', '#ff4f70']
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
                    data:{columns:Top5Donut_TPU,
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:20},
                    legend:{hide:!0},
                    color:{pattern:["#5f76e8","#01caf1","#60C687","#F5C378","#ff4f70","#edf2f6"]}
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
                    fontName:'Rubik',
                    legend: { position: 'bottom' },
                    colors: ['#5f76e8', '#ff4f70']
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
                    data:{columns:Top5Donut_GPU,
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: "Total "+total,width:20},
                    legend:{hide:!0},
                    color:{pattern:["#5f76e8","#01caf1","#60C687","#F5C378","#ff4f70","#edf2f6"]}
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
                    fontName:'Rubik',
                    legend: { position: 'bottom' },
                    colors: ['#5f76e8', '#ff4f70']
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
                //table for cost saving
                $('#total_sc').text('Total potential cost saving = '+{!! json_encode($totalPotentialSave_GPU) !!}+' THB');
                $('#Cost_saving_table thead').html(Cost_save_thead_GPU);
                $('#Cost_saving_table tbody').html(GPU_table_cost_save);
            });

        }else{
            alert('No data');
        }
    });
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@stop
