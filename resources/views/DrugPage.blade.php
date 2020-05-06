@extends('layouts/admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
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
                        <button type="submit">Submit</button>
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
        if($resultSearch != 'No value'){
        ?>
            <div class="card-body">

            <table class="table-white table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                <thead>
                <tr role="row">
                    <!-- <th>BUDGET YEAR</th> -->
                    <!-- <th>Method</th> -->
                    <th>GPU ID</th>
                    <th>GPU NAME</th>
                    <th>TPU ID</th>
                    <th>TPU NAME</th>
                    <th>Total Amount</th>
                    <th>wavg unit price</th>
                    <th>Total Spend</th>
                    <th>Gini</th>
                </tr>
                </thead>
                <tbody>
                <div>
                    Result : {{ $resultState }}
                    <br/>
                    Found result : {{ count($resultSearch) }} values
                </div>
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
                        <td style="text-align:center;">{{ $resultSearch[$i]->Total_Amount }}</td>  
                        <td style="text-align:center;">{{ $resultSearch[$i]->wavg_unit_price }}</td>
                        <td style="text-align:center;">{{ $resultSearch[$i]->Total_Spend }}</td>
                        <?php
                        if ($resultSearch[$i]->Gini != NULL){
                        ?>
                            <td style="text-align:center;">{{ $resultSearch[$i]->Gini }}</td>

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
        }else{
        ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <th>No data</th>
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
    if(!empty($resultSearch) && $resultSearch != 'No value'){
    ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a class="customize-input float-right" href="/policy/DrugPage/SizeHospital">
                    Region -> Size of hospital
                </a>
                <?php
                if(isset($chartHighPercent) || isset($chartMedPercent) || isset($chartLowPercent)){
                ?>
                    <canvas id="myChart"></canvas>
                <?php
                }else{
                ?>
                    <canvas id="myChart">No Data</canvas>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script>
            //// For WHole Country Chart Option ///////////////////////////////////////////
            var optionData = {
                name: "Whole Country",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['Region1', 'Region2', 'Region3', 'Region4', 'Region5', 'Region6'
                        ,'Region7', 'Region8', 'Region9', 'Region10', 'Region11', 'Region12', 'Region13'],
                    datasets:[
                    {
                        label:'Low Purchasing Power',
                        data: [{{ $chartLowPercent[0] }}, {{ $chartLowPercent[1] }}, {{ $chartLowPercent[2] }},
                            {{ $chartLowPercent[3] }}, {{ $chartLowPercent[4] }}, {{ $chartLowPercent[5] }},
                            {{ $chartLowPercent[6] }}, {{ $chartLowPercent[7] }}, {{ $chartLowPercent[8] }},
                            {{ $chartLowPercent[9] }}, {{ $chartLowPercent[10] }}, {{ $chartLowPercent[11] }},
                            {{ $chartLowPercent[12] }}],
                        backgroundColor:'green',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Medium Purchasing Power',
                        data: [ {{ $chartMedPercent[0] }} , {{ $chartMedPercent[1] }}, {{ $chartMedPercent[2] }},
                            {{ $chartMedPercent[3] }}, {{ $chartMedPercent[4] }}, {{ $chartMedPercent[5] }},
                            {{ $chartMedPercent[6] }}, {{ $chartMedPercent[7] }}, {{ $chartMedPercent[8] }},
                            {{ $chartMedPercent[9] }}, {{ $chartMedPercent[10] }}, {{ $chartMedPercent[11] }},
                            {{ $chartMedPercent[12] }}],
                        backgroundColor:'yellow',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'High Purchasing Power',
                        data:[{{ $chartHighPercent[0] }}, {{ $chartHighPercent[1] }}, {{ $chartHighPercent[2] }},
                            {{ $chartHighPercent[3] }}, {{ $chartHighPercent[4] }}, {{ $chartHighPercent[5] }},
                            {{ $chartHighPercent[6] }}, {{ $chartHighPercent[7] }}, {{ $chartHighPercent[8] }},
                            {{ $chartHighPercent[9] }}, {{ $chartHighPercent[10] }}, {{ $chartHighPercent[11] }},
                            {{ $chartHighPercent[12] }}],
                        backgroundColor:'red',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    title:{
                        display:true,
                        text:'Purchasing Power in Thailand',
                        fontSize:25,
                    },
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
                    },
                    onClick: ChartDrilldownHandler_Region,
                    cursor: "pointer",
                    explodeOnClick: false
                }
            };
            //// For RegionChart Option ///////////////////////////////////////////
            var optionData_Region = [{
                name: "Region 1",
                type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['Region1', 'Region2', 'Region3', 'Region4', 'Region5', 'Region6'
                        ,'Region7', 'Region8'],
                    datasets:[
                    {
                        label:'Low Purchasing Power',
                        data: [{{ $chartLowPercent[0] }}, {{ $chartLowPercent[1] }}, {{ $chartLowPercent[2] }},
                            {{ $chartLowPercent[3] }}, {{ $chartLowPercent[4] }}, {{ $chartLowPercent[5] }},
                            {{ $chartLowPercent[6] }}, {{ $chartLowPercent[7] }}],
                        backgroundColor:'green',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },
                    {
                        label:'Medium Purchasing Power',
                        data: [ {{ $chartMedPercent[0] }} , {{ $chartMedPercent[1] }}, {{ $chartMedPercent[2] }},
                            {{ $chartMedPercent[3] }}, {{ $chartMedPercent[4] }}, {{ $chartMedPercent[5] }},
                            {{ $chartMedPercent[6] }}, {{ $chartMedPercent[7] }}],
                        backgroundColor:'yellow',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    },{
                        label:'High Purchasing Power',
                        data:[{{ $chartHighPercent[0] }}, {{ $chartHighPercent[1] }}, {{ $chartHighPercent[2] }},
                            {{ $chartHighPercent[3] }}, {{ $chartHighPercent[4] }}, {{ $chartHighPercent[5] }},
                            {{ $chartHighPercent[6] }}, {{ $chartHighPercent[7] }}],
                        backgroundColor:'red',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }],
                },
                options:{
                    title:{
                        display:true,
                        text:'Purchasing Power in Region 1',
                        fontSize:25,
                    },
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
                // click: ChartDrilldownHandler_Region,
                // cursor: "pointer",
                // explodeOnClick: false
            }];
            ////////// generate chart ////////////////////////////////////////
            let myChart = document.getElementById('myChart').getContext('2d');
            let massPopChart = new Chart(myChart, optionData);
            // massPopChart.render();
            
            function ChartDrilldownHandler_Region(e) {
                // alert('hi');
                // alert(e);
                var a = 1;
                if( a == 1){
                    let chartR = new Chart(myChart, optionData_Region[0]);
                    // chartR.render();
                    document.getElementById('backButton').style.display = 'show';
                    // $("#backButton").toggleClass("visible");
                }
                // chart.render();
                
            }
    <!-- *************************************************************** -->
    <!-- END 100% stacked bar chart -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Start Thai Map -->
    <!-- *************************************************************** -->
        // var coll = {"TH-30":"purple","TH-20":"yellow"};
        ////////////// TH ////////////////////
        var data_sets_pri = {!! json_encode($pri_array_all) !!};
        var data_sets_quan = {!! json_encode($quan_array_all) !!};
        ////////////// Region 1 //////////////
        var reg1_quan = {!! json_encode($quan_array_r1) !!};
        
        $(document).ready(function() {
            $Thai_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                // hoverOpacity: 0.7,
                //color when hover on to the map (if use with hoverOpacity, มันจะมองไม่ค่อยออกว่าสีไร จะแค่แบบจางๆ แบบลดopacity ของสีแมป)
                hoverColor: 'black',
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
                onRegionOver: function (event, code, region) {
                    //sample to interact with map
                    if (code == 'TH-50') {
                        // document.getElementById("vmapTH").style.background = "purple";
                        
                        // alert("You hover "+region);
                        // event.preventDefault();
                        document.getElementById("your_h1_id").innerHTML = "your new text here"    
                    }
                },
                onRegionClick: function (element, code, region) {
                    //sample to interact with map
                    // var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                    // alert(message);

                }
            }
            //draw chart
            $('#vmapTH_pri').vectorMap($Thai_map_pri)

            ////////// for quantity ////////////////////////////////////////////////////////////
            $Reg1_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg1_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                // colors: color_sets,      
                onRegionClick: function (element, code, region) {
                    //sample to interact with map
                    // var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                    // alert(message);
                    if (code == 'TH-50') {
                        $('#vmapTH_quan').toggleClass('invisible');
                        $('#vmapTH_quan2').toggleClass('invisible');
                        $("#backButton").toggleClass("invisible");
                        $('#vmapTH_quan2').vectorMap($Thai_map_quan);
                    }
                }
            }
            $Thai_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: data_sets_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                // colors: color_sets,      
                onLabelShow: function(event, label, code)
                {

                },
                onRegionOver: function (event, code, region) {
                    //sample to interact with map
                    if (code == 'TH-50') {
                        // document.getElementById("vmapTH").style.background = "purple";
                        
                        // alert("You hover "+region);
                        // event.preventDefault();
                    }
                },
                onRegionClick: function (element, code, region) {
                    //sample to interact with map
                    // var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                    // alert(message);
                    if (code == 'TH-50') {
                        $('#vmapTH_quan').toggleClass('invisible');
                        $('#vmapTH_quan_r1').toggleClass('invisible');
                        $("#backButton").toggleClass("invisible");
                        $("#Map_Quan_TH").toggleClass("invisible");
                        $("#Map_Quan_Region_1").toggleClass("invisible");
                        $('#vmapTH_quan_r1').vectorMap($Reg1_map_quan);
                    }
                }
            }
            //draw chart quantity
            $('#vmapTH_quan').vectorMap($Thai_map_quan)
            // if(xx == 'High'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'red'});
            // }else if(xx == 'Medium'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'yellow'});
            // }else if(xx == 'Low'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'green'});
            // }
            $("#backButton").click(function() { 
                $(this).toggleClass("invisible");
                $('#vmapTH_quan').toggleClass('invisible');
                $('#vmapTH_quan_r1').toggleClass('invisible');
                $("#Map_Quan_TH").toggleClass("invisible");
                $("#Map_Quan_Region_1").toggleClass("invisible");
            });
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
            right: 10px;
            cursor: pointer;
        }
        .invisible {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-md-7 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1>Price by region</h1>
                    <div class='row'>
                    <div id="vmapTH_pri" style="width: 200px; height: 300px;"></div>
                    <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                        <thead>
                        <tr role="row">
                            <th style="text-align:center;">Region</th>
                            <th style="text-align:center;">wavg unit price</th>
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
                                        <td style="text-align:right;">{{ $resultThaiMap[$i]->wavg_unit_price }}</td>

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
                    test if hover at Chaing new text will show up
                    <div><h1 id="your_h1_id"></h1></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1>Quantity by region</h1>
                    <button class="btn invisible" id="backButton">&lt; Back</button>
                    test if click at Chaing Mai new chart will show up
                    <div class='row'>
                    <div id="vmapTH_quan" style="width: 200px; height: 300px;"></div>
                    <div class='invisible' id="vmapTH_quan_r1" style="width: 200px; height: 300px;"></div>
                    <table class="table-white table-striped" id = "Map_Quan_TH" ole="grid" aria-describedby="default_order_info">
                        <thead>
                        <tr role="row">
                            <th style="text-align:center;">Region</th>
                            <th style="text-align:center;">Quantity</th>
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
                                        <td style="text-align:right;">{{ $resultThaiMap[$i]->Total_Amount }}</td>

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
                    
                    <table class="table-white table-striped invisible" id = "Map_Quan_Region_1" ole="grid" aria-describedby="default_order_info">
                        <thead>
                        <tr role="row">
                            <th style="text-align:center;">Province</th>
                            <th style="text-align:center;">Quantity</th>
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
                                        <td style="text-align:right;">{{ $resultThaiMap_Reg1[$i]->Total_Amount }}</td>

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
    <!-- *************************************************************** -->
    <!-- End Thai Map -->
    <!-- *************************************************************** -->
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
                    if(data[7]> 0.5){
                        $(row).find('td:eq(7)').css('color', 'red');
                    }
                }
            });
        });
    </script>
@endsection
