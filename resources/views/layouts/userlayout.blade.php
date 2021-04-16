<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Instant Plot</title>
</head>
<style rel="stylesheet">

@yield('styles');
</style>
<body>
    <div>
    
    </div>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">HOME</a></li>
            <li><a data-toggle="tab" href="#posted">SOLD/CHARTERED</a></li>
            <li><a data-toggle="tab" href="#markintended">INTENDED BY BUYER(S)/LEASER(S)</a></li>
            <li><a data-toggle="tab" href="#intended">INTENDED PROPERTY(IES)</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div id="posted" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="markintended" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="intended" class="tab-pane fade">
            <h3>Menu 3</h3>
            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
        </div>
    </div>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('body')
                <!-- property owned modal -->
                <div class="modal fade property_modal-modal-md" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                        <form action="{{url('/uploadCsv')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="upload_modal">UPLOAD CSV FILE</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <input type="file" name="upload-file" required>
                            
                            <div class="footer text-center">
                            <!-- <hr> -->
                            <input type="submit" class="btn btn-outline-info" value="Upload">
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div> <!--container-fluid -->
        </div>
        <!-- /#page-content-wrapper -->
</body>

</html>