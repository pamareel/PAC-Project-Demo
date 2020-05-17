@extends('layouts/adminHos')
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
    #hide, #show {
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
                    <form action="searchDrugHosUser" method="get">
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
                                    <th width="5%" style="text-align:center;">GPU ID</th>
                                    <th width="20%" style="text-align:center;">GPU NAME</th>
                                    <th width="5%" style="text-align:center;">TPU ID</th>
                                    <th width="35%" style="text-align:center;">TPU NAME</th>
                                    <th width="5%" style="text-align:center;">Method</th>
                                    <th width="10%" style="text-align:center;">Total Amount</th>
                                    <th width="10%" style="text-align:center;">Avg unit price</th>
                                    <th width="15%" style="text-align:center;">Total Spend</th>
                                    <th width="5%" style="text-align:center;">PAC</th>
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
                                        <td style="text-align:center;">{{ $resultSearch[$i]->PAC_value }}</td>
                                    </tr>
                                <?php 
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
                }else if($resultSearch == 'No value'){
                ?>
                <!-- if not found -->
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
    if($resultSearch != 'No Dname' && $resultSearch != 'No value'){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <button class="btn" id="show" style="background-color:#5c5cb8; color:white;">Show Save Cost</button>
                <button class="btn invisible" id="hide" style="background-color:#5c5cb8; color:white;">Hide Save Cost</button>

                <div id="save_cost" class="invisible">
                    <div class="row col-lg-12 col-md-12" style="margin:auto;">
                        <div class="card-body" style="margin:auto;">
                            <p class="card-title">Original Unit Price</p>
                            <p>{{ $resultCostSave[0]->wavg_unit_price }} THB</p>
                        </div>
                        <div class="card-body">
                            <p class="card-title">Suggested Unit Price</p>
                            <p>{{ $resultCostSave[0]->suggested_unit_price }} THB</p>
                        </div>
                        <div class="card-body">
                            <p class="card-title">Purchasing Quantity</p>
                            <p>{{ $resultCostSave[0]->T_Total_Amount }} units</p>
                        </div>
                    </div>
                        <!-- donut chart -->
                    <div class="col-lg-12 center">
                        <div class="card-body">
                            <div id="hos_donut" class="mt-2 center" style="height:283px; width:100%;"></div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <script>
    $resultSearch = {!! json_encode($resultSearch) !!};
    if($resultSearch != null){
        if($resultSearch != 'No Dname' && $resultSearch != 'No value'){
            $resultCostSave = {!! json_encode($resultCostSave) !!};
            var a = $resultCostSave[0]['suggested_spending'];
            var b = $resultCostSave[0]['Potential_Saving_Cost'];

            $(document).ready(function() {
                //button
                $("#show").click(function() {
                    $(this).addClass("invisible");
                    $("#hide").removeClass("invisible");
                    $("#save_cost").removeClass("invisible");
                });
                $("#hide").click(function() {
                    $(this).toggleClass("invisible");
                    $("#show").toggleClass("invisible");
                    $("#save_cost").addClass("invisible");
                });
                //Donut chart
                $.chartX = c3.generate({ 
                    bindto:"#hos_donut",
                    data:{columns:[['suggested spending', a],['Potential Saving Cost', b]],
                        type:"donut",
                        tooltip:{show:!0}
                    },
                    donut:{label:{show:!1},
                    title: $resultCostSave[0]["Percent_saving"]+'% ('+ $resultCostSave[0]["P_Potential_Saving_Cost"] + ' THB)' ,width:30},
                    legend:{hide:!0},
                    color:{pattern:["#5f76e8","#01caf1"]}
                });
            });
        }else{
            $(document).ready(function() {
                //button
                $("#show").toggleClass("invisible");
            });
        }
    }
        
    </script>
    <?php
    }
    ?>
    <!-- *************************************************************** -->
    <!-- End Search Filter -->
    <!-- *************************************************************** -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@stop
