<!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php 
    $pageTitle = "Home"; // set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<div>
    <div  class="bg-warning text-dark p-3 mb-3" >
        <div class="container-fluid">
            <div class="row ">
                <div class="col comp-grid " >
                    <div class="">
                        <div class="h5 font-weight-bold">ADMIN INVENTORY SYSTEM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="mb-3" >
        <div class="container-fluid">
            <div class="row ">
                <div class="col comp-grid " >
                    <div class="">
                        <div class="row">
                            <div class="col">
                                <div class="h5 font-weight-bold">DASHBOARD</div>
                            </div>
                            <div class="col-auto">
                                <i class="icon  dripicons-device-desktop"></i>
                            </div>
                        </div>
                    </div>
                    <?php $rec_count = $comp_model->getcount_collectionsdone();  ?>
                    <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("collection") ?>' >
                    <div class="row gutter-sm align-items-center">
                        <div class="col-auto" style="opacity: 1;">
                            <i class="icon dripicons-help"></i>
                        </div>
                        <div class="col">
                            <div class="flex-column justify-content align-center">
                                <div class="title">Collections done</div>
                                <small class="">Total Collections</small>
                            </div>
                            <h2 class="value"><?php echo $rec_count; ?></h2>
                        </div>
                    </div>
                </a>
                <?php $rec_count = $comp_model->getcount_permissionsinthesystem();  ?>
                <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("permissions") ?>' >
                <div class="row gutter-sm align-items-center">
                    <div class="col-auto" style="opacity: 1;">
                        <i class="icon dripicons-help"></i>
                    </div>
                    <div class="col">
                        <div class="flex-column justify-content align-center">
                            <div class="title">Permissions in the system</div>
                            <small class="">Total Permissions</small>
                        </div>
                        <h2 class="value"><?php echo $rec_count; ?></h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 comp-grid " >
            <?php $rec_count = $comp_model->getcount_peopleregisteredinsystem();  ?>
            <a class="animated zoomIn record-count alert alert-success"  href='<?php print_link("person") ?>' >
            <div class="row gutter-sm align-items-center">
                <div class="col-auto" style="opacity: 1;">
                    <i class="icon dripicons-help"></i>
                </div>
                <div class="col">
                    <div class="flex-column justify-content align-center">
                        <div class="title">People Registered in System</div>
                        <small class="">Total Person</small>
                    </div>
                    <h2 class="value"><?php echo $rec_count; ?></h2>
                </div>
            </div>
        </a>
        <?php $rec_count = $comp_model->getcount_assets();  ?>
        <a class="animated zoomIn record-count alert alert-success"  href='<?php print_link("assets") ?>' >
        <div class="row gutter-sm align-items-center">
            <div class="col-auto" style="opacity: 1;">
                <i class="icon dripicons-help"></i>
            </div>
            <div class="col">
                <div class="flex-column justify-content align-center">
                    <div class="title">Assets</div>
                    <small class="">Total Assets</small>
                </div>
                <h2 class="value"><?php echo $rec_count; ?></h2>
            </div>
        </div>
    </a>
</div>
</div>
</div>
</div>
<div  class="mb-3" >
    <div class="container-fluid">
        <div class="row ">
            <div class="col comp-grid " >
                <div class=" reset-grids">
                    <?php
                        $params = ['show_header' => false, 'orderby' => 'assets.balance', 'ordertype' => '', 'limit' => 10]; //new query param
                        $query = array_merge(request()->query(), $params);
                        $queryParams = http_build_query($query);
                        $url = url("assets/index/assets.balance/<=5?$queryParams");
                    ?>
                    <div class="ajax-inline-page" data-url="{{ $url }}" >
                        <div class="ajax-page-load-indicator">
                            <div class="text-center d-flex justify-content-center load-indicator">
                                <span class="loader mr-3"></span>
                                <span class="fw-bold">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<!-- Page custom css -->
@section('pagecss')
<style>
</style>
@endsection
<!-- Page custom js -->
@section('pagejs')
<script>
    $(document).ready(function(){
    // custom javascript | jquery codes
    });
</script>
@endsection
