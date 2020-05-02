@extends('layouts/admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('scripts')
<!-- 100%-stack bar chart -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- <script src="{{ asset('dist/js/chartStacked.js') }}"></script> -->
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
                <table class="table-cyan table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
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
                </table>
                </tbody>
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
                <?php
                if(isset($chartHighPercent)){
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
            let myChart = document.getElementById('myChart').getContext('2d');
            let massPopChart = new Chart(myChart, {
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels:['Region1', 'Region2', 'Region3', 'Region4', 'Region5', 'Region6'
                    ,'Region7', 'Region8', 'Region9', 'Region10', 'Region11', 'Region12', 'Region13'],
                datasets:[
                    {
                    label:'Low',
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
                    label:'Medium',
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
                    label:'High',
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
                }]
            },
            options:{
                title:{
                    display:true,
                    text:'Purchasing Power in Thailand',
                    fontSize:25
                },
                scales: {
                    xAxes: [{ stacked: true }],
                    yAxes: [{ stacked: true }]
                },
                legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000'
                    }
                },
                layout:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                    },
                    tooltips:{
                    enabled:true
                }
            }
            });    
    </script>
    <!-- *************************************************************** -->
    <!-- END 100% stacked bar chart -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Start Thai Map -->
    <!-- *************************************************************** -->
    <script>
        xx='Low';
        var colors_set = {"TH-30":"purple","TH-20":"yellow"};
        $(document).ready(function() {
            $xxx = {
                map: ['thai_en'],
                backgroundColor: 'pink',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                scaleColors: ['#C8EEFF', '#006491'],
                colors: colors_set,
                onRegionOver: function (event, code, region) {
                    //sample to interact with map
                    if (code == 'TH-50') {
                        document.getElementById("vmapTH").style.background = "purple";
                        
                        alert("You hover "+region);
                        event.preventDefault();
                    }
                },
                onRegionClick: function (element, code, region) {
                    //sample to interact with map
                    var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                    alert(message);
                }
            }
            $('#vmapTH').vectorMap($xxx)
            if(xx == 'High'){
                $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'red'});
            }else if(xx == 'Medium'){
                $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'yellow'});
            }else if(xx == 'Low'){
                $('#vmapTH').vectorMap('set', 'colors', {'TH-50': 'green'});
            }
        });
    </script>

    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h1>Hello</h1>
                    <div id="vmapTH" style="width: 600px; height: 400px; background-color:yellow;"></div>
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
    
    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Earning Statistics</h4>
                        <div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                                <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                    id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                    <a class="dropdown-item" href="#">Insert</a>
                                    <a class="dropdown-item" href="#">Update</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-4 mb-5">
                        <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Activity</h4>
                    <div class="mt-4 activity">
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                    <i data-feather="shopping-cart"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">New Product Sold!</h5>
                                <p class="font-14 mb-2 text-muted">John Musa just purchased <br> Cannon 5M
                                    Camera.
                                </p>
                                <span class="font-weight-light font-14 text-muted">10 Minutes Ago</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)"
                                    class="btn btn-danger btn-circle mb-2 btn-item">
                                    <i data-feather="message-square"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">New Support Ticket</h5>
                                <p class="font-14 mb-2 text-muted">Richardson just create support <br>
                                    ticket</p>
                                <span class="font-weight-light font-14 text-muted">25 Minutes Ago</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                    <i data-feather="bell"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">Notification Pending Order!
                                </h5>
                                <p class="font-14 mb-2 text-muted">One Pending order from Ryne <br> Doe</p>
                                <span class="font-weight-light font-14 mb-1 d-block text-muted">2 Hours
                                    Ago</span>
                                <a href="javascript:void(0)" class="font-14 border-bottom pb-1 border-info">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <!-- *************************************************************** -->
    <!-- Start Top Leader Table -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Top Leaders</h4>
                        <div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                                <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                    id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                    <a class="dropdown-item" href="#">Insert</a>
                                    <a class="dropdown-item" href="#">Update</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Team Lead
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Project
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Team</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        Status
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        Weeks
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3"><img
                                                    src="{{ asset('plugins/images/users/widget-table-pic1.jpg') }}"
                                                    alt="user" class="rounded-circle" width="45"
                                                    height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">Hanna
                                                    Gover</h5>
                                                <span class="text-muted font-14">hgover@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 text-muted px-2 py-4 font-14">Elite Admin</td>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="popover-icon">
                                            <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                href="javascript:void(0)">DS</a>
                                            <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                href="javascript:void(0)">SS</a>
                                            <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                                href="javascript:void(0)">RP</a>
                                            <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                href="javascript:void(0)">+</a>
                                        </div>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-4"><i
                                            class="fa fa-circle text-primary font-12" data-toggle="tooltip"
                                            data-placement="top" title="In Testing"></i></td>
                                    <td
                                        class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        35
                                    </td>
                                    <td class="font-weight-medium text-dark border-top-0 px-2 py-4">$96K
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3"><img
                                                    src="{{ asset('plugins/images/users/widget-table-pic2.jpg') }}"
                                                    alt="user" class="rounded-circle" width="45"
                                                    height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">Daniel
                                                    Kristeen
                                                </h5>
                                                <span class="text-muted font-14">Kristeen@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted px-2 py-4 font-14">Real Homes WP Theme</td>
                                    <td class="px-2 py-4">
                                        <div class="popover-icon">
                                            <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                href="javascript:void(0)">DS</a>
                                            <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                href="javascript:void(0)">SS</a>
                                            <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                href="javascript:void(0)">+</a>
                                        </div>
                                    </td>
                                    <td class="text-center px-2 py-4"><i
                                            class="fa fa-circle text-success font-12" data-toggle="tooltip"
                                            data-placement="top" title="Done"></i>
                                    </td>
                                    <td class="text-center text-muted font-weight-medium px-2 py-4">32</td>
                                    <td class="font-weight-medium text-dark px-2 py-4">$85K</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3"><img
                                                    src="{{ asset('plugins/images/users/widget-table-pic3.jpg') }}"
                                                    alt="user" class="rounded-circle" width="45"
                                                    height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">Julian
                                                    Josephs
                                                </h5>
                                                <span class="text-muted font-14">Josephs@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted px-2 py-4 font-14">MedicalPro WP Theme</td>
                                    <td class="px-2 py-4">
                                        <div class="popover-icon">
                                            <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                href="javascript:void(0)">DS</a>
                                            <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                href="javascript:void(0)">SS</a>
                                            <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                                href="javascript:void(0)">RP</a>
                                            <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                href="javascript:void(0)">+</a>
                                        </div>
                                    </td>
                                    <td class="text-center px-2 py-4"><i
                                            class="fa fa-circle text-primary font-12" data-toggle="tooltip"
                                            data-placement="top" title="Done"></i>
                                    </td>
                                    <td class="text-center text-muted font-weight-medium px-2 py-4">29</td>
                                    <td class="font-weight-medium text-dark px-2 py-4">$81K</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3"><img
                                                    src="{{ asset('plugins/images/users/widget-table-pic4.jpg') }}"
                                                    alt="user" class="rounded-circle" width="45"
                                                    height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">Jan
                                                    Petrovic
                                                </h5>
                                                <span class="text-muted font-14">hgover@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted px-2 py-4 font-14">Hosting Press HTML</td>
                                    <td class="px-2 py-4">
                                        <div class="popover-icon">
                                            <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                href="javascript:void(0)">DS</a>
                                            <a class="btn btn-success text-white font-20 rounded-circle btn-circle"
                                                href="javascript:void(0)">+</a>
                                        </div>
                                    </td>
                                    <td class="text-center px-2 py-4"><i
                                            class="fa fa-circle text-danger font-12" data-toggle="tooltip"
                                            data-placement="top" title="In Progress"></i></td>
                                    <td class="text-center text-muted font-weight-medium px-2 py-4">23</td>
                                    <td class="font-weight-medium text-dark px-2 py-4">$80K</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Top Leader Table -->
    <!-- *************************************************************** -->

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
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "rowCallback": function(row, data, index) {
                    if(data[7]> 0.5){
                        $(row).find('td:eq(7)').css('color', 'red');
                    }
                }
            });
        });
    </script>
@endsection
