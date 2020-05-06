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
            // For WHole Country Chart Option ///////////////////////////////////////////
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
                }
            };
            //// For Region 1 Chart Option ///////////////////////////////////////////
            var optionData_Region1 = [{
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
            
            // function ChartDrilldownHandler_Region(e) {
            //     // alert('hi');
            //     // alert(e);
            //     var a = 1;
            //     if( a == 1){
            //         let chartR = new Chart(myChart, optionData_Region[0]);
            //         // chartR.render();
            //         // document.getElementById('backButton').style.display = 'show';
            //         // $("#backButton").toggleClass("visible");
            //     }
            //     // chart.render();
                
            // }
    </script>
    <!-- *************************************************************** -->
    <!-- END 100% stacked bar chart -->
    <!-- *************************************************************** -->
  

    <script>
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
        // var coll = {"TH-30":"purple","TH-20":"yellow"};
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
        
        $(document).ready(function() {
            $Reg1_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg1_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg2_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg2_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg3_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg3_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg4_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg4_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg5_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg5_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg6_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg6_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg7_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg7_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg8_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg8_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg9_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg9_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {

                }
            }
            $Reg10_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg10_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg11_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg11_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg12_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg12_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
            $Reg13_map_pri = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverColor: 'black',
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg13_pri,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial',
                onRegionClick: function (element, code, region) {
                }
            }
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
                        document.getElementById("your_h1_id").innerHTML = "your new text here"    
                    }
                },
                onRegionClick: function (element, code, region) {
                    $("#backButton").toggleClass("invisible");
                    $('#vmapTH_quan').toggleClass("invisible");
                    $("#Map_Quan_TH").toggleClass("invisible");
                    $('#vmapTH_pri').toggleClass("invisible");
                    $("#Map_Pri_TH").toggleClass("invisible");
                    if(Region_1.includes(code)) {
                        $('#vmapTH_quan_r1').removeClass('invisible');   
                        $("#Map_Quan_Region_1").removeClass('invisible');   
                        $('#vmapTH_pri_r1').removeClass('invisible');   
                        $("#Map_Pri_Region_1").removeClass('invisible');   
                    }else if(Region_2.includes(code)) {
                        $('#vmapTH_quan_r2').removeClass('invisible');  
                        $("#Map_Quan_Region_2").removeClass('invisible');  
                        $('#vmapTH_pri_r2').removeClass('invisible');  
                        $("#Map_Pri_Region_2").removeClass('invisible');  
                    }else if(Region_3.includes(code)) {
                        $('#vmapTH_quan_r3').removeClass('invisible');   
                        $("#Map_Quan_Region_3").removeClass('invisible');   
                        $('#vmapTH_pri_r3').removeClass('invisible');   
                        $("#Map_Pri_Region_3").removeClass('invisible');   
                    }else if(Region_4.includes(code)) {
                        $('#vmapTH_quan_r4').removeClass('invisible');  
                        $("#Map_Quan_Region_4").removeClass('invisible');  
                        $('#vmapTH_pri_r4').removeClass('invisible');  
                        $("#Map_Pri_Region_4").removeClass('invisible');  
                    }else if(Region_5.includes(code)) {
                        $('#vmapTH_quan_r5').removeClass('invisible');  
                        $("#Map_Quan_Region_5").removeClass('invisible');  
                        $('#vmapTH_pri_r5').removeClass('invisible');  
                        $("#Map_Pri_Region_5").removeClass('invisible');  
                    }else if(Region_6.includes(code)) {
                        $('#vmapTH_quan_r6').removeClass('invisible');  
                        $("#Map_Quan_Region_6").removeClass('invisible'); 
                        $('#vmapTH_pri_r6').removeClass('invisible');  
                        $("#Map_Pri_Region_6").removeClass('invisible');  
                    }else if(Region_7.includes(code)) {
                        $('#vmapTH_quan_r7').removeClass('invisible');   
                        $("#Map_Quan_Region_7").removeClass('invisible');   
                        $('#vmapTH_pri_r7').removeClass('invisible');   
                        $("#Map_Pri_Region_7").removeClass('invisible');   
                    }else if(Region_8.includes(code)) {
                        $('#vmapTH_quan_r8').removeClass('invisible');  
                        $("#Map_Quan_Region_8").removeClass('invisible');  
                        $('#vmapTH_pri_r8').removeClass('invisible');  
                        $("#Map_Pri_Region_8").removeClass('invisible');  
                    }else if(Region_9.includes(code)) {
                        $('#vmapTH_quan_r9').removeClass('invisible');  
                        $("#Map_Quan_Region_9").removeClass('invisible');  
                        $('#vmapTH_pri_r9').removeClass('invisible');  
                        $("#Map_Pri_Region_9").removeClass('invisible');  
                    }else if(Region_10.includes(code)) {
                        $('#vmapTH_quan_r10').removeClass('invisible');  
                        $("#Map_Quan_Region_10").removeClass('invisible');  
                        $('#vmapTH_pri_r10').removeClass('invisible');  
                        $("#Map_Pri_Region_10").removeClass('invisible');  
                    }else if(Region_11.includes(code)) {
                        $('#vmapTH_quan_r11').removeClass('invisible');   
                        $("#Map_Quan_Region_11").removeClass('invisible');   
                        $('#vmapTH_pri_r11').removeClass('invisible');   
                        $("#Map_Pri_Region_11").removeClass('invisible');   
                    }else if(Region_12.includes(code)) {
                        $('#vmapTH_quan_r12').removeClass('invisible');  
                        $("#Map_Quan_Region_12").removeClass('invisible');  
                        $('#vmapTH_pri_r12').removeClass('invisible');  
                        $("#Map_Pri_Region_12").removeClass('invisible');  
                    }else if(Region_13.includes(code)) {
                        $('#vmapTH_quan_r13').removeClass('invisible');  
                        $("#Map_Quan_Region_13").removeClass('invisible');  
                        $('#vmapTH_pri_r13').removeClass('invisible');  
                        $("#Map_Pri_Region_13").removeClass('invisible');   
                    }
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////
            //---------------------------------------------------------------------------------//
            ////////// for quantity /////////////////////////////////////////////////////////////
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
                }
            }
            $Reg2_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg2_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg3_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg3_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg4_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg4_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg5_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg5_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg6_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg6_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg7_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg7_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg8_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg8_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg9_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg9_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg10_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg10_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg11_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg11_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg12_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg12_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }
            $Reg13_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                color: '#ffffff',
                values: reg13_quan,
                scaleColors: ['#C8EEFF', '#006491'],
                normalizeFunction: 'polynomial'
            }

            $Thai_map_quan = {
                map: ['thai_en'],
                backgroundColor: 'beige',
                hoverOpacity: 0.7,
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
                    if(Region_1.includes(code)) {
                        $('#vmapTH_quan_r1').removeClass('invisible');   
                        $("#Map_Quan_Region_1").removeClass('invisible');   
                        $('#vmapTH_pri_r1').removeClass('invisible');   
                        $("#Map_Pri_Region_1").removeClass('invisible');   
                    }else if(Region_2.includes(code)) {
                        $('#vmapTH_quan_r2').removeClass('invisible');  
                        $("#Map_Quan_Region_2").removeClass('invisible');  
                        $('#vmapTH_pri_r2').removeClass('invisible');  
                        $("#Map_Pri_Region_2").removeClass('invisible');  
                    }else if(Region_3.includes(code)) {
                        $('#vmapTH_quan_r3').removeClass('invisible');   
                        $("#Map_Quan_Region_3").removeClass('invisible');   
                        $('#vmapTH_pri_r3').removeClass('invisible');   
                        $("#Map_Pri_Region_3").removeClass('invisible');   
                    }else if(Region_4.includes(code)) {
                        $('#vmapTH_quan_r4').removeClass('invisible');  
                        $("#Map_Quan_Region_4").removeClass('invisible');  
                        $('#vmapTH_pri_r4').removeClass('invisible');  
                        $("#Map_Pri_Region_4").removeClass('invisible');  
                    }else if(Region_5.includes(code)) {
                        $('#vmapTH_quan_r5').removeClass('invisible');  
                        $("#Map_Quan_Region_5").removeClass('invisible');  
                        $('#vmapTH_pri_r5').removeClass('invisible');  
                        $("#Map_Pri_Region_5").removeClass('invisible');  
                    }else if(Region_6.includes(code)) {
                        $('#vmapTH_quan_r6').removeClass('invisible');  
                        $("#Map_Quan_Region_6").removeClass('invisible'); 
                        $('#vmapTH_pri_r6').removeClass('invisible');  
                        $("#Map_Pri_Region_6").removeClass('invisible');  
                    }else if(Region_7.includes(code)) {
                        $('#vmapTH_quan_r7').removeClass('invisible');   
                        $("#Map_Quan_Region_7").removeClass('invisible');   
                        $('#vmapTH_pri_r7').removeClass('invisible');   
                        $("#Map_Pri_Region_7").removeClass('invisible');   
                    }else if(Region_8.includes(code)) {
                        $('#vmapTH_quan_r8').removeClass('invisible');  
                        $("#Map_Quan_Region_8").removeClass('invisible');  
                        $('#vmapTH_pri_r8').removeClass('invisible');  
                        $("#Map_Pri_Region_8").removeClass('invisible');  
                    }else if(Region_9.includes(code)) {
                        $('#vmapTH_quan_r9').removeClass('invisible');  
                        $("#Map_Quan_Region_9").removeClass('invisible');  
                        $('#vmapTH_pri_r9').removeClass('invisible');  
                        $("#Map_Pri_Region_9").removeClass('invisible');  
                    }else if(Region_10.includes(code)) {
                        $('#vmapTH_quan_r10').removeClass('invisible');  
                        $("#Map_Quan_Region_10").removeClass('invisible');  
                        $('#vmapTH_pri_r10').removeClass('invisible');  
                        $("#Map_Pri_Region_10").removeClass('invisible');  
                    }else if(Region_11.includes(code)) {
                        $('#vmapTH_quan_r11').removeClass('invisible');   
                        $("#Map_Quan_Region_11").removeClass('invisible');   
                        $('#vmapTH_pri_r11').removeClass('invisible');   
                        $("#Map_Pri_Region_11").removeClass('invisible');   
                    }else if(Region_12.includes(code)) {
                        $('#vmapTH_quan_r12').removeClass('invisible');  
                        $("#Map_Quan_Region_12").removeClass('invisible');  
                        $('#vmapTH_pri_r12').removeClass('invisible');  
                        $("#Map_Pri_Region_12").removeClass('invisible');  
                    }else if(Region_13.includes(code)) {
                        $('#vmapTH_quan_r13').removeClass('invisible');  
                        $("#Map_Quan_Region_13").removeClass('invisible');  
                        $('#vmapTH_pri_r13').removeClass('invisible');  
                        $("#Map_Pri_Region_13").removeClass('invisible');   
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
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'yellow'});
            // }else if(xx == 'Low'){
            //     $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'green'});
            // }
            $("#backButton").click(function() { 
                $(this).toggleClass("invisible");
                $('#vmapTH_quan').toggleClass("invisible");
                $("#Map_Quan_TH").toggleClass("invisible");
                $('#vmapTH_pri').toggleClass("invisible");
                $("#Map_Pri_TH").toggleClass("invisible");
                
                if(!document.getElementById('vmapTH_quan_r1').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r1').classList.contains('invisible')){
                    $('#vmapTH_quan_r1').addClass('invisible');   
                    $('#Map_Quan_Region_1').addClass('invisible');   
                    $('#vmapTH_pri_r1').addClass('invisible');   
                    $('#Map_Pri_Region_1').addClass('invisible');     
                }else if(!document.getElementById('vmapTH_quan_r2').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r2').classList.contains('invisible')){
                    $('#vmapTH_quan_r2').addClass('invisible'); 
                    $('#Map_Quan_Region_2').addClass('invisible'); 
                    $('#vmapTH_pri_r2').addClass('invisible'); 
                    $('#Map_Pri_Region_2').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r3').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r3').classList.contains('invisible')){
                    $('#vmapTH_quan_r3').addClass('invisible');   
                    $('#Map_Quan_Region_3').addClass('invisible');   
                    $('#vmapTH_pri_r3').addClass('invisible'); 
                    $('#Map_Pri_Region_3').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r4').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r4').classList.contains('invisible')){
                    $('#vmapTH_quan_r4').addClass('invisible'); 
                    $('#Map_Quan_Region_4').addClass('invisible'); 
                    $('#vmapTH_pri_r4').addClass('invisible'); 
                    $('#Map_Pri_Region_4').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r5').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r5').classList.contains('invisible')){
                    $('#vmapTH_quan_r5').addClass('invisible'); 
                    $('#Map_Quan_Region_5').addClass('invisible'); 
                    $('#vmapTH_pri_r5').addClass('invisible'); 
                    $('#Map_Pri_Region_5').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r6').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r6').classList.contains('invisible')){
                    $('#vmapTH_quan_r6').addClass('invisible'); 
                    $('#Map_Quan_Region_6').addClass('invisible'); 
                    $('#vmapTH_pri_r6').addClass('invisible'); 
                    $('#Map_Pri_Region_6').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r7').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r7').classList.contains('invisible')){
                    $('#vmapTH_quan_r7').addClass('invisible'); 
                    $('#Map_Quan_Region_7').addClass('invisible'); 
                    $('#vmapTH_pri_r7').addClass('invisible'); 
                    $('#Map_Pri_Region_7').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r8').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r8').classList.contains('invisible')){
                    $('#vmapTH_quan_r8').addClass('invisible');   
                    $('#Map_Quan_Region_8').addClass('invisible');  
                    $('#vmapTH_pri_r8').addClass('invisible');   
                    $('#Map_Pri_Region_8').addClass('invisible');  
                }else if(!document.getElementById('vmapTH_quan_r9').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r9').classList.contains('invisible')){
                    $('#vmapTH_quan_r9').addClass('invisible'); 
                    $('#Map_Quan_Region_9').addClass('invisible'); 
                    $('#vmapTH_pri_r9').addClass('invisible'); 
                    $('#Map_Pri_Region_9').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r10').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r10').classList.contains('invisible')){
                    $('#vmapTH_quan_r10').addClass('invisible'); 
                    $('#Map_Quan_Region_10').addClass('invisible'); 
                    $('#vmapTH_pri_r10').addClass('invisible'); 
                    $('#Map_Pri_Region_10').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r11').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r11').classList.contains('invisible')){
                    $('#vmapTH_quan_r11').addClass('invisible'); 
                    $('#Map_Quan_Region_11').addClass('invisible'); 
                    $('#vmapTH_pri_r11').addClass('invisible'); 
                    $('#Map_Pri_Region_11').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r12').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r12').classList.contains('invisible')){
                    $('#vmapTH_quan_r12').addClass('invisible'); 
                    $('#Map_Quan_Region_12').addClass('invisible'); 
                    $('#vmapTH_pri_r12').addClass('invisible'); 
                    $('#Map_Pri_Region_12').addClass('invisible'); 
                }else if(!document.getElementById('vmapTH_quan_r13').classList.contains('invisible') || !document.getElementById('vmapTH_pri_r13').classList.contains('invisible')){
                    $('#vmapTH_quan_r13').addClass('invisible'); 
                    $('#Map_Quan_Region_13').addClass('invisible'); 
                    $('#vmapTH_pri_r13').addClass('invisible'); 
                    $('#Map_Pri_Region_13').addClass('invisible'); 
                }         
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
        <div class="col-md-7 col-lg-6" id = 'Price by Region'>
            <div class="card">
                <div class="card-body">
                    <h1>Price by region</h1>
                    <button class="btn invisible" id="backButton">&lt; Drill Up</button>
                    test if click at any Region chart will drill down
                    <div class='row'>
                        <div id="vmapTH_pri" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r1" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r2" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r3" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r4" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r5" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r6" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r7" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r8" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r9" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r10" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r11" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r12" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_pri_r13" style="width: 200px; height: 300px;"></div>

                        <div id="Map_Pri_TH">
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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg1[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_2">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg2[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_3">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg3[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_4">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg4[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_5">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg5[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_6">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg6[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_7">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg7[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_8">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i = 0; $i < count($resultThaiMap_Reg8); $i++){
                                    ?>
                                        <tr>
                                            <td style="text-align:center;">{{ $resultThaiMap_Reg8[$i]->PROVINCE_EN }}</td>  
                                            <?php
                                            if ($resultThaiMap_Reg8[$i]->wavg_unit_price != NULL){
                                            ?>
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg8[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_9">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg9[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_10">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg10[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_11">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg11[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_12">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg12[$i]->wavg_unit_price }}</td>

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
                        <div class = "invisible" id="Map_Pri_Region_13">
                            <table class="table-white table-striped" role="grid" aria-describedby="default_order_info">
                                <thead>
                                <tr role="row">
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">wavg unit price</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg13[$i]->wavg_unit_price }}</td>

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
                    </div>
                    test if hover at Chaing new text will show up
                    <div><h1 id="your_h1_id"></h1></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-6" id = 'Quantity by Region'>
            <div class="card">
                <div class="card-body">
                    <h1>Quantity by region</h1>
                    <div class='row'>
                        <div id="vmapTH_quan" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r1" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r2" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r3" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r4" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r5" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r6" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r7" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r8" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r9" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r10" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r11" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r12" style="width: 200px; height: 300px;"></div>
                        <div class = "invisible" id="vmapTH_quan_r13" style="width: 200px; height: 300px;"></div>

                        <div id="Map_Quan_TH">
                            <table class="table-white table-striped" ole="grid" aria-describedby="default_order_info">
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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg2[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg3[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg4[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg5[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg6[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg7[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i = 0; $i < count($resultThaiMap_Reg8); $i++){
                                    ?>
                                        <tr>
                                            <td style="text-align:center;">{{ $resultThaiMap_Reg8[$i]->PROVINCE_EN }}</td>  
                                            <?php
                                            if ($resultThaiMap_Reg8[$i]->Total_Amount != NULL){
                                            ?>
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg8[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg9[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg10[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg11[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg12[$i]->Total_Amount }}</td>

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
                                    <th style="text-align:center;">Province</th>
                                    <th style="text-align:center;">Quantity</th>
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
                                                <td style="text-align:right;">{{ $resultThaiMap_Reg13[$i]->Total_Amount }}</td>

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
