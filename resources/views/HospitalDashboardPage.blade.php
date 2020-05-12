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
    #To_2561, #GPU, #TPU, #GPU_to_TPU, #TPU_to_GPU {
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
            <h3>{{ $Hname }} (2562)</h3>
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
                    <button class="btn" id="To_2561">To 2561</button>

                </div>
            </div>
        <!-- </div> -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Drug Purchasing Quantity</h4>
                   
                    <div class='row center'>
                        <div id="hos_drug_donut" class="mt-2 center" style="height:283px; width:100%; display:inline-block;"></div>

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

    $(document).ready(function() {
        if(top5_GPU_name_1 != ''){
            //donut graph
            // alert('Hi');
            $("#GPU").click(function() {
                $(this).toggleClass("invisible");
                $("#GPU_to_TPU").removeClass("invisible");
                $("#TPU").addClass("invisible");
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
            });

            $("#TPU").click(function() {
                $(this).toggleClass("invisible");
                $("#TPU_to_GPU").removeClass("invisible");
                $("#GPU").addClass("invisible");
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
