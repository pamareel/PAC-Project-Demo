@extends('layouts/admin')
@section('styles')
<script src="{{ asset('plugins/libs/jquery/dist/jquery.min.js') }}"></script>
@endsection
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<style>
    #To_2561, #TPU_to_GPU, #GPU_to_TPU {
        border-radius: 4px;
        padding: 8px;
        border: none;
        font-size: 16px;
        background-color: beige;
        color: grey;
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $Hname }} (2562)</h3>
            <button class="btn" id="To_2561">&lt; To 2561</button>
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
        <div class="col-md-6 col-lg-6" id = 'Province_Donut'>
            <div class="card">
                <div class="card-body">
                    <h4 style="color:black; text-align:center;">Drug Purchasing Quantity</h4>
                    <button class="btn" id="GPU_to_TPU">GPU > TPU</button>
                    <button class="btn invisible" id="TPU_to_GPU">TPU > GPU</button>

                    <div class='row center'>
                        <div id="hos_drug_donut" class="mt-2 col-md-6 center" style="height:283px; width:60%;">hi</div>
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
</div>
<script>
    content_1 = [];
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

    if(top5_GPU_name_1 != ''){
        //donut graph
        alert([top5_GPU_name_1, top5_GPU_amount_1]);
        c3.generate({ 
            bindto:"#size_quan_donut",
            data:{columns:[[top5_GPU_name_1, top5_GPU_amount_1], [top5_GPU_name_2, top5_GPU_amount_2],
                            [top5_GPU_name_3, top5_GPU_amount_3], [top5_GPU_name_4, top5_GPU_amount_4],
                            [top5_GPU_name_5, top5_GPU_amount_5], ['Others', top5_GPU_amount_other]],
                type:"donut",
                tooltip:{show:!0}
            },
            donut:{label:{show:!1},
            title: "Total ",width:10},
            legend:{hide:!0},
            color:{pattern:["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]}
        });
        
        alert('HI');
        //table
        // $('#Table_quan_donut tbody').html(content_1);
    }else if(top5_GPU_name_1 == '' || top5_GPU_name_1 == NULL){
        alert('No data');
    }
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@stop
