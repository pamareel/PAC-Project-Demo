@extends('layouts/admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('script')
<!-- 100%-stack bar chart -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!--<script src="{{ asset('dist/js/chartStacked.js') }}"></script>-->


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
                    <form action="search" method="get">
                        {{ csrf_field() }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Year&nbsp;
                        <select name="year" id="year">
                            <option value="2562">2562</option>
                            <option value="2561">2561</option>
                            <option value="2560">2560</option>
                        </select>
                        &nbsp;
                        Method&nbsp;
                        <select name="method" id="method">
                            <option value="All">All</option>
                            <option value="ebidding">ebidding</option>
                            <option value="specific">specific</option>
                        </select>
                        &nbsp;
                        Drug&nbsp;
                        <select name="GT" id="GT">
                            <option value="GPU">GPU</option>
                            <option value="TPU">TPU</option>
                        </select>

                        &nbsp;&nbsp;
                        <label for="drugname">Name</label>
                        <input type="text" name="Dname" values="" id="Dname">
                        &nbsp;
                        <button type="submit" id="sub">&nbsp;Search&nbsp;</button>
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

<!-- *************************************************************** -->
<!-- Start Search Filter-->
<!-- *************************************************************** -->

<div class="container-fluid">
    <!-- Start Search Filter -->
    <?php
    $i=0;
    if(!empty($resultSearch))
    {
    ?>
    <div class="row">
        <div class="col-md-12">
        <div class="card">
        <?php
        if($resultSearch != 'No value' && $resultSearch != 'No Dname'){
        ?>
            <div class="card-body">
            <div>
                Result : {{ $resultState }}
                <br/>
                Found result : {{ count($resultSearch) }} values
            </div>
            <table class="table-white table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                <thead>
                    <tr role="row">
                        <!-- <th>BUDGET YEAR</th> -->
                        <!-- <th>Method</th> -->
                        <th width="3%" style="text-align:center;">GPU ID</th>
                        <th width="22%" style="text-align:center;">GPU NAME</th>
                        <th width="3%" style="text-align:center;">TPU ID</th>
                        <th width="41%" style="text-align:center;">TPU NAME</th>
                        <th width="5%" style="text-align:center;">Method</th>
                        <th width="8%" style="text-align:center;">Total Amount</th>
                        <th width="5%" style="text-align:center;">wavg unit price</th>
                        <th width="8%" style="text-align:center;">Total Spend</th>
                        <th width="5%" style="text-align:center;">Gini</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    for($i = 0; $i < count($resultSearch); $i++){
                    ?>
                        <tr>
                        <!-- <td style="text-align:center;">{{ $resultSearch[$i]->BUDGET_YEAR }}</td> -->
                        <!-- <td style="text-align:center;">{{ $resultSearch[$i]->Method }}</td>   -->
                        <td style="text-align:center;">{{ $resultSearch[$i]->GPU_ID }}</td>  
                        <td style="text-align:center;">{{ $resultSearch[$i]->GPU_NAME }}</td>
                        <td style="text-align:center;">{{ $resultSearch[$i]->TPU_ID }}</td>  
                        <td style="text-align:center;">{{ $resultSearch[$i]->TPU_NAME }}</td>
                        <td style="text-align:center;">{{ $resultSearch[$i]->Method }}</td>
                        <td style="text-align:center;">{{ $resultSearch[$i]->To_Total_Amount }}</td>  
                        <td style="text-align:center;">{{ $resultSearch[$i]->wavg_unit_price }}</td>
                        <td style="text-align:center;">{{ $resultSearch[$i]->To_Total_Spend }}</td>
                        <?php
                        if ($resultSearch[$i]->Gini != NULL){
                        ?>
                            <td style="text-align:center;">{{ $resultSearch[$i]->Gini }}</td>
                        </tr>
                        <?php
                        }else{
                            //Gini = NULL because PAC = 0
                        ?>
                            <td style="text-align:center;">NULL (PAC=0)</td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            </div>
        <?php
        }else if($resultSearch == 'No Dname'){
        ?>
            <script>alert('Please insert name');</script>
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
    <?php
    }
    ?>
    <!-- *************************************************************** -->
    <!-- End Search Filter -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- 100% stacked bar chart -->
    <!-- *************************************************************** -->
    <?php
    $i=0;
    if(!empty($resultSearch) && $resultSearch != 'No value' && $resultSearch != 'No Dname'){
    ?>
    <style>
        #Region_To_Size, #Size_To_Region, #backButton_Type {
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
        #to_A, #to_S, #to_M1, #to_M2, #to_F1, #to_F2, #to_F3, #to_undefined{
            border-radius: 4px;
            padding: 10px;
            border: none;
            font-size: 16px;
            background-color: beige;
            color: grey;
            position: block;
            cursor: pointer;
        }
    </style>
    <script>
        var sizeAll = {!! json_encode($chart_Size) !!};
        var sizeData = {
            name: "Type of Hospital",
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels: sizeAll,
                datasets:[
                {
                    label:'Below Average PAC',
                    data: [{{ $chartLow_Size[0] }}, {{ $chartLow_Size[1] }}, {{ $chartLow_Size[2] }},
                        {{ $chartLow_Size[3] }}, {{ $chartLow_Size[4] }}, {{ $chartLow_Size[5] }},
                        {{ $chartLow_Size[6] }}, {{ $chartLow_Size[7] }}],
                    backgroundColor:'#cf2620',
                    borderWidth:1,
                    borderColor:'#ffffff00',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                },
                {
                    label:'Average PAC = {{$avg}}',
                    data: [ {{ $chartMed_Size[0] }} , {{ $chartMed_Size[1] }}, {{ $chartMed_Size[2] }},
                        {{ $chartMed_Size[3] }}, {{ $chartMed_Size[4] }}, {{ $chartMed_Size[5] }},
                        {{ $chartMed_Size[6] }}, {{ $chartMed_Size[7] }}],
                    backgroundColor:'#ff8f1d',
                    borderWidth:1,
                    borderColor:'#ffffff00',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                },{
                    label:'Above Average PAC',
                    data:[{{ $chartHigh_Size[0] }}, {{ $chartHigh_Size[1] }}, {{ $chartHigh_Size[2] }},
                        {{ $chartHigh_Size[3] }}, {{ $chartHigh_Size[4] }}, {{ $chartHigh_Size[5] }},
                        {{ $chartHigh_Size[6] }}, {{ $chartHigh_Size[7] }}],
                    backgroundColor:'#4aab57',
                    borderWidth:1,
                    borderColor:'#ffffff00',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                }],
            },
            options:{
                scales: {
                    xAxes: [{ stacked: true }],
                    yAxes: [{ stacked: true, 
                                ticks: {
                                beginAtZero: true,
                                max: 100
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Percentage (%)'
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
        var color_d = {'A':'#c44085', 'S':'#e08fc6', 'M1':'#ffcd74', 'M2':'#f0882f', 'F1':'#3d8b3d', 'F2':'#73d15c', 'F3':'#769eda', 'Undefined':'#4763bd'};
        $(document).ready(function() {
            Chart.defaults.global.defaultFontFamily = '"Rubik", sans-serif';
            // Start Size of Hospital ///////
            $("#Region_To_Size").click(function() { 
                // $(this).toggleClass("invisible");
                // $("#Size_To_Region").toggleClass("invisible");
                document.getElementById("Size_To_Region").style.backgroundColor = '#EAEFF3';
                document.getElementById("Size_To_Region").style.color = 'grey';
                document.getElementById("Region_To_Size").style.backgroundColor = '#777fca';
                document.getElementById("Region_To_Size").style.color = 'white';
                $("#Price_by_Region").addClass("invisible");
                $("#Quantity_by_Region").addClass("invisible");
                $.massPopChart.destroy();
                var myChart_s1 = $("#myChart").get(0).getContext("2d");
                $.massPopChart_s = new Chart(myChart_s1, sizeData);
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($Donut_Type_result) !!};
                content_1 = {!! json_encode($Type_Hos_table) !!};
                if(content != ''){
                    $("#Donut_Type").removeClass('invisible');  
                    $("#drill_down_type_button").removeClass("invisible");
                    //donut graph
                    c3.generate({ 
                        bindto:"#size_quan_donut",
                        data:{columns:[["Type A", content['A']['Total_Total_Amount']], ['Type S', content['S']['Total_Total_Amount']],
                            ['Type M1', content['M1']['Total_Total_Amount']], ["Type M2", content['M2']['Total_Total_Amount']],
                            ['Type F1', content['F1']['Total_Total_Amount']], ['Type F2', content['F2']['Total_Total_Amount']],
                            ["Type F3", content['F3']['Total_Total_Amount']], ['Undefined', content['Undefined']['Total_Total_Amount']]],
                            type:"donut",
                            tooltip:{show:!0}
                        },
                        donut:{label:{show:!1},
                        title: "Total " + content['total'],width:30},
                        legend:{hide:!0},
                        color:{pattern:[color_d['A'],color_d['S'],color_d['M1'],color_d['M2'],color_d['F1'],color_d['F2'],color_d['F3'],color_d['Undefined']]}
                    });
                    //table
                    $('#Table_quan_donut tbody').html(content_1);
                }else if(content == '' || content == NULL){
                    alert('No data');
                }
            });
            $("#Size_To_Region").click(function() { 
                // $(this).toggleClass("invisible");
                // $("#Region_To_Size").toggleClass("invisible");
                document.getElementById("Region_To_Size").style.backgroundColor = '#EAEFF3';
                document.getElementById("Region_To_Size").style.color = 'grey';
                document.getElementById("Size_To_Region").style.backgroundColor = '#777fca';
                document.getElementById("Size_To_Region").style.color = 'white';
                $("#Price_by_Region").removeClass("invisible");  
                $("#Quantity_by_Region").removeClass("invisible");
                $.massPopChart_s.destroy();
                var myChart_s2 = $("#myChart").get(0).getContext("2d");
                $.massPopChart = new Chart(myChart_s2, optionData);
                $('#Donut_Type').addClass('invisible'); 
                $("#drill_down_type_button").addClass("invisible"); 
            });
            $("#to_A").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['A'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['A'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type A";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['A'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['A'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['A'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_S").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['S'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['S'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type S";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['S'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['S'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['S'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_M1").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['M1'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['M1'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type M1";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['M1'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['M1'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['M1'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_M2").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['M2'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['M2'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type M2";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['M2'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['M2'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['M2'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_F1").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['F1'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['F1'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type F1";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['F1'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['F1'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['F1'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_F2").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['F2'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['F2'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type F2";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['F2'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['F2'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['F2'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_F3").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['F3'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['F3'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type F3";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['F3'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['F3'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['F3'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#to_undefined").click(function() { 
                //table
                var content = '';
                var content_1 = '';
                content = {!! json_encode($table_type_drill) !!};
                content_1 = content['Undefined'];
                total = {!! json_encode($total_type) !!};
                total_1 = total['Undefined'];
                if(content_1 != ''){
                    $("#Donut_Type").addClass('invisible');  
                    $("#drill_down_type_button").addClass("invisible");
                    $('#Stack_Bar').addClass('invisible'); 
                    $('#drill_down_donut').removeClass('invisible');
                    document.getElementById("Size_Donut_title").innerHTML = "Acquisition Capability in Hospital Type Undefined";
                    //donut graph
                    low = {!! json_encode($chartUnder_type) !!};
                    low_1 = low['Undefined'];
                    med = {!! json_encode($chartAvg_type) !!};
                    med_1 = med['Undefined'];
                    high = {!! json_encode($chartOver_type) !!};
                    high_1 = high['Undefined'];
                    c3.generate({ 
                        bindto:"#size_quan_donut_all",
                        data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                        type:"donut",
                        tooltip:{show:!0}},
                        donut:{label:{show:!1},
                        title: total_1 + " Hospitals",width:50},
                        legend:{hide:!0},
                        color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                    });
                    //table
                    $('#drill_down_table_type tbody').html(content_1);
                }else if(content_1 == '' || content_1 == NULL){
                    alert('No data');
                }
            });
            $("#backButton_Type").click(function() { 
                $("#drill_down_type_button").removeClass("invisible"); 
                $('#Stack_Bar').removeClass('invisible'); 
                $('#Donut_Type').removeClass('invisible'); 
                $('#drill_down_donut').addClass('invisible'); 
            });

        });
        // END size of Hospital /////////
    </script>
    <div class="row">
        <div class="col-md-7 col-lg-6" id = 'Price_by_Region'>
            <div class="card">
                <div class="card-body">
                    <button class="btn invisible" id="backButton" style="background-color:#00aaee;">&lt; Drill Up</button>
                    <h3 class="card-title" style="text-align:center;">Price by region</h3>
                    <div class="row col-lg-12" style="margin:auto; align:center;">
                        <div class="row col-lg-7" style="margin:auto;">
                            <div id="vmapTH_pri" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r1" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r2" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r3" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r4" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r5" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r6" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r7" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r8" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r9" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r10" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r11" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r12" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_pri_r13" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div>
                            <i class="fas fa-circle font-10 mr-2" style="color:#006491;"></i>highest<br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#C8EEFF;"></i>Lowest
                            </div>
                        </div>

                        <div class="row col-lg-5" style="margin-right:auto; font-size:14px;">
                            <div id="Map_Pri_TH">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:5px;">Region</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap[$i]->Region }}</td>  
                                                <?php
                                                if ($resultThaiMap[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_1">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg1); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg1[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg1[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg1[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_2">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg2); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg2[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg2[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg2[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_3">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg3); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg3[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg3[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg3[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_4">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg4); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg4[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg4[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg4[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_5">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg5); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg5[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg5[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg5[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_6">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg6); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg6[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg6[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg6[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_7">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg7); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg7[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg7[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg7[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_8">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg8); $i++){
                                        ?>
                                            <tr>
                                                <?php
                                                if($resultThaiMap_Reg8[$i]->PROVINCE_EN == 'NULL'){
                                                ?>
                                                    <td style="text-align:center;">Bueng Kan</td>  
                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg8[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                }
                                                if ($resultThaiMap_Reg8[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg8[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_9">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg9); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg9[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg9[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg9[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_10">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg10); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg10[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg10[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg10[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_11">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg11); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg11[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg11[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg11[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_12">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg12); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg12[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg12[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg12[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Pri_Region_13">
                                <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Unit Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg13); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg13[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg13[$i]->wavg_unit_price != NULL){
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg13[$i]->wavg_unit_price }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-6" id = 'Quantity_by_Region'>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="text-align:center;">Quantity by region</h3>
                    <div class="row col-lg-12" style="margin:auto; align:center;">
                        <div class="row col-lg-7" style="margin:auto;">
                            <div id="vmapTH_quan" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r1" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r2" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r3" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r4" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r5" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r6" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r7" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r8" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r9" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r10" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r11" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r12" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div class = "invisible" id="vmapTH_quan_r13" style="width: 180px; height: 280px; border-radius: 10px;"></div>
                            <div>
                            <i class="fas fa-circle font-10 mr-2" style="color:#006491;"></i>highest<br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#C8EEFF;"></i>Lowest
                            </div>
                        </div>

                        <div class="row col-lg-5" style="margin-right:auto; font-size:14px;">
                            <div id="Map_Quan_TH">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:5px;">Region</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap[$i]->Region }}</td>  
                                                <?php
                                                if ($resultThaiMap[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_1">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg1); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg1[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg1[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg1[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_2">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg2); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg2[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg2[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg2[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_3">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg3); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg3[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg3[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg3[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_4">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg4); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg4[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg4[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg4[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_5">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg5); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg5[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg5[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg5[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_6">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg6); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg6[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg6[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg6[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_7">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg7); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg7[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg7[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg7[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_8">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg8); $i++){
                                        ?>
                                            <tr>
                                                <?php
                                                if($resultThaiMap_Reg8[$i]->PROVINCE_EN == 'NULL'){
                                                ?>
                                                    <td style="text-align:center;">Bueng Kan</td>  
                                                <?php
                                                }else{
                                                ?>
                                                    <td style="text-align:center;">{{ $resultThaiMap_Reg8[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                }
                                                if ($resultThaiMap_Reg8[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg8[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_9">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg9); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg9[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg9[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg9[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_10">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg10); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg10[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg10[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg10[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_11">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg11); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg11[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg11[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg11[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_12">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg12); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg12[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg12[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg12[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class = "invisible" id="Map_Quan_Region_13">
                                <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:center; padding:10px;">Province</th>
                                        <th style="text-align:center; padding:5px;">Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i = 0; $i < count($resultThaiMap_Reg13); $i++){
                                        ?>
                                            <tr>
                                                <td style="text-align:center;">{{ $resultThaiMap_Reg13[$i]->PROVINCE_EN }}</td>  
                                                <?php
                                                if ($resultThaiMap_Reg13[$i]->Total_Amount != NULL){
                                                ?>
                                                    <td style="text-align:right;">{{ $resultThaiMap_Reg13[$i]->T_Total_Amount }}</td>

                                                <?php
                                                }else{
                                                    //Gini = NULL because PAC = 0
                                                ?>
                                                    <td style="text-align:right;">0</td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id = 'Stack_Bar'>
        <div class="col-md-12">
            <div class="card invisible" id="drill_down_type_button">
                <div class="card-body" style="padding-top: 10px; padding-bottom: 3px; margin:auto;">
                    <h4>Drill Down&nbsp;&nbsp;
                    <button class="btn" id="to_A" style="background-color:#c44085; color:white;">To A</button>
                    <button class="btn" id="to_S" style="background-color:#e08fc6; color:white;">To S</button>
                    <button class="btn" id="to_M1" style="background-color:#e08fc6; color:white;">To M1</button>
                    <button class="btn" id="to_M2" style="background-color:#f0882f; color:white;">To M2</button>
                    <button class="btn" id="to_F1" style="background-color:#3d8b3d; color:white;">To F1</button>
                    <button class="btn" id="to_F2" style="background-color:#73d15c; color:white;">To F2</button>
                    <button class="btn" id="to_F3" style="background-color:#769eda; color:white;">To F3</button>
                    <button class="btn" id="to_undefined" style="background-color:#4763bd; color:white;">To Undefined</button>
                    </h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button class="btn" id="Size_To_Region" style="background-color:#777fca; color:white;">Region</button>
                    <button class="btn" id="Region_To_Size" style="background-color:#EAEFF3; color:grey;">Size of hospital</button>
                    <br/>
                    <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">
                            <h3 class="card-title" id="pp_region" style="color:black; text-align:center;">Acquisition Capability in Thailand</h3>
                            <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">
                                <?php
                                if(isset($chartHighPercent) || isset($chartMedPercent) || isset($chartLowPercent)){
                                ?>
                                    <canvas id="myChart" style="margin: auto;"></canvas>
                                <?php
                                }else{
                                ?>
                                    <canvas id="myChart">No Data</canvas>
                                <?php
                                }
                                ?>
                            </div>
                            <p style="font-size:14px;">*Acquisition Capability is calculated from PAC value</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row invisible" id="drill_down_donut">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn" id="backButton_Type" style="background-color:#00aaee; color:white;">&lt; Drill Up</button>
                    <h4 class="card-title" id="Size_Donut_title" style="color:black; text-align:center;"></h4>
                    <div class='row center'>
                        <div id="size_quan_donut_all" class="mt-2 col-md-7 center" style="height:283px; width:60%;"></div>
                        <div class="col-md-5 center">
                            <i class="fas fa-circle font-10 mr-2" style="color:#4aab57;"></i>
                            <span class="text-muted" >Above Average PAC</span>
                            <br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#ff8f1d;"></i>
                            <span class="text-muted" >Average PAC = {{ $avg }} </span>
                            <br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#cf2620;"></i>
                            <span class="text-muted" >Below Average PAC</span>
                        </div>
                    </div>
                    <p style="font-size:14px;">*Acquisition Capability is calculated from PAC value</p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="color:black; text-align:center;">List of Hospital</h4>
                    <div class='row center'>
                        <table id="drill_down_table_type" style="width: 100%;" role="grid">
                            <thead>
                            <tr role="row">
                                <th style="text-align:center;">ID</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center; padding:5px;">Type</th>
                                <th style="text-align:center;">IP</th>
                                <th style="text-align:center;">OP</th>
                                <th style="text-align:center;">Avg Unit Price</th>
                                <th style="text-align:center;">Quantity</th>
                                <th style="text-align:center;">Total Spend</th>
                                <th style="text-align:center;">PAC</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row invisible" id = 'Donut_Type'>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="Size_Donut" style="color:black; text-align:center;">Purchasing Quantity</h4>
                    <div class='row center'>
                        <div id="size_quan_donut" class="mt-2 col-md-7 center" style="height:283px; width:60%;"></div>
                        <div class="center" style="width: 100%;">
                            <table id="Table_quan_donut" style="width: 100%;" role="grid">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center; padding:5px;"># of Hopitals</th>
                                    <th style="text-align:center;">Unit Price</th>
                                    <th style="text-align:center;">Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
            // For WHole Country Chart Option ///////////////////////////////////////////
            var optionData = {
                name: "Whole Country",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['Region1', 'Region2', 'Region3', 'Region4', 'Region5', 'Region6'
                        ,'Region7', 'Region8', 'Region9', 'Region10', 'Region11', 'Region12', 'Region13'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent[0] }}, {{ $chartLowPercent[1] }}, {{ $chartLowPercent[2] }},
                            {{ $chartLowPercent[3] }}, {{ $chartLowPercent[4] }}, {{ $chartLowPercent[5] }},
                            {{ $chartLowPercent[6] }}, {{ $chartLowPercent[7] }}, {{ $chartLowPercent[8] }},
                            {{ $chartLowPercent[9] }}, {{ $chartLowPercent[10] }}, {{ $chartLowPercent[11] }},
                            {{ $chartLowPercent[12] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [ {{ $chartMedPercent[0] }} , {{ $chartMedPercent[1] }}, {{ $chartMedPercent[2] }},
                            {{ $chartMedPercent[3] }}, {{ $chartMedPercent[4] }}, {{ $chartMedPercent[5] }},
                            {{ $chartMedPercent[6] }}, {{ $chartMedPercent[7] }}, {{ $chartMedPercent[8] }},
                            {{ $chartMedPercent[9] }}, {{ $chartMedPercent[10] }}, {{ $chartMedPercent[11] }},
                            {{ $chartMedPercent[12] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent[0] }}, {{ $chartHighPercent[1] }}, {{ $chartHighPercent[2] }},
                            {{ $chartHighPercent[3] }}, {{ $chartHighPercent[4] }}, {{ $chartHighPercent[5] }},
                            {{ $chartHighPercent[6] }}, {{ $chartHighPercent[7] }}, {{ $chartHighPercent[8] }},
                            {{ $chartHighPercent[9] }}, {{ $chartHighPercent[10] }}, {{ $chartHighPercent[11] }},
                            {{ $chartHighPercent[12] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
            
            ////////// generate chart ////////////////////////////////////////
            $.myChart = document.getElementById('myChart').getContext('2d');
            $.massPopChart = new Chart(myChart, optionData);

            //// For Region 1 Chart Option ///////////////////////////////////////////
            var optionData_Region1 = {
                name: "Region 1",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_1[0] }}', '{{ $chartRegion_1[1] }}', '{{ $chartRegion_1[2] }}', '{{ $chartRegion_1[3] }}', '{{ $chartRegion_1[4] }}',
                    '{{ $chartRegion_1[5] }}', '{{ $chartRegion_1[6] }}', '{{ $chartRegion_1[7] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_1[0] }}, {{ $chartLowPercent_1[1] }}, {{ $chartLowPercent_1[2] }},
                            {{ $chartLowPercent_1[3] }}, {{ $chartLowPercent_1[4] }}, {{ $chartLowPercent_1[5] }},
                            {{ $chartLowPercent_1[6] }}, {{ $chartLowPercent_1[7] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_1[0] }} , {{ $chartMedPercent_1[1] }}, {{ $chartMedPercent_1[2] }},
                            {{ $chartMedPercent_1[3] }}, {{ $chartMedPercent_1[4] }}, {{ $chartMedPercent_1[5] }},
                            {{ $chartMedPercent_1[6] }}, {{ $chartMedPercent_1[7] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_1[0] }}, {{ $chartHighPercent_1[1] }}, {{ $chartHighPercent_1[2] }},
                            {{ $chartHighPercent_1[3] }}, {{ $chartHighPercent_1[4] }}, {{ $chartHighPercent_1[5] }},
                            {{ $chartHighPercent_1[6] }}, {{ $chartHighPercent_1[7] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };    
            //// For Region 2 Chart Option ///////////////////////////////////////////
            var optionData_Region2 = {
                name: "Region 2",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_2[0] }}', '{{ $chartRegion_2[1] }}', '{{ $chartRegion_2[2] }}', '{{ $chartRegion_2[3] }}', '{{ $chartRegion_2[4] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_2[0] }}, {{ $chartLowPercent_2[1] }}, {{ $chartLowPercent_2[2] }},
                            {{ $chartLowPercent_2[3] }}, {{ $chartLowPercent_2[4] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_2[0] }} , {{ $chartMedPercent_2[1] }}, {{ $chartMedPercent_2[2] }},
                            {{ $chartMedPercent_2[3] }}, {{ $chartMedPercent_2[4] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_2[0] }}, {{ $chartHighPercent_2[1] }}, {{ $chartHighPercent_2[2] }},
                            {{ $chartHighPercent_2[3] }}, {{ $chartHighPercent_2[4] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
            //// For Region 3 Chart Option ///////////////////////////////////////////
            var optionData_Region3 = {
                name: "Region 3",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_3[0] }}', '{{ $chartRegion_3[1] }}', '{{ $chartRegion_3[2] }}', '{{ $chartRegion_3[3] }}', '{{ $chartRegion_3[4] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_3[0] }}, {{ $chartLowPercent_3[1] }}, {{ $chartLowPercent_3[2] }},
                            {{ $chartLowPercent_3[3] }}, {{ $chartLowPercent_3[4] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_3[0] }} , {{ $chartMedPercent_3[1] }}, {{ $chartMedPercent_3[2] }},
                            {{ $chartMedPercent_3[3] }}, {{ $chartMedPercent_3[4] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_3[0] }}, {{ $chartHighPercent_3[1] }}, {{ $chartHighPercent_3[2] }},
                            {{ $chartHighPercent_3[3] }}, {{ $chartHighPercent_3[4] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
            //// For Region 4 Chart Option ///////////////////////////////////////////
            var optionData_Region4 = {
                name: "Region 4",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_4[0] }}', '{{ $chartRegion_4[1] }}', '{{ $chartRegion_4[2] }}', '{{ $chartRegion_4[3] }}', '{{ $chartRegion_4[4] }}',
                    '{{ $chartRegion_4[5] }}', '{{ $chartRegion_4[6] }}', '{{ $chartRegion_4[7] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_4[0] }}, {{ $chartLowPercent_4[1] }}, {{ $chartLowPercent_4[2] }},
                            {{ $chartLowPercent_4[3] }}, {{ $chartLowPercent_4[4] }}, {{ $chartLowPercent_4[5] }},
                            {{ $chartLowPercent_4[6] }}, {{ $chartLowPercent_4[7] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_4[0] }} , {{ $chartMedPercent_4[1] }}, {{ $chartMedPercent_4[2] }},
                            {{ $chartMedPercent_4[3] }}, {{ $chartMedPercent_4[4] }}, {{ $chartMedPercent_4[5] }},
                            {{ $chartMedPercent_4[6] }}, {{ $chartMedPercent_4[7] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_4[0] }}, {{ $chartHighPercent_4[1] }}, {{ $chartHighPercent_4[2] }},
                            {{ $chartHighPercent_4[3] }}, {{ $chartHighPercent_4[4] }}, {{ $chartHighPercent_4[5] }},
                            {{ $chartHighPercent_4[6] }}, {{ $chartHighPercent_4[7] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                   
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };
            //// For Region 5 Chart Option ///////////////////////////////////////////
            var optionData_Region5 = {
                name: "Region 5",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_5[0] }}', '{{ $chartRegion_5[1] }}', '{{ $chartRegion_5[2] }}', '{{ $chartRegion_5[3] }}', '{{ $chartRegion_5[4] }}',
                    '{{ $chartRegion_5[5] }}', '{{ $chartRegion_5[6] }}', '{{ $chartRegion_5[7] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_5[0] }}, {{ $chartLowPercent_5[1] }}, {{ $chartLowPercent_5[2] }},
                            {{ $chartLowPercent_5[3] }}, {{ $chartLowPercent_5[4] }}, {{ $chartLowPercent_5[5] }},
                            {{ $chartLowPercent_5[6] }}, {{ $chartLowPercent_5[7] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_5[0] }} , {{ $chartMedPercent_5[1] }}, {{ $chartMedPercent_5[2] }},
                            {{ $chartMedPercent_5[3] }}, {{ $chartMedPercent_5[4] }}, {{ $chartMedPercent_5[5] }},
                            {{ $chartMedPercent_5[6] }}, {{ $chartMedPercent_5[7] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_5[0] }}, {{ $chartHighPercent_5[1] }}, {{ $chartHighPercent_5[2] }},
                            {{ $chartHighPercent_5[3] }}, {{ $chartHighPercent_5[4] }}, {{ $chartHighPercent_5[5] }},
                            {{ $chartHighPercent_5[6] }}, {{ $chartHighPercent_5[7] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            }; 
            //// For Region 6 Chart Option ///////////////////////////////////////////
            var optionData_Region6 = {
                name: "Region 6",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_6[0] }}', '{{ $chartRegion_6[1] }}', '{{ $chartRegion_6[2] }}', '{{ $chartRegion_6[3] }}', '{{ $chartRegion_6[4] }}',
                    '{{ $chartRegion_6[5] }}', '{{ $chartRegion_6[6] }}', '{{ $chartRegion_6[7] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_6[0] }}, {{ $chartLowPercent_6[1] }}, {{ $chartLowPercent_6[2] }},
                            {{ $chartLowPercent_6[3] }}, {{ $chartLowPercent_6[4] }}, {{ $chartLowPercent_6[5] }},
                            {{ $chartLowPercent_6[6] }}, {{ $chartLowPercent_6[7] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_6[0] }} , {{ $chartMedPercent_6[1] }}, {{ $chartMedPercent_6[2] }},
                            {{ $chartMedPercent_6[3] }}, {{ $chartMedPercent_6[4] }}, {{ $chartMedPercent_6[5] }},
                            {{ $chartMedPercent_6[6] }}, {{ $chartMedPercent_6[7] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_6[0] }}, {{ $chartHighPercent_6[1] }}, {{ $chartHighPercent_6[2] }},
                            {{ $chartHighPercent_6[3] }}, {{ $chartHighPercent_6[4] }}, {{ $chartHighPercent_6[5] }},
                            {{ $chartHighPercent_6[6] }}, {{ $chartHighPercent_6[7] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                   
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };
            //// For Region 7 Chart Option ///////////////////////////////////////////
            var optionData_Region7 = {
                name: "Region 7",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_7[0] }}', '{{ $chartRegion_7[1] }}', '{{ $chartRegion_7[2] }}', '{{ $chartRegion_7[3] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_7[0] }}, {{ $chartLowPercent_7[1] }}, {{ $chartLowPercent_7[2] }},
                            {{ $chartLowPercent_7[3] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_7[0] }} , {{ $chartMedPercent_7[1] }}, {{ $chartMedPercent_7[2] }},
                            {{ $chartMedPercent_7[3] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_7[0] }}, {{ $chartHighPercent_7[1] }}, {{ $chartHighPercent_7[2] }},
                            {{ $chartHighPercent_7[3] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
            //// For Region 8 Chart Option ///////////////////////////////////////////
            var optionData_Region8 = {
                name: "Region 8",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_8[0] }}', '{{ $chartRegion_8[1] }}', '{{ $chartRegion_8[2] }}', '{{ $chartRegion_8[3] }}',
                            '{{ $chartRegion_8[4] }}', '{{ $chartRegion_8[5] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_8[0] }}, {{ $chartLowPercent_8[1] }}, {{ $chartLowPercent_8[2] }},
                            {{ $chartLowPercent_8[3] }}, {{ $chartLowPercent_8[4] }}, {{ $chartLowPercent_8[5] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_8[0] }} , {{ $chartMedPercent_8[1] }}, {{ $chartMedPercent_8[2] }},
                            {{ $chartMedPercent_8[3] }}, {{ $chartMedPercent_8[4] }}, {{ $chartMedPercent_8[5] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_8[0] }}, {{ $chartHighPercent_8[1] }}, {{ $chartHighPercent_8[2] }},
                            {{ $chartHighPercent_8[3] }}, {{ $chartHighPercent_8[4] }}, {{ $chartHighPercent_8[5] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };
            //// For Region 9 Chart Option ///////////////////////////////////////////
            var optionData_Region9 = {
                name: "Region 9",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_9[0] }}', '{{ $chartRegion_9[1] }}', '{{ $chartRegion_9[2] }}', '{{ $chartRegion_9[3] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_9[0] }}, {{ $chartLowPercent_9[1] }}, {{ $chartLowPercent_9[2] }},
                            {{ $chartLowPercent_9[3] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_9[0] }} , {{ $chartMedPercent_9[1] }}, {{ $chartMedPercent_9[2] }},
                            {{ $chartMedPercent_9[3] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_9[0] }}, {{ $chartHighPercent_9[1] }}, {{ $chartHighPercent_9[2] }},
                            {{ $chartHighPercent_9[3] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
            //// For Region 10 Chart Option ///////////////////////////////////////////
            var optionData_Region10 = {
                name: "Region 10",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_10[0] }}', '{{ $chartRegion_10[1] }}', '{{ $chartRegion_10[2] }}', '{{ $chartRegion_10[3] }}', '{{ $chartRegion_10[4] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_10[0] }}, {{ $chartLowPercent_10[1] }}, {{ $chartLowPercent_10[2] }},
                            {{ $chartLowPercent_10[3] }}, {{ $chartLowPercent_10[4] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_10[0] }} , {{ $chartMedPercent_10[1] }}, {{ $chartMedPercent_10[2] }},
                            {{ $chartMedPercent_10[3] }}, {{ $chartMedPercent_10[4] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_10[0] }}, {{ $chartHighPercent_10[1] }}, {{ $chartHighPercent_10[2] }},
                            {{ $chartHighPercent_10[3] }}, {{ $chartHighPercent_10[4] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
            //// For Region 11 Chart Option ///////////////////////////////////////////
            var optionData_Region11 = {
                name: "Region 11",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_11[0] }}', '{{ $chartRegion_11[1] }}', '{{ $chartRegion_11[2] }}', '{{ $chartRegion_11[3] }}', '{{ $chartRegion_11[4] }}',
                    '{{ $chartRegion_11[5] }}', '{{ $chartRegion_11[6] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_11[0] }}, {{ $chartLowPercent_11[1] }}, {{ $chartLowPercent_11[2] }},
                            {{ $chartLowPercent_11[3] }}, {{ $chartLowPercent_11[4] }}, {{ $chartLowPercent_11[5] }},
                            {{ $chartLowPercent_11[6] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_11[0] }} , {{ $chartMedPercent_11[1] }}, {{ $chartMedPercent_11[2] }},
                            {{ $chartMedPercent_11[3] }}, {{ $chartMedPercent_11[4] }}, {{ $chartMedPercent_11[5] }},
                            {{ $chartMedPercent_11[6] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_11[0] }}, {{ $chartHighPercent_11[1] }}, {{ $chartHighPercent_11[2] }},
                            {{ $chartHighPercent_11[3] }}, {{ $chartHighPercent_11[4] }}, {{ $chartHighPercent_11[5] }},
                            {{ $chartHighPercent_11[6] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            }; 
            //// For Region 12 Chart Option ///////////////////////////////////////////
            var optionData_Region12 = {
                name: "Region 12",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_12[0] }}', '{{ $chartRegion_12[1] }}', '{{ $chartRegion_12[2] }}', '{{ $chartRegion_12[3] }}', '{{ $chartRegion_12[4] }}',
                    '{{ $chartRegion_12[5] }}', '{{ $chartRegion_12[6] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_12[0] }}, {{ $chartLowPercent_12[1] }}, {{ $chartLowPercent_12[2] }},
                            {{ $chartLowPercent_12[3] }}, {{ $chartLowPercent_12[4] }}, {{ $chartLowPercent_12[5] }},
                            {{ $chartLowPercent_12[6] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_12[0] }} , {{ $chartMedPercent_12[1] }}, {{ $chartMedPercent_12[2] }},
                            {{ $chartMedPercent_12[3] }}, {{ $chartMedPercent_12[4] }}, {{ $chartMedPercent_12[5] }},
                            {{ $chartMedPercent_12[6] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_12[0] }}, {{ $chartHighPercent_12[1] }}, {{ $chartHighPercent_12[2] }},
                            {{ $chartHighPercent_12[3] }}, {{ $chartHighPercent_12[4] }}, {{ $chartHighPercent_12[5] }},
                            {{ $chartHighPercent_12[6] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            }; 
            //// For Region 13 Chart Option ///////////////////////////////////////////
            var optionData_Region13 = {
                name: "Region 13",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['{{ $chartRegion_13[0] }}'],
                    datasets:[
                    {
                        label:'Below Average PAC',
                        data: [{{ $chartLowPercent_13[0] }}],
                        backgroundColor:'#cf2620',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Average PAC = {{$avg}}',
                        data: [{{ $chartMedPercent_13[0] }}],
                        backgroundColor:'#ff8f1d',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'Above Average PAC',
                        data:[{{ $chartHighPercent_13[0] }}],
                        backgroundColor:'#4aab57',
                        borderWidth:1,
                        borderColor:'#ffffff00',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{ stacked: true, 
                                    ticks: {
                                    beginAtZero: true,
                                    max: 100
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage (%)'
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
                            left:20,
                            right:20,
                            bottom:20,
                            top:20
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            };  
    <!-- *************************************************************** -->
    <!-- END 100% stacked bar chart -->
    <!-- *************************************************************** -->
  
    <!-- *************************************************************** -->
    <!-- Start Thai Map -->
    <!-- *************************************************************** -->
        var Region_1 = ['TH-50','TH-57','TH-51','TH-52','TH-54','TH-55','TH-56','TH-58'];
        var Region_2 = ['TH-65','TH-67','TH-53','TH-63','TH-64'];
        var Region_3 = ['TH-60','TH-62','TH-66','TH-61','TH-18'];
        var Region_4 = ['TH-17','TH-16','TH-19','TH-12','TH-14','TH-15','TH-13','TH-26'];
        var Region_5 = ['TH-70','TH-72','TH-73','TH-71','TH-75','TH-74','TH-76','TH-77'];
        var Region_6 = ['TH-20','TH-21','TH-22','TH-23','TH-11','TH-24','TH-25','TH-27'];
        var Region_7 = ['TH-40','TH-44','TH-45','TH-46'];
        var Region_8 = ['TH-41','TH-47','TH-48','TH-42','TH-39','TH-43']; //+'บึงกาฬ'
        var Region_9 = ['TH-30','TH-36','TH-31','TH-32'];
        var Region_10 = ['TH-34','TH-33','TH-35','TH-37','TH-49'];
        var Region_11 = ['TH-86','TH-85','TH-84','TH-80','TH-82','TH-81','TH-83'];
        var Region_12 = ['TH-96','TH-94','TH-95','TH-90','TH-91','TH-93','TH-92'];
        var Region_13 = ['TH-10'];
        // var coll = {"TH-30":"purple","TH-20":"#ff8f1d"};
        ////////////// TH ////////////////////
        var data_sets_pri = {!! json_encode($pri_array_all) !!};
        var data_sets_quan = {!! json_encode($quan_array_all) !!};
        ////////////// Region 1 //////////////
        var reg1_pri = {!! json_encode($pri_array_r1) !!};
        var reg1_quan = {!! json_encode($quan_array_r1) !!};
        ////////////// Region 2 //////////////
        var reg2_pri = {!! json_encode($pri_array_r2) !!};
        var reg2_quan = {!! json_encode($quan_array_r2) !!};
        ////////////// Region 3 //////////////
        var reg3_pri = {!! json_encode($pri_array_r3) !!};
        var reg3_quan = {!! json_encode($quan_array_r3) !!};
        ////////////// Region 4 //////////////
        var reg4_pri = {!! json_encode($pri_array_r4) !!};
        var reg4_quan = {!! json_encode($quan_array_r4) !!};
        ////////////// Region 5 //////////////
        var reg5_pri = {!! json_encode($pri_array_r5) !!};
        var reg5_quan = {!! json_encode($quan_array_r5) !!};
        ////////////// Region 6 //////////////
        var reg6_pri = {!! json_encode($pri_array_r6) !!};
        var reg6_quan = {!! json_encode($quan_array_r6) !!};
        ////////////// Region 7 //////////////
        var reg7_pri = {!! json_encode($pri_array_r7) !!};
        var reg7_quan = {!! json_encode($quan_array_r7) !!};
        ////////////// Region 8 //////////////
        var reg8_pri = {!! json_encode($pri_array_r8) !!};
        var reg8_quan = {!! json_encode($quan_array_r8) !!};
        ////////////// Region 9 //////////////
        var reg9_pri = {!! json_encode($pri_array_r9) !!};
        var reg9_quan = {!! json_encode($quan_array_r9) !!};
        ////////////// Region 10 //////////////
        var reg10_pri = {!! json_encode($pri_array_r10) !!};
        var reg10_quan = {!! json_encode($quan_array_r10) !!};
        ////////////// Region 11 //////////////
        var reg11_pri = {!! json_encode($pri_array_r11) !!};
        var reg11_quan = {!! json_encode($quan_array_r11) !!};
        ////////////// Region 12 //////////////
        var reg12_pri = {!! json_encode($pri_array_r12) !!};
        var reg12_quan = {!! json_encode($quan_array_r12) !!};
        ////////////// Region 13 //////////////
        var reg13_pri = {!! json_encode($pri_array_r13) !!};
        var reg13_quan = {!! json_encode($quan_array_r13) !!};

        $Region_1_name = {"TH-50":"Chiang Mai","TH-57":"Chiang Rai","TH-51":"Lamphun","TH-52":"Lampang","TH-54":"Phrae","TH-55":"Nan","TH-56":"Phayao","TH-58":"Mae Hong Son"};
        $Region_2_name = {'TH-65':'Phitsanulok','TH-67':'Phetchabun','TH-53':'Uttaradit','TH-63':'Tak','TH-64':'Sukhothai'};
        $Region_3_name = {'TH-60':'Nakhon Sawan','TH-62':'Kamphaeng Phet','TH-66':'Phichit','TH-61':'Uthai Thani','TH-18':'Chai Nat'};
        $Region_4_name = {'TH-17':'Sing Buri','TH-16':'Lop Buri','TH-19':'Saraburi','TH-12':'Nonthaburi','TH-14':'Phra Nakhon Si Ayutthaya','TH-15':'Ang Thong','TH-13':'Pathum Thani','TH-26':'Nakhon Nayok'};
        $Region_5_name = {'TH-70':'Ratchaburi','TH-72':'Suphan Buri','TH-73':'Nakhon Pathom','TH-71':'Kanchanaburi','TH-75':'Samut Songkhram','TH-74':'Samut Sakhon','TH-76':'Phetchaburi','TH-77':'Prachuap Khiri Khan'};
        $Region_6_name = {'TH-20':'Chon Buri','TH-21':'Rayong','TH-22':'Chanthaburi','TH-23':'Trat','TH-11':'Samut Prakan','TH-24':'Chachoengsao','TH-25':'Prachin Buri','TH-27':'Sa Kaeo'};
        $Region_7_name = {'TH-40':'Khon Kaen','TH-44':'Maha Sarakham','TH-45':'Roi Et','TH-46':'Kalasin'};
        $Region_8_name = {'TH-41':'Udon Thani','TH-47':'Sakon Nakhon','TH-48':'Nakhon Phanom','TH-42':'Loei','TH-39':'Nong Bua Lam Phu','TH-43':'Nong Khai'}; //+'บึงกาฬ'
        $Region_9_name = {'TH-30':'Nakhon Ratchasima','TH-36':'Chaiyaphum','TH-31':'Buri Ram','TH-32':'Surin'};
        $Region_10_name = {'TH-34':'Ubon Ratchathani','TH-33':'Si Sa Ket','TH-35':'Yasothon','TH-37':'Amnat Charoen','TH-49':'Mukdahan'};
        $Region_11_name = {'TH-86':'Chumphon','TH-85':'Ranong','TH-84':'Surat Thani','TH-80':'Nakhon Si Thammarat','TH-82':'Phangnga','TH-81':'Krabi','TH-83':'Phuket'};
        $Region_12_name = {'TH-96':'Narathiwat','TH-94':'Pattani','TH-95':'Yala','TH-90':'Songkhla','TH-91':'Satun','TH-93':'Phatthalung','TH-92':'Trang'};
        $Region_13_name = {'TH-10':'Bangkok Metropolis'};
        
        $(document).ready(function() {
            google.charts.load('current', {'packages':['corechart']});
            $Reg1_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg1_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_1 = '';
                    var low = '';
                    var low_1 = '';
                    var med = '';
                    var med_1 = '';
                    var high = '';
                    var high_1 = '';
                    var total = '';
                    if(Region_1.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r1) !!};
                        content_1 = content[code];
                        corr_region = {!! json_encode($cor_r1_value) !!};
                        corr_code = corr_region[code];
                        if(content_1 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_1_name[code];
                            low = {!! json_encode($donutD_low_r1) !!};
                            low_1 = low[code];
                            med = {!! json_encode($donutD_med_r1) !!};
                            med_1 = med[code];
                            high = {!! json_encode($donutD_high_r1) !!};
                            high_1 = high[code];
                            total = low_1 + med_1 + high_1;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]},
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_1);
                            //correlation
                            cor_data = {!! json_encode($cor_r1) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_1 == '' || content_1 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg2_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg2_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_2 = '';
                    var low = '';
                    var low_2 = '';
                    var med = '';
                    var med_2 = '';
                    var high = '';
                    var high_2 = '';
                    var total = '';
                    if(Region_2.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r2) !!};
                        content_2 = content[code];
                        corr_region = {!! json_encode($cor_r2_value) !!};
                        corr_code = corr_region[code];
                        if(content_2 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_2_name[code];
                            low = {!! json_encode($donutD_low_r2) !!};
                            low_2 = low[code];
                            med = {!! json_encode($donutD_med_r2) !!};
                            med_2 = med[code];
                            high = {!! json_encode($donutD_high_r2) !!};
                            high_2 = high[code];
                            total = low_2 + med_2 + high_2;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_2],['Average', med_2],['Below Average PAC', low_2]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_2);

                            //correlation
                            cor_data = {!! json_encode($cor_r2) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_2 == '' || content_2 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg3_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg3_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_3 = '';
                    var low = '';
                    var low_3 = '';
                    var med = '';
                    var med_3 = '';
                    var high = '';
                    var high_3 = '';
                    var total = '';
                    if(Region_3.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r3) !!};
                        content_3 = content[code];
                        corr_region = {!! json_encode($cor_r3_value) !!};
                        corr_code = corr_region[code];
                        if(content_3 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_3_name[code];
                            low = {!! json_encode($donutD_low_r3) !!};
                            low_3 = low[code];
                            med = {!! json_encode($donutD_med_r3) !!};
                            med_3 = med[code];
                            high = {!! json_encode($donutD_high_r3) !!};
                            high_3 = high[code];
                            total = low_3 + med_3 + high_3;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_3],['Average', med_3],['Below Average PAC', low_3]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_3);

                            //correlation
                            cor_data = {!! json_encode($cor_r3) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_3 == '' || content_3 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg4_map_pri = {
                map: ['thai_en'],
                hoverOpacity: 0.5,
                backgroundColor: '#EAEFF3',
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg4_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_4 = '';
                    var low = '';
                    var low_4 = '';
                    var med = '';
                    var med_4 = '';
                    var high = '';
                    var high_4 = '';
                    var total = '';
                    if(Region_4.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r4) !!};
                        content_4 = content[code];
                        corr_region = {!! json_encode($cor_r4_value) !!};
                        corr_code = corr_region[code];
                        if(content_4 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_4_name[code];
                            low = {!! json_encode($donutD_low_r4) !!};
                            low_4 = low[code];
                            med = {!! json_encode($donutD_med_r4) !!};
                            med_4 = med[code];
                            high = {!! json_encode($donutD_high_r4) !!};
                            high_4 = high[code];
                            total = low_4 + med_4 + high_4;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_4],['Average', med_4],['Below Average PAC', low_4]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_4);

                            //correlation
                            cor_data = {!! json_encode($cor_r4) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_4 == '' || content_4 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg5_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg5_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_5 = '';
                    var low = '';
                    var low_5 = '';
                    var med = '';
                    var med_5 = '';
                    var high = '';
                    var high_5 = '';
                    var total = '';
                    if(Region_5.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r5) !!};
                        content_5 = content[code];
                        corr_region = {!! json_encode($cor_r5_value) !!};
                        corr_code = corr_region[code];
                        if(content_5 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_5_name[code];
                            low = {!! json_encode($donutD_low_r5) !!};
                            low_5 = low[code];
                            med = {!! json_encode($donutD_med_r5) !!};
                            med_5 = med[code];
                            high = {!! json_encode($donutD_high_r5) !!};
                            high_5 = high[code];
                            total = low_5 + med_5 + high_5;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_5],['Average', med_5],['Below Average PAC', low_5]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_5);

                            //correlation
                            cor_data = {!! json_encode($cor_r5) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_5 == '' || content_5 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg6_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg6_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_6 = '';
                    var low = '';
                    var low_6 = '';
                    var med = '';
                    var med_6 = '';
                    var high = '';
                    var high_6 = '';
                    var total = '';
                    if(Region_6.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r6) !!};
                        content_6 = content[code];
                        corr_region = {!! json_encode($cor_r6_value) !!};
                        corr_code = corr_region[code];
                        if(content_6 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible'); 
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_6_name[code];
                            low = {!! json_encode($donutD_low_r6) !!};
                            low_6 = low[code];
                            med = {!! json_encode($donutD_med_r6) !!};
                            med_6 = med[code];
                            high = {!! json_encode($donutD_high_r6) !!};
                            high_6 = high[code];
                            total = low_6 + med_6 + high_6;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_6],['Average', med_6],['Below Average PAC', low_6]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_6);

                            //correlation
                            cor_data = {!! json_encode($cor_r6) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_6 == '' || content_6 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg7_map_pri = {
                map: ['thai_en'],
                hoverOpacity: 0.5,
                backgroundColor: '#EAEFF3',
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg7_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_7 = '';
                    var low = '';
                    var low_7 = '';
                    var med = '';
                    var med_7 = '';
                    var high = '';
                    var high_7 = '';
                    var total = '';
                    if(Region_7.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r7) !!};
                        content_7 = content[code];
                        corr_region = {!! json_encode($cor_r7_value) !!};
                        corr_code = corr_region[code];
                        if(content_7 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_7_name[code];
                            low = {!! json_encode($donutD_low_r7) !!};
                            low_7 = low[code];
                            med = {!! json_encode($donutD_med_r7) !!};
                            med_7 = med[code];
                            high = {!! json_encode($donutD_high_r7) !!};
                            high_7 = high[code];
                            total = low_7 + med_7 + high_7;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_7],['Average', med_7],['Below Average PAC', low_7]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_7);

                            //correlation
                            cor_data = {!! json_encode($cor_r7) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_7 == '' || content_7 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg8_map_pri = {
                map: ['thai_en'],
                hoverOpacity: 0.5,
                backgroundColor: '#EAEFF3',
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg8_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_8 = '';
                    var low = '';
                    var low_8 = '';
                    var med = '';
                    var med_8 = '';
                    var high = '';
                    var high_8 = '';
                    var total = '';
                    if(Region_8.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r8) !!};
                        content_8 = content[code];
                        corr_region = {!! json_encode($cor_r8_value) !!};
                        corr_code = corr_region[code];
                        if(content_8 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_8_name[code];
                            low = {!! json_encode($donutD_low_r8) !!};
                            low_8 = low[code];
                            med = {!! json_encode($donutD_med_r8) !!};
                            med_8 = med[code];
                            high = {!! json_encode($donutD_high_r8) !!};
                            high_8 = high[code];
                            total = low_8 + med_8 + high_8;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_8],['Average', med_8],['Below Average PAC', low_8]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_8);

                            //correlation
                            cor_data = {!! json_encode($cor_r8) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_8 == '' || content_8 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg9_map_pri = {
                map: ['thai_en'],
                hoverOpacity: 0.5,
                backgroundColor: '#EAEFF3',
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg9_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_9 = '';
                    var low = '';
                    var low_9 = '';
                    var med = '';
                    var med_9 = '';
                    var high = '';
                    var high_9 = '';
                    var total = '';
                    if(Region_9.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r9) !!};
                        content_9 = content[code];
                        corr_region = {!! json_encode($cor_r9_value) !!};
                        corr_code = corr_region[code];
                        if(content_9 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_9_name[code];
                            low = {!! json_encode($donutD_low_r9) !!};
                            low_9 = low[code];
                            med = {!! json_encode($donutD_med_r9) !!};
                            med_9 = med[code];
                            high = {!! json_encode($donutD_high_r9) !!};
                            high_9 = high[code];
                            total = low_9 + med_9 + high_9;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_9],['Average', med_9],['Below Average PAC', low_9]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_9);

                            //correlation
                            cor_data = {!! json_encode($cor_r9) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_9 == '' || content_9 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg10_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg10_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_10 = '';
                    var low = '';
                    var low_10 = '';
                    var med = '';
                    var med_10 = '';
                    var high = '';
                    var high_10 = '';
                    var total = '';
                    if(Region_10.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r10) !!};
                        content_10 = content[code];
                        corr_region = {!! json_encode($cor_r10_value) !!};
                        corr_code = corr_region[code];
                        if(content_10 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_10_name[code];
                            low = {!! json_encode($donutD_low_r10) !!};
                            low_10 = low[code];
                            med = {!! json_encode($donutD_med_r10) !!};
                            med_10 = med[code];
                            high = {!! json_encode($donutD_high_r10) !!};
                            high_10 = high[code];
                            total = low_10 + med_10 + high_10;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_10],['Average', med_10],['Below Average PAC', low_10]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_10);

                            //correlation
                            cor_data = {!! json_encode($cor_r10) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_10 == '' || content_10 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg11_map_pri = {
                map: ['thai_en'],
                hoverOpacity: 0.5,
                backgroundColor: '#EAEFF3',
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg11_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_11 = '';
                    var low = '';
                    var low_11 = '';
                    var med = '';
                    var med_11 = '';
                    var high = '';
                    var high_11 = '';
                    var total = '';
                    if(Region_11.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r11) !!};
                        content_11 = content[code];
                        corr_region = {!! json_encode($cor_r11_value) !!};
                        corr_code = corr_region[code];
                        if(content_11 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible'); 
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_11_name[code];
                            low = {!! json_encode($donutD_low_r11) !!};
                            low_11 = low[code];
                            med = {!! json_encode($donutD_med_r11) !!};
                            med_11 = med[code];
                            high = {!! json_encode($donutD_high_r11) !!};
                            high_11 = high[code];
                            total = low_11 + med_11 + high_11;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_11],['Average', med_11],['Below Average PAC', low_11]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_11);

                            //correlation
                            cor_data = {!! json_encode($cor_r11) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_11 == '' || content_11 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg12_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg12_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_12 = '';
                    var low = '';
                    var low_12 = '';
                    var med = '';
                    var med_12 = '';
                    var high = '';
                    var high_12 = '';
                    var total = '';
                    if(Region_12.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r12) !!};
                        content_12 = content[code];
                        corr_region = {!! json_encode($cor_r12_value) !!};
                        corr_code = corr_region[code];
                        if(content_12 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_12_name[code];
                            low = {!! json_encode($donutD_low_r12) !!};
                            low_12 = low[code];
                            med = {!! json_encode($donutD_med_r12) !!};
                            med_12 = med[code];
                            high = {!! json_encode($donutD_high_r12) !!};
                            high_12 = high[code];
                            total = low_12 + med_12 + high_12;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_12],['Average', med_12],['Below Average PAC', low_12]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_12);

                            //correlation
                            cor_data = {!! json_encode($cor_r12) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_12 == '' || content_12 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg13_map_pri = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg13_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_13 = '';
                    var low = '';
                    var low_13 = '';
                    var med = '';
                    var med_13 = '';
                    var high = '';
                    var high_13 = '';
                    var total = '';
                    if(Region_13.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r13) !!};
                        content_13 = content[code];
                        if(content_13 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_13_name[code];
                            low = {!! json_encode($donutD_low_r13) !!};
                            low_13 = low[code];
                            med = {!! json_encode($donutD_med_r13) !!};
                            med_13 = med[code];
                            high = {!! json_encode($donutD_high_r13) !!};
                            high_13 = high[code];
                            total = low_13 + med_13 + high_13;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_13],['Average', med_13],['Below Average PAC', low_13]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_13);

                        }else if(content_13 == '' || content_13 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Thai_map_pri = {
                map: ['thai_en'],
                backgroundColor:'#EAEFF3',
                hoverOpacity: 0.5,
                //color when hover on to the map (if use with hoverOpacity, มันจะมองไม่ค่อยออกว่าสีไร จะแค่แบบจางๆ แบบลดopacity ของสีแมป)
                // hoverColor: 'black',
                //if true, will enable to zoom in map
                enableZoom: false,
                showTooltip: true,
                //color ไรไม่รู้
                color: '#ffffff',
                //data set which input to get heatmap
                values: data_sets_pri,
                //color for heatmap
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                //if want specific point to change color use "colors:"
                // colors: color_sets,
                onRegionClick: function (element, code, region) {
                    $("#backButton").toggleClass("invisible");
                    $('#vmapTH_quan').toggleClass("invisible");
                    $("#Map_Quan_TH").toggleClass("invisible");
                    $('#vmapTH_pri').toggleClass("invisible");
                    $("#Map_Pri_TH").toggleClass("invisible");
                    $("#Region_To_Size").addClass("invisible");
                    $("#Size_To_Region").addClass("invisible");
                    $.massPopChart.destroy();
                    if(Region_1.includes(code)) {
                        $('#vmapTH_quan_r1').removeClass('invisible');   
                        $("#Map_Quan_Region_1").removeClass('invisible');   
                        $('#vmapTH_pri_r1').removeClass('invisible');   
                        $("#Map_Pri_Region_1").removeClass('invisible');   
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 1";
                        var myChart_1 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_1 = new Chart(myChart_1, optionData_Region1);
                    }else if(Region_2.includes(code)) {
                        $('#vmapTH_quan_r2').removeClass('invisible');  
                        $("#Map_Quan_Region_2").removeClass('invisible');  
                        $('#vmapTH_pri_r2').removeClass('invisible');  
                        $("#Map_Pri_Region_2").removeClass('invisible'); 
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 2";
                        var myChart_2 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_2 = new Chart(myChart_2, optionData_Region2); 
                    }else if(Region_3.includes(code)) {
                        $('#vmapTH_quan_r3').removeClass('invisible');   
                        $("#Map_Quan_Region_3").removeClass('invisible');   
                        $('#vmapTH_pri_r3').removeClass('invisible');   
                        $("#Map_Pri_Region_3").removeClass('invisible');
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 3";
                        var myChart_3 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_3 = new Chart(myChart_3, optionData_Region3);
                    }else if(Region_4.includes(code)) {
                        $('#vmapTH_quan_r4').removeClass('invisible');  
                        $("#Map_Quan_Region_4").removeClass('invisible');  
                        $('#vmapTH_pri_r4').removeClass('invisible');  
                        $("#Map_Pri_Region_4").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 4";
                        var myChart_4 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_4 = new Chart(myChart_4, optionData_Region4);
                    }else if(Region_5.includes(code)) {
                        $('#vmapTH_quan_r5').removeClass('invisible');  
                        $("#Map_Quan_Region_5").removeClass('invisible');  
                        $('#vmapTH_pri_r5').removeClass('invisible');  
                        $("#Map_Pri_Region_5").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 5";
                        var myChart_5 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_5 = new Chart(myChart_5, optionData_Region5);
                    }else if(Region_6.includes(code)) {
                        $('#vmapTH_quan_r6').removeClass('invisible');  
                        $("#Map_Quan_Region_6").removeClass('invisible'); 
                        $('#vmapTH_pri_r6').removeClass('invisible');  
                        $("#Map_Pri_Region_6").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 6";
                        var myChart_6 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_6 = new Chart(myChart_6, optionData_Region6);
                    }else if(Region_7.includes(code)) {
                        $('#vmapTH_quan_r7').removeClass('invisible');   
                        $("#Map_Quan_Region_7").removeClass('invisible');   
                        $('#vmapTH_pri_r7').removeClass('invisible');   
                        $("#Map_Pri_Region_7").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 7";
                        var myChart_7 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_7 = new Chart(myChart_7, optionData_Region7);
                    }else if(Region_8.includes(code)) {
                        $('#vmapTH_quan_r8').removeClass('invisible');  
                        $("#Map_Quan_Region_8").removeClass('invisible');  
                        $('#vmapTH_pri_r8').removeClass('invisible');  
                        $("#Map_Pri_Region_8").removeClass('invisible'); 
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 8";
                        var myChart_8 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_8 = new Chart(myChart_8, optionData_Region8); 
                    }else if(Region_9.includes(code)) {
                        $('#vmapTH_quan_r9').removeClass('invisible');  
                        $("#Map_Quan_Region_9").removeClass('invisible');  
                        $('#vmapTH_pri_r9').removeClass('invisible');  
                        $("#Map_Pri_Region_9").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 9";
                        var myChart_9 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_9 = new Chart(myChart_9, optionData_Region9);
                    }else if(Region_10.includes(code)) {
                        $('#vmapTH_quan_r10').removeClass('invisible');  
                        $("#Map_Quan_Region_10").removeClass('invisible');  
                        $('#vmapTH_pri_r10').removeClass('invisible');  
                        $("#Map_Pri_Region_10").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 10";
                        var myChart_10 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_10 = new Chart(myChart_10, optionData_Region10);
                    }else if(Region_11.includes(code)) {
                        $('#vmapTH_quan_r11').removeClass('invisible');   
                        $("#Map_Quan_Region_11").removeClass('invisible');   
                        $('#vmapTH_pri_r11').removeClass('invisible');   
                        $("#Map_Pri_Region_11").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 11";
                        var myChart_11 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_11 = new Chart(myChart_11, optionData_Region11);
                    }else if(Region_12.includes(code)) {
                        $('#vmapTH_quan_r12').removeClass('invisible');  
                        $("#Map_Quan_Region_12").removeClass('invisible');  
                        $('#vmapTH_pri_r12').removeClass('invisible');  
                        $("#Map_Pri_Region_12").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 12";
                        var myChart_12 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_12 = new Chart(myChart_12, optionData_Region12);
                    }else if(Region_13.includes(code)) {
                        $('#vmapTH_quan_r13').removeClass('invisible');  
                        $("#Map_Quan_Region_13").removeClass('invisible');  
                        $('#vmapTH_pri_r13').removeClass('invisible');  
                        $("#Map_Pri_Region_13").removeClass('invisible');   
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 13";
                        var myChart_13 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_13 = new Chart(myChart_13, optionData_Region13);
                    }
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////
            //---------------------------------------------------------------------------------//
            ////////// for quantity /////////////////////////////////////////////////////////////
            $Reg1_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg1_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_1 = '';
                    var low = '';
                    var low_1 = '';
                    var med = '';
                    var med_1 = '';
                    var high = '';
                    var high_1 = '';
                    var total = '';
                    if(Region_1.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r1) !!};
                        content_1 = content[code];
                        corr_region = {!! json_encode($cor_r1_value) !!};
                        corr_code = corr_region[code];
                        if(content_1 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible'); 
                            $('#corr_chart').removeClass('invisible');    
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_1_name[code];
                            low = {!! json_encode($donutD_low_r1) !!};
                            low_1 = low[code];
                            med = {!! json_encode($donutD_med_r1) !!};
                            med_1 = med[code];
                            high = {!! json_encode($donutD_high_r1) !!};
                            high_1 = high[code];
                            total = low_1 + med_1 + high_1;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_1],['Average', med_1],['Below Average PAC', low_1]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_1);
                            //correlation
                            cor_data = {!! json_encode($cor_r1) !!};

                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               
                        }else if(content_1 == '' || content_1 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg2_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg2_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_2 = '';
                    var low = '';
                    var low_2 = '';
                    var med = '';
                    var med_2 = '';
                    var high = '';
                    var high_2 = '';
                    var total = '';
                    if(Region_2.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r2) !!};
                        content_2 = content[code];
                        corr_region = {!! json_encode($cor_r2_value) !!};
                        corr_code = corr_region[code];
                        if(content_2 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_2_name[code];
                            low = {!! json_encode($donutD_low_r2) !!};
                            low_2 = low[code];
                            med = {!! json_encode($donutD_med_r2) !!};
                            med_2 = med[code];
                            high = {!! json_encode($donutD_high_r2) !!};
                            high_2 = high[code];
                            total = low_2 + med_2 + high_2;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_2],['Average', med_2],['Below Average PAC', low_2]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_2);

                            //correlation
                            cor_data = {!! json_encode($cor_r2) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_2 == '' || content_2 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg3_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg3_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_3 = '';
                    var low = '';
                    var low_3 = '';
                    var med = '';
                    var med_3 = '';
                    var high = '';
                    var high_3 = '';
                    var total = '';
                    if(Region_3.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r3) !!};
                        content_3 = content[code];
                        corr_region = {!! json_encode($cor_r3_value) !!};
                        corr_code = corr_region[code];
                        if(content_3 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_3_name[code];
                            low = {!! json_encode($donutD_low_r3) !!};
                            low_3 = low[code];
                            med = {!! json_encode($donutD_med_r3) !!};
                            med_3 = med[code];
                            high = {!! json_encode($donutD_high_r3) !!};
                            high_3 = high[code];
                            total = low_3 + med_3 + high_3;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_3],['Average', med_3],['Below Average PAC', low_3]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_3);

                            //correlation
                            cor_data = {!! json_encode($cor_r3) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_3 == '' || content_3 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg4_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg4_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_4 = '';
                    var low = '';
                    var low_4 = '';
                    var med = '';
                    var med_4 = '';
                    var high = '';
                    var high_4 = '';
                    var total = '';
                    if(Region_4.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r4) !!};
                        content_4 = content[code];
                        corr_region = {!! json_encode($cor_r4_value) !!};
                        corr_code = corr_region[code];
                        if(content_4 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_4_name[code];
                            low = {!! json_encode($donutD_low_r4) !!};
                            low_4 = low[code];
                            med = {!! json_encode($donutD_med_r4) !!};
                            med_4 = med[code];
                            high = {!! json_encode($donutD_high_r4) !!};
                            high_4 = high[code];
                            total = low_4 + med_4 + high_4;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_4],['Average', med_4],['Below Average PAC', low_4]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_4);

                            //correlation
                            cor_data = {!! json_encode($cor_r4) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_4 == '' || content_4 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg5_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg5_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_5 = '';
                    var low = '';
                    var low_5 = '';
                    var med = '';
                    var med_5 = '';
                    var high = '';
                    var high_5 = '';
                    var total = '';
                    if(Region_5.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r5) !!};
                        content_5 = content[code];
                        corr_region = {!! json_encode($cor_r5_value) !!};
                        corr_code = corr_region[code];
                        if(content_5 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_5_name[code];
                            low = {!! json_encode($donutD_low_r5) !!};
                            low_5 = low[code];
                            med = {!! json_encode($donutD_med_r5) !!};
                            med_5 = med[code];
                            high = {!! json_encode($donutD_high_r5) !!};
                            high_5 = high[code];
                            total = low_5 + med_5 + high_5;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_5],['Average', med_5],['Below Average PAC', low_5]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_5);

                            //correlation
                            cor_data = {!! json_encode($cor_r5) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_5 == '' || content_5 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg6_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg6_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_6 = '';
                    var low = '';
                    var low_6 = '';
                    var med = '';
                    var med_6 = '';
                    var high = '';
                    var high_6 = '';
                    var total = '';
                    if(Region_6.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r6) !!};
                        content_6 = content[code];
                        corr_region = {!! json_encode($cor_r6_value) !!};
                        corr_code = corr_region[code];
                        if(content_6 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_6_name[code];
                            low = {!! json_encode($donutD_low_r6) !!};
                            low_6 = low[code];
                            med = {!! json_encode($donutD_med_r6) !!};
                            med_6 = med[code];
                            high = {!! json_encode($donutD_high_r6) !!};
                            high_6 = high[code];
                            total = low_6 + med_6 + high_6;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_6],['Average', med_6],['Below Average PAC', low_6]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_6);

                            //correlation
                            cor_data = {!! json_encode($cor_r6) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_6 == '' || content_6 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg7_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg7_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_7 = '';
                    var low = '';
                    var low_7 = '';
                    var med = '';
                    var med_7 = '';
                    var high = '';
                    var high_7 = '';
                    var total = '';
                    if(Region_7.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r7) !!};
                        content_7 = content[code];
                        corr_region = {!! json_encode($cor_r7_value) !!};
                        corr_code = corr_region[code];
                        if(content_7 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_7_name[code];
                            low = {!! json_encode($donutD_low_r7) !!};
                            low_7 = low[code];
                            med = {!! json_encode($donutD_med_r7) !!};
                            med_7 = med[code];
                            high = {!! json_encode($donutD_high_r7) !!};
                            high_7 = high[code];
                            total = low_7 + med_7 + high_7;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_7],['Average', med_7],['Below Average PAC', low_7]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_7);

                            //correlation
                            cor_data = {!! json_encode($cor_r7) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_7 == '' || content_7 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg8_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg8_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_8 = '';
                    var low = '';
                    var low_8 = '';
                    var med = '';
                    var med_8 = '';
                    var high = '';
                    var high_8 = '';
                    var total = '';
                    if(Region_8.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r8) !!};
                        content_8 = content[code];
                        corr_region = {!! json_encode($cor_r8_value) !!};
                        corr_code = corr_region[code];
                        if(content_8 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible'); 
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_8_name[code];
                            low = {!! json_encode($donutD_low_r8) !!};
                            low_8 = low[code];
                            med = {!! json_encode($donutD_med_r8) !!};
                            med_8 = med[code];
                            high = {!! json_encode($donutD_high_r8) !!};
                            high_8 = high[code];
                            total = low_8 + med_8 + high_8;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_8],['Average', med_8],['Below Average PAC', low_8]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_8);

                            //correlation
                            cor_data = {!! json_encode($cor_r8) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_8 == '' || content_8 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg9_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg9_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_9 = '';
                    var low = '';
                    var low_9 = '';
                    var med = '';
                    var med_9 = '';
                    var high = '';
                    var high_9 = '';
                    var total = '';
                    if(Region_9.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r9) !!};
                        content_9 = content[code];
                        corr_region = {!! json_encode($cor_r9_value) !!};
                        corr_code = corr_region[code];
                        if(content_9 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible'); 
                            $('#corr_chart').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_9_name[code];
                            low = {!! json_encode($donutD_low_r9) !!};
                            low_9 = low[code];
                            med = {!! json_encode($donutD_med_r9) !!};
                            med_9 = med[code];
                            high = {!! json_encode($donutD_high_r9) !!};
                            high_9 = high[code];
                            total = low_9 + med_9 + high_9;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_9],['Average', med_9],['Below Average PAC', low_9]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_9);

                            //correlation
                            cor_data = {!! json_encode($cor_r9) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_9 == '' || content_9 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg10_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg10_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_10 = '';
                    var low = '';
                    var low_10 = '';
                    var med = '';
                    var med_10 = '';
                    var high = '';
                    var high_10 = '';
                    var total = '';
                    if(Region_10.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r10) !!};
                        content_10 = content[code];
                        corr_region = {!! json_encode($cor_r10_value) !!};
                        corr_code = corr_region[code];
                        if(content_10 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_10_name[code];
                            low = {!! json_encode($donutD_low_r10) !!};
                            low_10 = low[code];
                            med = {!! json_encode($donutD_med_r10) !!};
                            med_10 = med[code];
                            high = {!! json_encode($donutD_high_r10) !!};
                            high_10 = high[code];
                            total = low_10 + med_10 + high_10;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_10],['Average', med_10],['Below Average PAC', low_10]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_10);

                            //correlation
                            cor_data = {!! json_encode($cor_r10) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_10 == '' || content_10 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg11_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg11_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_11 = '';
                    var low = '';
                    var low_11 = '';
                    var med = '';
                    var med_11 = '';
                    var high = '';
                    var high_11 = '';
                    var total = '';
                    if(Region_11.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r11) !!};
                        content_11 = content[code];
                        corr_region = {!! json_encode($cor_r11_value) !!};
                        corr_code = corr_region[code];
                        if(content_11 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_11_name[code];
                            low = {!! json_encode($donutD_low_r11) !!};
                            low_11 = low[code];
                            med = {!! json_encode($donutD_med_r11) !!};
                            med_11 = med[code];
                            high = {!! json_encode($donutD_high_r11) !!};
                            high_11 = high[code];
                            total = low_11 + med_11 + high_11;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_11],['Average', med_11],['Below Average PAC', low_11]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_11);

                            //correlation
                            cor_data = {!! json_encode($cor_r11) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_11 == '' || content_11 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg12_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg12_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_12 = '';
                    var low = '';
                    var low_12 = '';
                    var med = '';
                    var med_12 = '';
                    var high = '';
                    var high_12 = '';
                    var total = '';
                    if(Region_12.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r12) !!};
                        content_12 = content[code];
                        corr_region = {!! json_encode($cor_r12_value) !!};
                        corr_code = corr_region[code];
                        if(content_12 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#corr_chart').removeClass('invisible');   
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_12_name[code];
                            low = {!! json_encode($donutD_low_r12) !!};
                            low_12 = low[code];
                            med = {!! json_encode($donutD_med_r12) !!};
                            med_12 = med[code];
                            high = {!! json_encode($donutD_high_r12) !!};
                            high_12 = high[code];
                            total = low_12 + med_12 + high_12;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_12],['Average', med_12],['Below Average PAC', low_12]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_12);

                            //correlation
                            cor_data = {!! json_encode($cor_r12) !!};
                            if(corr_code >=0.7 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#8CDFAC";
                                document.getElementById("total_corr_label").innerHTML = 'Strong Correlation';
                                document.getElementById("total_corr_label").style.color = '#60C687';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <0.7 && corr_code>0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#F8D39C";
                                document.getElementById("total_corr_label").innerHTML = 'Moderate Correlation';
                                document.getElementById("total_corr_label").style.color = '#F5C378';
                                google.charts.setOnLoadCallBack(drawChart());

                            }else if(corr_code <= 0.4 && corr_code != 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = corr_code.toFixed(3);
                                document.getElementById("total_corr_bg").style.backgroundColor = "#FFA0AF";
                                document.getElementById("total_corr_label").innerHTML = 'Weak Correlation';
                                document.getElementById("total_corr_label").style.color = '#ff4f70';
                                google.charts.setOnLoadCallBack(drawChart());
                            }else if(corr_code == 'Cannot be defined'){
                                document.getElementById("total_corr").innerHTML = "Undefined";
                                document.getElementById("total_corr_bg").style.backgroundColor = "white";
                                document.getElementById("total_corr_label").innerHTML = '';
                                google.charts.setOnLoadCallBack(drawChart());
                            }
                            function drawChart(){
                                $.coChart = new google.visualization.LineChart(document.getElementById('corr'));
                                var data = google.visualization.arrayToDataTable(cor_data[code]);
                                var cor_options = {
                                    fontName:'Rubik',
                                    legend: { position: 'bottom' },
                                    colors: ['#5f76e8', '#ff4f70']
                                };
                                $.coChart.draw(data, cor_options);
                            }
                               

                        }else if(content_12 == '' || content_12 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Reg13_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: reg13_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                    var content = '';
                    var content_13 = '';
                    var low = '';
                    var low_13 = '';
                    var med = '';
                    var med_13 = '';
                    var high = '';
                    var high_13 = '';
                    var total = '';
                    if(Region_13.includes(code)) {
                        //table
                        content = {!! json_encode($tableD_r13) !!};
                        content_13 = content[code];
                        if(content_13 != ''){
                            $("#Province_Donut").removeClass('invisible');  
                            $('#Table_Hos_by_Province').removeClass('invisible');  
                            $('#Price_by_Region').addClass('invisible');   
                            $("#Quantity_by_Region").addClass('invisible');   
                            $("#Stack_Bar").addClass('invisible'); 
                            //donut graph
                            document.getElementById("Title_Donut").innerHTML = "Acquisition Capability in " + $Region_13_name[code];
                            low = {!! json_encode($donutD_low_r13) !!};
                            low_13 = low[code];
                            med = {!! json_encode($donutD_med_r13) !!};
                            med_13 = med[code];
                            high = {!! json_encode($donutD_high_r13) !!};
                            high_13 = high[code];
                            total = low_13 + med_13 + high_13;
                            c3.generate({ 
                                bindto:"#purchasing_power_donut",
                                data:{columns:[["Above Average PAC", high_13],['Average', med_13],['Below Average PAC', low_13]],
                                type:"donut",
                                tooltip:{show:!0}},
                                donut:{label:{show:!1},
                                title: total + " Hospitals",width:50},
                                legend:{hide:!0},
                                color:{pattern:["#4aab57","#ff8f1d","#cf2620"]}
                            });
                            //table
                            $('#Table_Hos_by_Province tbody').html(content_13);
                        }else if(content_13 == '' || content_13 == NULL){
                            alert('Cannot drill down because no data');
                        }
                    }
                }
            }
            $Thai_map_quan = {
                map: ['thai_en'],
                backgroundColor: '#EAEFF3',
                hoverOpacity: 0.5,
                enableZoom: false,
                showTooltip: true,
                color: '#ffffff',
                values: data_sets_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                // colors: color_sets,
                onRegionClick: function (element, code, region) {
                    $("#backButton").toggleClass("invisible");
                    $('#vmapTH_quan').toggleClass("invisible");
                    $("#Map_Quan_TH").toggleClass("invisible");
                    $('#vmapTH_pri').toggleClass("invisible");
                    $("#Map_Pri_TH").toggleClass("invisible");
                    $("#Region_To_Size").addClass("invisible");
                    $("#Size_To_Region").addClass("invisible");
                    $.massPopChart.destroy();
                    if(Region_1.includes(code)) {
                        $('#vmapTH_quan_r1').removeClass('invisible');   
                        $("#Map_Quan_Region_1").removeClass('invisible');   
                        $('#vmapTH_pri_r1').removeClass('invisible');   
                        $("#Map_Pri_Region_1").removeClass('invisible');   
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 1";
                        var myChart_1 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_1 = new Chart(myChart_1, optionData_Region1);
                    }else if(Region_2.includes(code)) {
                        $('#vmapTH_quan_r2').removeClass('invisible');  
                        $("#Map_Quan_Region_2").removeClass('invisible');  
                        $('#vmapTH_pri_r2').removeClass('invisible');  
                        $("#Map_Pri_Region_2").removeClass('invisible'); 
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 2";
                        var myChart_2 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_2 = new Chart(myChart_2, optionData_Region2); 
                    }else if(Region_3.includes(code)) {
                        $('#vmapTH_quan_r3').removeClass('invisible');   
                        $("#Map_Quan_Region_3").removeClass('invisible');   
                        $('#vmapTH_pri_r3').removeClass('invisible');   
                        $("#Map_Pri_Region_3").removeClass('invisible');
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 3";
                        var myChart_3 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_3 = new Chart(myChart_3, optionData_Region3);
                    }else if(Region_4.includes(code)) {
                        $('#vmapTH_quan_r4').removeClass('invisible');  
                        $("#Map_Quan_Region_4").removeClass('invisible');  
                        $('#vmapTH_pri_r4').removeClass('invisible');  
                        $("#Map_Pri_Region_4").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 4";
                        var myChart_4 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_4 = new Chart(myChart_4, optionData_Region4);
                    }else if(Region_5.includes(code)) {
                        $('#vmapTH_quan_r5').removeClass('invisible');  
                        $("#Map_Quan_Region_5").removeClass('invisible');  
                        $('#vmapTH_pri_r5').removeClass('invisible');  
                        $("#Map_Pri_Region_5").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 5";
                        var myChart_5 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_5 = new Chart(myChart_5, optionData_Region5);
                    }else if(Region_6.includes(code)) {
                        $('#vmapTH_quan_r6').removeClass('invisible');  
                        $("#Map_Quan_Region_6").removeClass('invisible'); 
                        $('#vmapTH_pri_r6').removeClass('invisible');  
                        $("#Map_Pri_Region_6").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 6";
                        var myChart_6 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_6 = new Chart(myChart_6, optionData_Region6);
                    }else if(Region_7.includes(code)) {
                        $('#vmapTH_quan_r7').removeClass('invisible');   
                        $("#Map_Quan_Region_7").removeClass('invisible');   
                        $('#vmapTH_pri_r7').removeClass('invisible');   
                        $("#Map_Pri_Region_7").removeClass('invisible');   
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 7";
                        var myChart_7 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_7 = new Chart(myChart_7, optionData_Region7);
                    }else if(Region_8.includes(code)) {
                        $('#vmapTH_quan_r8').removeClass('invisible');  
                        $("#Map_Quan_Region_8").removeClass('invisible');  
                        $('#vmapTH_pri_r8').removeClass('invisible');  
                        $("#Map_Pri_Region_8").removeClass('invisible'); 
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 8";
                        var myChart_8 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_8 = new Chart(myChart_8, optionData_Region8); 
                    }else if(Region_9.includes(code)) {
                        $('#vmapTH_quan_r9').removeClass('invisible');  
                        $("#Map_Quan_Region_9").removeClass('invisible');  
                        $('#vmapTH_pri_r9').removeClass('invisible');  
                        $("#Map_Pri_Region_9").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 9";
                        var myChart_9 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_9 = new Chart(myChart_9, optionData_Region9);
                    }else if(Region_10.includes(code)) {
                        $('#vmapTH_quan_r10').removeClass('invisible');  
                        $("#Map_Quan_Region_10").removeClass('invisible');  
                        $('#vmapTH_pri_r10').removeClass('invisible');  
                        $("#Map_Pri_Region_10").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 10";
                        var myChart_10 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_10 = new Chart(myChart_10, optionData_Region10);
                    }else if(Region_11.includes(code)) {
                        $('#vmapTH_quan_r11').removeClass('invisible');   
                        $("#Map_Quan_Region_11").removeClass('invisible');   
                        $('#vmapTH_pri_r11').removeClass('invisible');   
                        $("#Map_Pri_Region_11").removeClass('invisible');
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 11";   
                        var myChart_11 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_11 = new Chart(myChart_11, optionData_Region11);
                    }else if(Region_12.includes(code)) {
                        $('#vmapTH_quan_r12').removeClass('invisible');  
                        $("#Map_Quan_Region_12").removeClass('invisible');  
                        $('#vmapTH_pri_r12').removeClass('invisible');  
                        $("#Map_Pri_Region_12").removeClass('invisible');  
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 12";
                        var myChart_12 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_12 = new Chart(myChart_12, optionData_Region12);
                    }else if(Region_13.includes(code)) {
                        $('#vmapTH_quan_r13').removeClass('invisible');  
                        $("#Map_Quan_Region_13").removeClass('invisible');  
                        $('#vmapTH_pri_r13').removeClass('invisible');  
                        $("#Map_Pri_Region_13").removeClass('invisible'); 
                        document.getElementById("pp_region").innerHTML = "Acquisition Capability in Region 13";  
                        var myChart_13 = $("#myChart").get(0).getContext("2d");
                        $.massPopChart_13 = new Chart(myChart_13, optionData_Region13);
                    }
                }
            }
            //draw chart TH
            $('#vmapTH_quan').vectorMap($Thai_map_quan)
            $('#vmapTH_pri').vectorMap($Thai_map_pri)
            //draw chart region
            $('#vmapTH_quan_r1').vectorMap($Reg1_map_quan);
            $('#vmapTH_pri_r1').vectorMap($Reg1_map_pri);
            $('#vmapTH_quan_r2').vectorMap($Reg2_map_quan);
            $('#vmapTH_pri_r2').vectorMap($Reg2_map_pri);
            $('#vmapTH_quan_r3').vectorMap($Reg3_map_quan);
            $('#vmapTH_pri_r3').vectorMap($Reg3_map_pri);
            $('#vmapTH_quan_r4').vectorMap($Reg4_map_quan);
            $('#vmapTH_pri_r4').vectorMap($Reg4_map_pri);
            $('#vmapTH_quan_r5').vectorMap($Reg5_map_quan);
            $('#vmapTH_pri_r5').vectorMap($Reg5_map_pri);
            $('#vmapTH_quan_r6').vectorMap($Reg6_map_quan);
            $('#vmapTH_pri_r6').vectorMap($Reg6_map_pri);
            $('#vmapTH_quan_r7').vectorMap($Reg7_map_quan);
            $('#vmapTH_pri_r7').vectorMap($Reg7_map_pri);
            $('#vmapTH_quan_r8').vectorMap($Reg8_map_quan);
            $('#vmapTH_pri_r8').vectorMap($Reg8_map_pri);
            $('#vmapTH_quan_r9').vectorMap($Reg9_map_quan);
            $('#vmapTH_pri_r9').vectorMap($Reg9_map_pri);
            $('#vmapTH_quan_r10').vectorMap($Reg10_map_quan);
            $('#vmapTH_pri_r10').vectorMap($Reg10_map_pri);
            $('#vmapTH_quan_r11').vectorMap($Reg11_map_quan);
            $('#vmapTH_pri_r11').vectorMap($Reg11_map_pri);
            $('#vmapTH_quan_r12').vectorMap($Reg12_map_quan);
            $('#vmapTH_pri_r12').vectorMap($Reg12_map_pri);
            $('#vmapTH_quan_r13').vectorMap($Reg13_map_quan);
            $('#vmapTH_pri_r13').vectorMap($Reg13_map_pri);
            // if(xx == 'High'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'red'});
            // }else if(xx == 'Medium'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': '#ff8f1d'});
            // }else if(xx == 'Low'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': '#4aab57'});
            // }
            $("#backButton").click(function() { 
                $(this).toggleClass("invisible");
                $('#vmapTH_quan').toggleClass("invisible");
                $("#Map_Quan_TH").toggleClass("invisible");
                $('#vmapTH_pri').toggleClass("invisible");
                $("#Map_Pri_TH").toggleClass("invisible");
                $("#Region_To_Size").removeClass("invisible");
                $("#Size_To_Region").removeClass("invisible");
                document.getElementById("pp_region").innerHTML = "Acquisition Capability in Thailand";
                if(!document.getElementById('vmapTH_quan_r1').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r1').classList.contains('invisible')){
                    $('#vmapTH_quan_r1').addClass('invisible');   
                    $('#Map_Quan_Region_1').addClass('invisible');   
                    $('#vmapTH_pri_r1').addClass('invisible');   
                    $('#Map_Pri_Region_1').addClass('invisible'); 
                    $.massPopChart_1.destroy();
                }else if(!document.getElementById('vmapTH_quan_r2').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r2').classList.contains('invisible')){
                    $('#vmapTH_quan_r2').addClass('invisible'); 
                    $('#Map_Quan_Region_2').addClass('invisible'); 
                    $('#vmapTH_pri_r2').addClass('invisible'); 
                    $('#Map_Pri_Region_2').addClass('invisible'); 
                    $.massPopChart_2.destroy();
                }else if(!document.getElementById('vmapTH_quan_r3').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r3').classList.contains('invisible')){
                    $('#vmapTH_quan_r3').addClass('invisible');   
                    $('#Map_Quan_Region_3').addClass('invisible');   
                    $('#vmapTH_pri_r3').addClass('invisible'); 
                    $('#Map_Pri_Region_3').addClass('invisible'); 
                    $.massPopChart_3.destroy();
                }else if(!document.getElementById('vmapTH_quan_r4').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r4').classList.contains('invisible')){
                    $('#vmapTH_quan_r4').addClass('invisible'); 
                    $('#Map_Quan_Region_4').addClass('invisible'); 
                    $('#vmapTH_pri_r4').addClass('invisible'); 
                    $('#Map_Pri_Region_4').addClass('invisible'); 
                    $.massPopChart_4.destroy();
                }else if(!document.getElementById('vmapTH_quan_r5').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r5').classList.contains('invisible')){
                    $('#vmapTH_quan_r5').addClass('invisible'); 
                    $('#Map_Quan_Region_5').addClass('invisible'); 
                    $('#vmapTH_pri_r5').addClass('invisible'); 
                    $('#Map_Pri_Region_5').addClass('invisible'); 
                    $.massPopChart_5.destroy();
                }else if(!document.getElementById('vmapTH_quan_r6').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r6').classList.contains('invisible')){
                    $('#vmapTH_quan_r6').addClass('invisible'); 
                    $('#Map_Quan_Region_6').addClass('invisible'); 
                    $('#vmapTH_pri_r6').addClass('invisible'); 
                    $('#Map_Pri_Region_6').addClass('invisible'); 
                    $.massPopChart_6.destroy();
                }else if(!document.getElementById('vmapTH_quan_r7').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r7').classList.contains('invisible')){
                    $('#vmapTH_quan_r7').addClass('invisible'); 
                    $('#Map_Quan_Region_7').addClass('invisible'); 
                    $('#vmapTH_pri_r7').addClass('invisible'); 
                    $('#Map_Pri_Region_7').addClass('invisible');
                    $.massPopChart_7.destroy(); 
                }else if(!document.getElementById('vmapTH_quan_r8').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r8').classList.contains('invisible')){
                    $('#vmapTH_quan_r8').addClass('invisible');   
                    $('#Map_Quan_Region_8').addClass('invisible');  
                    $('#vmapTH_pri_r8').addClass('invisible');   
                    $('#Map_Pri_Region_8').addClass('invisible'); 
                    $.massPopChart_8.destroy(); 
                }else if(!document.getElementById('vmapTH_quan_r9').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r9').classList.contains('invisible')){
                    $('#vmapTH_quan_r9').addClass('invisible'); 
                    $('#Map_Quan_Region_9').addClass('invisible'); 
                    $('#vmapTH_pri_r9').addClass('invisible'); 
                    $('#Map_Pri_Region_9').addClass('invisible'); 
                    $.massPopChart_9.destroy();
                }else if(!document.getElementById('vmapTH_quan_r10').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r10').classList.contains('invisible')){
                    $('#vmapTH_quan_r10').addClass('invisible'); 
                    $('#Map_Quan_Region_10').addClass('invisible'); 
                    $('#vmapTH_pri_r10').addClass('invisible'); 
                    $('#Map_Pri_Region_10').addClass('invisible'); 
                    $.massPopChart_10.destroy();
                }else if(!document.getElementById('vmapTH_quan_r11').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r11').classList.contains('invisible')){
                    $('#vmapTH_quan_r11').addClass('invisible'); 
                    $('#Map_Quan_Region_11').addClass('invisible'); 
                    $('#vmapTH_pri_r11').addClass('invisible'); 
                    $('#Map_Pri_Region_11').addClass('invisible'); 
                    $.massPopChart_11.destroy();
                }else if(!document.getElementById('vmapTH_quan_r12').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r12').classList.contains('invisible')){
                    $('#vmapTH_quan_r12').addClass('invisible'); 
                    $('#Map_Quan_Region_12').addClass('invisible'); 
                    $('#vmapTH_pri_r12').addClass('invisible'); 
                    $('#Map_Pri_Region_12').addClass('invisible'); 
                    $.massPopChart_12.destroy();
                }else if(!document.getElementById('vmapTH_quan_r13').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r13').classList.contains('invisible')){
                    $('#vmapTH_quan_r13').addClass('invisible'); 
                    $('#Map_Quan_Region_13').addClass('invisible'); 
                    $('#vmapTH_pri_r13').addClass('invisible'); 
                    $('#Map_Pri_Region_13').addClass('invisible'); 
                    $.massPopChart_13.destroy();
                } 
                $.massPopChart = new Chart(myChart, optionData);      
            });
            $("#backButton2").click(function() { 
                $('#Province_Donut').addClass('invisible');  
                $('#Table_Hos_by_Province').addClass('invisible');  
                $('#corr_chart').addClass('invisible');  
                $('#Price_by_Region').removeClass('invisible');   
                $("#Quantity_by_Region").removeClass('invisible');  
                $("#Quantity_by_Region").removeClass('invisible');  
                $("#Stack_Bar").removeClass('invisible'); 
            });
            // END Region ///////////////////
        });
    </script>
    <style>
        #backButton {
            border-radius: 4px;
            padding: 8px;
            border: none;
            font-size: 16px;
            background-color: #2eacd1;
            color: white;
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
        }
        #backButton2 {
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
            // border: 3px solid #73AD21;
            padding: 10px;
        }
    </style>
    <div class="row">
        
        <div class="col-md-12 col-lg-12 invisible" id = 'Province_Donut'>
            <div class="card">
                <div class="card-body">
                    <button class="btn" id="backButton2" style="background-color:#00aaee; color:white;">&lt; Drill Up</button>
                    <h4 class="card-title" id="Title_Donut" style="color:black; text-align:center;"></h4>
                    <div class='row center' >
                        <div id="purchasing_power_donut" class="mt-2 col-md-6 center" style="height:283px; width:60%;"></div>
                        <div class="col-md-5 center">
                            <i class="fas fa-circle font-10 mr-2" style="color:#4aab57;"></i>
                            <span class="text-muted" >Above Average PAC</span>
                            <br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#ff8f1d;"></i>
                            <span class="text-muted" >Average PAC = {{ $avg }} </span>
                            <br/>
                            <i class="fas fa-circle font-10 mr-2" style="color:#cf2620;"></i>
                            <span class="text-muted" >Below Average PAC</span>
                        </div>
                    </div>
                    <p style="font-size:14px;">*Acquisition Capability is calculated from PAC value</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 invisible" id = 'Table_Hos_by_Province'>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title" style="text-align:center; color:black;">List of Hospital</h3>
                    <br/>
                    <table class="table-white table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                        <thead>
                        <tr role="row">
                            <th style="text-align:center;">ID</th>
                            <th style="text-align:center;">Name</th>
                            <th style="text-align:center;">Type</th>
                            <th style="text-align:center;">IP</th>
                            <th style="text-align:center;">OP</th>
                            <th style="text-align:center;">Wavg Unit Price</th>
                            <th style="text-align:center;">Quantity</th>
                            <th style="text-align:center;">Total Spend</th>
                            <th style="text-align:center;">PAC</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 invisible" id ='corr_chart'>
            <div class="card col-lg-12">
                <div class="card-body">
                    <div style="margin:auto;">
                        <h3 class="card-title" style="text-align:center; color:black;">Purchasing Quantity VS Number of Patient</h3>
                        <div id='corr' style="width: 100%; height: 350px;"></div>
                    </div>
                    <br>
                    <div class="row col-md-12" style="margin:auto;">
                        <span style="color:black; font-size:16px; margin:auto; padding-left:20px;">Correlation</span>
                        <div class="card" id="total_corr_bg" style="margin:auto; padding-left:10px; padding-right:10px; background-color:#74d680;">
                            <span id="total_corr" style="color:black; font-size:16px;"></span>
                        </div>
                        <span id="total_corr_label" style="margin:auto; padding-right:20px; color:black; font-size:16px;"></span>
                    </div>
                    
                   
                </div>
            </div>
        </div>

    </div>
    <?php
    }
    ?>

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@stop

@section('scripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "sScrollX": "100%",
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
                "rowCallback": function(row, data, index) {
                    if(data[8]> 0.5){
                        $(row).find('td:eq(8)').css('color', 'red');
                    }
                }
            });
        });
    </script>
@endsection
