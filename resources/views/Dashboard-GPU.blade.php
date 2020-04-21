@extends('layouts/admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
@endsection

@section('content')

<!-- set parameter -->
<?php
    //GPU
    //2561
    $top5Amount = DB::select('EXEC findTop5GPU61');
    $totalAmount = DB::select('select sum(Total_Real_Amount) as total FROM GPU WHERE BUDGET_YEAR=2561;');
    // set parameter
    $n1 = $top5Amount[0]->GPU_NAME;
    $n2 = $top5Amount[1]->GPU_NAME;
    $n3 = $top5Amount[2]->GPU_NAME;
    $n4 = $top5Amount[3]->GPU_NAME;
    $n5 = $top5Amount[4]->GPU_NAME;
    // set parameter
    $id1 = $top5Amount[0]->GPU_ID;
    $id2 = $top5Amount[1]->GPU_ID;
    $id3 = $top5Amount[2]->GPU_ID;
    $id4 = $top5Amount[3]->GPU_ID;
    $id5 = $top5Amount[4]->GPU_ID;
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
<div id="GPU" value = "GPU" style="display:none;">hello</div>
<!-- Drug Purchasing Amount variable-->
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
                <!-- <a class="customize-input float-right" href="/policy/TPU"> -->
                    <!-- GPU -> TPU -->
                    <!-- ข้างล่างยังหาทางทำไม่ได้ ใช้อันบนไปก่อน-->
                <div class="float-right" style="padding-top: 10px;">
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                        <label class="onoffswitch-label" for="myonoffswitch" onclick="location='/policy/TPU'">                   
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
                <!-- </a> -->
                <!-- end switch -->
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
<div class="container-fluid">

    <!-- ============================================================== -->
    <!-- Top10 drug price dispersion  -->
    
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top 10 Unit Price</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-cyan table-striped table-bordered" id="datatable" style="width: 100%;" role="grid" aria-describedby="default_order_info">
                                <thead>
                                    <tr role="row">
                                                <th>Name</th>
                                                <th>GPU</th>
                                                <th>Avg Unit Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                        <?php
                                            $query = DB::select('select GPU_NAME, GPU_ID, Wavg_Unit_Price from GPU
                                                                    where BUDGET_YEAR = 2561
                                                                    order by Wavg_Unit_Price DESC;');
                                            $GPU_count = DB::select('select count(distinct GPU_NAME) as Gcount from GPU where BUDGET_YEAR = 2561;');
                                            for ($i = 0; $i < $GPU_count[0]->Gcount; $i+=1) {
                                                // echo "The number is: $i <br>";
                                        ?>
                                                <tr>      
                                        <?php
                                                foreach($query[$i] as $x => $val) {
                                        ?>
                                                    <td width="40%" class="ellipsis">{{ $val }}</td>
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
    </div>

    
    <!-- End Top10 drug price dispersion -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Total Annual Spending -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Annual Spending</h4>
                <ul class="list-inline text-right">
                    <li class="list-inline-item">
                        <h5><i class="fa fa-circle mr-1 text-info"></i>Annaul Spending</h5>
                    </li>
                </ul>
                <div class="card-body py-3 px-3">
                    
                    <?php
                    if(isset($annualSpendingChart)){
                    ?>
                        {!! $annualSpendingChart->container() !!}
                    <?php
                    }else{
                    ?>
                        <h1>No Data<h1>
                    <?php  
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Total Annual Spending -->
    <!-- ============================================================== -->

    <!-- *************************************************************** -->
    <!-- Start Drug Purchasing Amount -->
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
                            <span class="text-dark font-weight-medium col-lg-4" >Name</span>
                            <span class="text-dark font-weight-medium col-lg-4" >GPU</span>
                            <span class="text-dark font-weight-medium col-lg-4" >Avg Unit Price</span>
                            <span class="text-dark font-weight-medium col-lg-4">Amount</span>
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
                            <span class="text-dark font-weight-medium">{{ $id2 }}</span>
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
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Net Income</h4>
                    <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                    <ul class="list-inline text-center mt-5 mb-2">
                        <li class="list-inline-item text-muted font-italic">Sales for this month</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Earning by Location</h4>
                    <div class="" style="height:180px">
                        <div id="visitbylocate" style="height:100%"></div>
                    </div>
                    <div class="row mb-3 align-items-center mt-1 mt-5">
                        <div class="col-4 text-right">
                            <span class="text-muted font-14">India</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            <span class="mb-0 font-14 text-dark font-weight-medium">28%</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 text-right">
                            <span class="text-muted font-14">UK</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 74%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            <span class="mb-0 font-14 text-dark font-weight-medium">21%</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 text-right">
                            <span class="text-muted font-14">USA</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 60%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            <span class="mb-0 font-14 text-dark font-weight-medium">18%</span>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4 text-right">
                            <span class="text-muted font-14">China</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            <span class="mb-0 font-14 text-dark font-weight-medium">12%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Sales Charts Section -->
    <!-- *************************************************************** -->
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
@endsection

@section('javascripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
@endsection