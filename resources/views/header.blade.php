<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Instant Plot</title>
</head>
  <!-- for the pano -->
  <link rel="stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">  
  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

<style>
  /* width */
  ::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    box-shadow: #4bd2e4; 
    border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    background: #4bd2e4; 
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #4bd2e4; 
}

@yield('styles');
#closing{
    float:right !important;
}
#close{
    float:right !important;
}
#prompt{
  width:100%;
}
#makeMeScrollable
{
    /* width:1085px; */
    /* width:970px; */
    width:100%;
    height: 100%;
    position: relative;
    margin:auto;
    text-align: center;
}

/* Replace the last selector for the type of element you have in
    your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
    if you have links use #makeMeScrollable div.scrollableArea a and so on. */
div #makeMeScrollable .scrollableArea img
{
    
    position: relative;
    width:1150px;
    height:350px;
    margin-left:-120px !important;
    /* If you don't want the images in the scroller to be selectable, try the following
        block of code. It's just a nice feature that prevent the images from
        accidentally becoming selected/inverted when the user interacts with the scroller. */
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
}
.caps{text-transform:uppercase;}
</style>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/home')}}">
        <div class="sidebar-brand-text mx-3">
            <img src="{{ asset('images/iplot.png') }}" height="40" width="130">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{url('/home')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#propertyModal" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-clipboard-list"></i>
          <span>List of Properties</span>
        </a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-box"></i>
          <span>Property Modules</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Properties</h6>
            <a class="collapse-item" href="{{ route('dashboardsell') }}">For Sale</a>
            <a class="collapse-item" href="{{ route('dashboardlease') }}">For Lease</a>
            <!-- <a class="collapse-item" href="{{ route('potential') }}">With Interested <br/>Buyer/Leaser</a> -->
            <a class="collapse-item" href="{{ route('propertiesSold') }}">Sold</a>
            <a class="collapse-item" href="{{ route('propertiesGrantedForLease') }}">Granted as Leased</a>     
            <a class="collapse-item" href="{{ route('intendedlots') }}">Intended</a>
            <a class="collapse-item" href="{{ route('boughtproperties') }}">Bought</a>
            <a class="collapse-item" href="{{ route('rentedproperties') }}">Rented</a>
            <a class="collapse-item" href="{{ route('propertyhistory') }}">Property History</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Instructions
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#instructionModal" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-file"></i>
          <span>Instruction</span>
        </a>
      </li>

      <!-- Nav Item - Charts -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li> -->

      <!-- Nav Item - Tables -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
            
            <i class="fas fa-ellipsis-v" style="margin-top:3px;"></i>&nbsp;{{$title}}
            </div>
          </form>
          <!-- Topbar Notification Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if(Auth()->user()->unreadNotifications->count()!=null) 
                    <span class="badge badge-danger badge-counter">   
                        {{Auth()->user()->unreadNotifications->count()}}
                    </span>
                @endif
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notifications
                </h6>
                @if(count(Auth()->user()->notifications) == 0)
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div>
                            <div class="small text-gray-500"></div>
                            <span class="font-weight-bold">No notifications</span>
                        </div>
                    </a>
                @else
                @foreach(Auth()->user()->unreadNotifications as $notification)
                    @if($notification->tid_fk == '0')
                        <a class="dropdown-item d-flex align-items-center" href="{{url('markasread/'.$notification->id.'/confirmedproperty')}}">
                        <div>
                            <div class="small text-gray-500">{{date('F d, Y', strtotime($notification->created_at))}}</div>
                            <span class="font-weight-bold">{{$notification->data}}</span>
                        </div>
                        </a>
                    @else
                        <a class="dropdown-item d-flex align-items-center" href="{{url('/mark/'.$notification->tid_fk.'/'.$notification->id.'/notif')}}">
                        <div>
                            <div class="small text-gray-500">{{date('F d, Y', strtotime($notification->created_at))}}</div>
                            <span class="font-weight-bold">{{$notification->data}}</span>
                        </div>
                        </a>
                    @endif
                @endforeach
                @foreach(Auth()->user()->readNotifications as $notification)
                    @if($notification->tid_fk == '0')
                        <a class="dropdown-item d-flex align-items-center" href="{{url('/properties')}}">
                        <div>
                            <div class="small text-gray-500">{{date('F d, Y', strtotime($notification->created_at))}}</div>
                            <span class="font-weight-normal">{{$notification->data}}</span>
                        </div>
                        </a>
                    @else
                        <a class="dropdown-item d-flex align-items-center" href="{{url('/view/'.$notification->tid_fk.'/notif')}}">
                        <div>
                            <div class="small text-gray-500">{{date('F d, Y', strtotime($notification->created_at))}}</div>
                            <span class="font-weight-normal">{{$notification->data}}</span>
                        </div>
                        </a>
                    @endif
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="{{url('/viewallnotif')}}">Show All Notifications</a>
                @endif
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small caps">{{ Auth::user()->name }}</span>
                @if($picture==null)
                    <img  class="img-profile rounded-circle" src="{{ asset('images/avatar3.png') }}"> 
                @endif

                @if($picture!=null)
                    <img class="img-profile rounded-circle" src="{{ $picture->fileExt }}">  
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('userProfile') }}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            
        <!-- <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1> -->
             <!-- <a href="{{'/map'}}"class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-search fa-sm text-white-50"></i>Find Property</a>
          </div>   -->

          <!-- <div class="text-center" style="margin:5px 15px 0px 15px;">
            <input type="submit" value="As a Seller" class="btn btn-info btn-block rounded-5 py-2">
          </div>   -->
          <!-- Content Row -->
          <div class="row">

              @yield('body')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <br/>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span><a href="#">
                <a href=""><i class="fab fa-facebook-square" style="color:gray"></i></a>
                <a href="#"><i class="fab fa-pinterest-p" style="color:gray"> </i></a>
                <a href="#"><i class="fab fa-twitter" style="color:gray"> </i></a>
                <a href="#"><i class="fab fa-flickr" style="color:gray"> </i></a>
                <a href="#"><i class="fab fa-linkedin" style="color:gray"></i></a></span>
            <span>Copyright &copy; InstantPlot 2019</span>
            <p></p>
            <p>instantPlot is not a salesperson. It is a match-maker. It introduces people to lands, until they fall in love with one.</p>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure to log out?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-info" href="{{ route('logouts') }}">Logout</a>
        </div>
      </div>
    </div>
  </div>

    <!-- Instruction Modal-->
  <div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">INSTRUCTIONS</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            1. Register a valid email account.<br/>
            SELLING/CHARTERING<br/>
            2. Confirm properties you owned by clicking "Add Property" button.<br/>
            3. Fill up confirmation form. Click "Add"<br/><br/>
            4. Click owned properties.<br/>
            7. Click on the Lot Number of the property you want to sell or charter.<br/>
            BUYING/RENTING<br/>
            8. Click "Find Property".<br/>
            9. Set your own criterias in searching.<br/>
            10. Hover on the markers to view partial lot details. Or click "View More Info" on the listings below the map.<br/>
            11. Click on the marker to view full details.<br/>
            12. Click Place an Intent Button to notify seller your interest in buying or leasing the property.<br/>
            13. Viola! Your good to go.<br/><br/>
            Disclaimer: <br/>
            &emsp;Property details confirmed in the assessors office are not disclosed with other users of InstantPlot except the property owner. Property owner are the only ones who can view the list of properties they confirmed in the assessors office. Other confirmed properties confirmed by other users are not disclosed and are not viewable by other users.<br/>
            &emsp;The information contained on each individual property for sale or for rent has been gathered from the seller or leasor of the property. We cannot verify or guarantee its accuracy either way. Prospective purchasers or tenants must rely on their own enquiries and should verify accuracy of information before proceeding to buy or lease.<br/>
            &emsp;Please note, the material available is general information only, and is subject to change without notice. The information held within this website should not be relied on as a substitute for legal, financial, real-estate or other expert advice. InstantPlot disclaims all liability, responsibility and negligence for direct and indirect loss or damage suffered by any person arising from the use of information presented on this website or material that arises from it.
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

    <!-- Adding Property Modal -->
    <div class="modal fade bd-example-modal-lg" id="addPropertyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">PROPERTY INFORMATION</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form autocomplete="off" action="{{url('/seller/saveproperty')}}" method="post" enctype="multipart/form-data" id="form1">
                @csrf
                <div class="form-group row">
                    <label for="lotowner" class="col-sm-2 col-form-label text-md-right">{{ __('Owner') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotowner" value="" placeholder="owners name in the tax declaration or title" required>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNumber" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Number') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lotNumber" value="" required>
                        </div>
                        <label for="lotTitleNumber" class="col-sm-2 col-form-label text-md-right">{{ __('Title Number') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lotTitleNumber" value="" placeholder="(optional)">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotArea" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Area') }}</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="lotArea" value="" required>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="UnitOfMeasure" required>
                                <option value="sqm">Sqm</option>
                                <option value="hectares">Hectares</option>
                            </select>
                        </div>
                            <label for="lotType" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Type') }}</label>
                            
                        <div class="col-sm-4">
                                <select class="form-control" name="lotType" required>
                                <option value="Residential Lot">Residential Lot</option>
                                <option value="Commercial Lot">Commercial Lot</option>
                                <option value="Agricultural Lot">Agricultural Lot</option>
                                <option value="Beach Lot">Beach Lot</option>
                            </select>
                        </div>
                </div>
                <b>Input atleast 3 technical specification of the property</b>
                <div class="form-group row">
                    <label for="lotNorthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotNorthEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNorthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotNorthWestBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotSouthEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotSouthWestBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNorthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotNorthBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotSouthBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotWestBoundary" value="">
                        </div>
                </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" value="Add" class="btn btn-info">
        </div>
        </form>
      </div>
    </div>
  </div>  


 <!-- Adding Property Modal for Buyer Side -->
   <div class="modal fade bd-example-modal-lg" id="addBuyerPropertyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">PROPERTY INFORMATION</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form autocomplete="off" action="{{url('/seller/saveproperty')}}" method="post" enctype="multipart/form-data" id="formaddproperty">
                @csrf
                <div class="form-group row">
                    <label for="lotowner" class="col-sm-2 col-form-label text-md-right">{{ __('Owner') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lotowner" value="" placeholder="owners name in the tax declaration or title" required>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNumber" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Number') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lotNumber" value="" required>
                        </div>
                        <label for="lotTitleNumber" class="col-sm-2 col-form-label text-md-right">{{ __('Title Number') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lotTitleNumber" value="" placeholder="(optional)">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotArea" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Area') }}</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="lotArea" value="" required>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="UnitOfMeasure" required>
                                <option value="sqm">Sqm</option>
                                <option value="hectares">Hectares</option>
                            </select>
                        </div>
                            <label for="lotType" class="col-sm-2 col-form-label text-md-right">{{ __('Lot Type') }}</label>
                            
                        <div class="col-sm-4">
                                <select class="form-control" name="lotType" required>
                                <option value="Residential Lot">Residential Lot</option>
                                <option value="Commercial Lot">Commercial Lot</option>
                                <option value="Agricultural Lot">Agricultural Lot</option>
                                <option value="Beach Lot">Beach Lot</option>
                            </select>
                        </div>
                </div>
                <b>Input atleast 3 technical specification of the property</b>
                <div class="form-group row">
                    <label for="lotNorthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i1" class="form-control" name="lotNorthEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNorthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i2" class="form-control" name="lotNorthWestBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i3" class="form-control" name="lotSouthEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i4" class="form-control" name="lotSouthWestBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotNorthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('North Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i5" class="form-control" name="lotNorthBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('East Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i6" class="form-control" name="lotEastBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotSouthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i7" class="form-control" name="lotSouthBoundary" value="">
                        </div>
                </div>
                <div class="form-group row">
                    <label for="lotWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('West Boundary') }}</label>
                        <div class="col-md-6">
                            <input type="text" id="i8" class="form-control" name="lotWestBoundary" value="">
                        </div>
                </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" value="Add" class="btn btn-info">
        </div>
        </form>
      </div>
    </div>
  </div>  

 <!-- Property Modal-->
 <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">LIST OF PROPERTIES</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        @if(count($ownedLot)>0)
            <h6>CONFIRMED LOTS</h6>
            <div style="height: 200px; overflow: auto;" class="table-confirmed">
                <table width="100%">
               
                <tr>
                  <th>LOT NUMBER</th>
                  <th>LOT ADDRESS</th>
                </tr>
                @foreach($ownedLot as $value)
                @if($value->status=="new")
                <tr>
                  <td><a class="ownedProperties" href="{{url('/sell/'.$value->lotId.'/post')}}">{{$value->lotNumber}}</a></td>
                  <td>{{$value->lotAddress}}</td>
                </tr>
                @elseif($value->status=="posted")
                <tr>
                  <td>{{$value->lotNumber}}</td>
                  <td>{{$value->lotAddress}}</td>
                </tr>
                @endif
                @endforeach
                </table>
                @else
                <h6>CONFIRMED LOTS</h6>
                <center>
                <font size="2" color="teal">NO PROPERTIES ADDED</font>
                </center>
                <br>
                <br>
                </div>

            @endif
            <br>
                <br>
          </div>
          <hr/>
          <div class="modal-body">

            @if(count($pendingLot)>0)
              <h6>PENDING PROPERTIES</h6>
              <div style="height: 200px; overflow: auto;" class="table-pending">
                <table width="100%">
                  @foreach($pendingLot as $value)
                    @if($value->status=="pending")
                    <tr>
                      <td><a href="{{url('/update/'.$value->id.'/pending')}}">property {{$value->lotNumber}}</a></td>
                    </tr>
                    @endif
                  @endforeach
                </table>
            @else
              <h6>PENDING PROPERTIES</h6>
                <center>
                <font size="2" color="teal">NO PENDING PROPERTIES</font>
                </center>
                </div>
            @endif

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
    </div>
  </div>
 
<div class="js">

<script src="{{asset('js/smooth.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  
 <!-- Bootstrap core JavaScript-->
 <!-- <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script> -->
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages -->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <!-- <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script> -->

  <!-- Page level custom scripts -->
  <!-- <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->

@yield('js')

<script>
function w3_close() 
    {
        document.getElementById("prompt").style.display = "none";
    }

$(document).ready(function(){

    $('#formaddproperty').submit(function(event){
      
            // var NorthEastBoundary = $('input[name=lotNorthEastBoundary]').val();
            // var NorthWestBoundary = $('input[name=lotNorthWestBoundary]').val();     
            // var SouthEastBoundary = $('input[name=lotSouthEastBoundary]').val();                 
            // var SouthWestBoundary = $('input[name=lotSouthWestBoundary]').val();     
            // var NorthBoundary = $('input[name=lotNorthBoundary]').val();     
            // var EastBoundary = $('input[name=lotEastBoundary]').val();                 
            // var SouthBoundary = $('input[name=lotSouthBoundary]').val();  
            // var WestBoundary = $('input[name=lotWestBoundary]').val(); 
            var NorthEastBoundary = $('#i1').val();
            var NorthWestBoundary = $('#i2').val();     
            var SouthEastBoundary = $('#i3').val();                 
            var SouthWestBoundary = $('#i4').val();     
            var NorthBoundary = $('#i5').val();     
            var EastBoundary = $('#i6').val();                 
            var SouthBoundary = $('#i7').val();  
            var WestBoundary = $('#i8').val(); 
            
            var array=[];
            if(NorthEastBoundary!="")
              array.push(NorthEastBoundary);
            if(NorthWestBoundary!="")
              array.push(NorthWestBoundary);
            if(SouthEastBoundary!="")
              array.push(SouthEastBoundary);
            if(SouthWestBoundary!="")
              array.push(SouthWestBoundary);
            if(NorthBoundary!="")
              array.push(NorthBoundary);
            if(EastBoundary!="")
              array.push(EastBoundary);
            if(SouthBoundary!="")
              array.push(SouthBoundary);
            if(WestBoundary!="")
              array.push(WestBoundary);

            console.log (array.length);
           if(array.length < 3){
              alert('Please input at least 3 technical specification of the property.');
              return false;
            }
  });
});

</script>
</div>
</body>

</html>
