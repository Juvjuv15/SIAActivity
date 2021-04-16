<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Instant Plot</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- External Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidenavbar.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <script src="{{ asset('js/popper.min.js') }}"></script>

</head>
<style rel="stylesheet">
.closebutton{
    float:right;
    position:inline-block;
    margin-right: 15px;
}
/* .fa-close:hover{
    color:red;
} */
.close{color:white;}
.profile {
    border-radius: 50%;
   margin-bottom:10px;
}
table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
  position:center;
  width:100%;
}

th, td {
  padding: 1em;
  border-bottom: 2px solid white; 
}

thead{
    background: #138496;
    color:white;
}

.title{
    font-size:36px;
    color:teal;
    margin-left:10px;
    font-weight:bold;
}

tr:hover{
    background: none;
    opacity: 0.9;
}
tr:nth-child(even) {
    background-color: #b2faf0;
}
tbody{
  font-size: 10pt;
}
.modal-title{
    color:white;
}


/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #fed0d0;
}

/* Hide all steps by default: */
.label {
  display: none;
}

.prevBtn {
    font-family: arial,bold;
    font-size: 100px;
    font-weight: 700;
    color: white;
    width: 120px;
    box-sizing: border-box;
    border: 2px;
    border-radius: 5px;
    font-size: 16px;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 10px 12px 10px;
    display: right;
    text-align: center;
    background-color: #2f4454;
}

.prevBtn:hover{
  opacity: 0.8;
}
.nextBtn{
    font-family: arial,bold;
    font-size: 100px;
    font-weight: 700;
    color: white;
    width: 120px;
    box-sizing: border-box;
    border: 2px;
    border-radius: 5px;
    font-size: 16px;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 10px 12px 10px;
    display: right;
    text-align: center;
    background-color: teal;
}

.nextBtn:hover{
  opacity: 0.8;
}
/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #008080;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #dc3545;
}
.lnum{
    width: 400px;
    box-sizing: border-box;
    border: 1.5px solid #63c8c9;
    border-radius: 10px;
    font-size: 16px;
    background-color: white;
    padding: 11px 11px 11px 11px;
}
/* input[type=email]{
    width: 450px;
    box-sizing: border-box;
    border: 1.5px solid #63c8c9;
    border-radius: 10px;
    font-size: 16px; */
    /* background-color: white; */
    /* background-position: 10px 10px; 
    background-size: 20px 20px;
    background-repeat: no-repeat;
    padding: 11px 11px 11px 11px;
} */
#close{
    float:right;
}
#side_modules{

}
.upload_csv, .confirm_owner{
    cursor: pointer !important;
}
@yield('styles');
</style>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                <a href="{{url('/adminLanding')}}"><img src="{{ asset('images/iplot.png') }}" height="45" width="150"></a>
                <!-- <hr/> -->
                </li>
                @if(Auth::user()->userType == "2")
                    <li>
                        <a id="side_modules" href="{{url('/add/adminUser')}}">ADD CITY ASSESSOR ADMIN</a>
                    </li>
                    <li>
                        <a id="side_modules" href="{{url('/update/criteria')}}">RECOMMENDER CRITERIA</a>
                    </li>
                @else
                    <li>
                        <a id="side_modules" data-toggle="modal" data-target="#upload_modal" class="upload_csv" ><font color="white">UPLOAD CSV FILE</font></a>
                    </li>
                    <li>
                        <a id="side_modules" href="{{url('/lot/addLot')}}">ADD LOT MANUALLY</a>
                    </li>
                    <!-- <li>
                        <a id="side_modules" data-toggle="modal" data-target="#confirm_modal" class="confirm_owner"><font color="white">CONFIRM PROPERTY OWNER</font></a>
                    </li> -->
                    <li>
                        <a id="side_modules" href="{{url('/lotList')}}">PROPERTY LIST</a>
                    </li>
                    <!-- <li>
                        <a id="side_modules" href="{{url('/confirmedList')}}">CONFIRMED PROPERTIES</a>
                    </li> -->
                @endif
                <li>
                    <a id="side_modules" href="{{ route('admin_login') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('LOGOUT') }}
                    </a>
                    <form id="logout-form" action="{{ route('admin_login') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div style="background-color:#dbf1f5">
        <a href="#menu-toggle" class="" id="menu-toggle" style=""><i class="fa fa-bars" style="color:teal; margin:20px 0px 20px 10px; font-size:36px;"></i></a>
       
        <span class="title"><?php echo $title;?></span>    
 
        </div>
        <div id="page-content-wrapper">
         
            <div class="container-fluid">
               
                @yield('body')
                <!--Upload Modal -->
                
                <div class="modal fade upload_modal-modal-md" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
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
            

             <!--Confirm Owner Modal -->
                    <div class="modal fade confirm_modal-modal-md" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="confirm_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                        <form id="addowner" action="{{url('/saveOwner')}}" method="post">
                        @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirm_modal">CONFIRM PROPERTY OWNER</h5>
                                <a href="/adminLanding" class="close" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </a>
                            </div>
                            <div class="modal-body">
                            <!-- One "tab" for each step in the form: -->
                                <div class="label bold"> &emsp;
                                <p><input type="email" placeholder="E-mail Adress . . . . ." oninput="this.className = ''" name="email"></p>
                                </div>
                                <div class="label bold">&emsp;&emsp;
                                <input type="hidden" name="totalLnumber" id="totalLnumber" value="0">
                                <button type="button" class="btn btn-outline-secondary float-right" id="addLnum">Add Lot Number</button>
                                <!-- <i onclick="addLot()" class="fa fa-plus" style="font:size: 30px;border:1px solid #63c8c9; color:#63c8c9;"></i> -->
                                <!-- <p id="addOwner"> -->
                                <div class="lotNumber">
                                    <div class="form-row">
                                        <div class="form-group col-md-7">
                                            <br/>
                                            <input type="text" id="lnum0" class="lnum" name="lnumber[]">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div style="overflow:auto;">
                                <div style="float:right;">
                                <br>
                                    <button type="button" class="prevBtn" id="prevBtn" onclick="nextPrev(-1)">Previous</button>&nbsp;&nbsp;
                                    <button type="button" class="nextBtn" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                <span class="step"></span>
                                <span class="step"></span>
                                </div>
                            <!-- <div class="footer text-center">
                            <a class="btn btn-outline-info" href="/adminLanding">Cancel</a>
                            </div> -->
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </form>

            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the crurrent tab

    function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("label");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Save";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
    }

    function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("label");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
        // ... the form gets submitted:
        document.getElementById("addowner").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
    }

    function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("label");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false
        valid = false;
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
    }

    function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
    }

    function addLot() {
        var field=document.getElementById("addOwner");
        // var li = document.createElement("LI");
        var lotnumber = document.createElement("INPUT");
        lotnumber.setAttribute("type", "text");
        lotnumber.setAttribute("id", "lnumber");
        lotnumber.setAttribute("name", "lnumber[]");
        lotnumber.setAttribute("placeholder", "Lot number...");

        // var remove = document.createElement("INPUT");
        // remove.setAttribute("type", "button");
        // remove.setAttribute("value", "x");
        // remove.setAttribute("onclick", "removeLotnumber(lnumber)");
        
        field.appendChild(lotnumber);
        // field.appendChild(remove);

    }

    function removeLotnumber(id)
    {
    document.getElementById(id).innerHTML="";
    }

    function w3_close() 
    {
        document.getElementById("prompt").style.display = "none";
    }

</script>
<script>
    $(document).ready(function(){
        var lnumCtr = 0;
        $('#addLnum').click(function(){
            var input="";
            input +='<div class="record">';
            input +='<div class="float-right"><span class="ibtnDel fa-stack fa-sm text-primary" style="bottom: -10px;"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-times fa-stack-1x fa-inverse"></i></span></div>';
            // input +='<div class="clearfix"></div>';
            input +='<div class="form-row">';
                input += '<div class="form-group col-md-7">';
                    input+= '<input id="lnum0" class="lnum" type="text" name="lnumber[]">';
                input +='</div>';
            input +='</div>';
            input +='</div>';
            $('.lotNumber').append(input);
            lnumCtr++;
            $('#totalLnumber').val(lnumCtr);
            if(lnumCtr == 5) $(this).prop('disabled',true);
            assignLnumVar();
        });

        //delete lnumber
        $('.lotNumber').on("click",".ibtnDel", function(){
            $(this).closest("div.record").remove();
            lnumCtr--;
            $('#addLnum').prop("disabled",false);
            $('totalLnumber').val(lnumCtr);
            assignLnumVar();
        });
    });
    function assignLnumVar(){
        $(".lnum").each(function(a){
            $(this).attr('id','lnum'+a);
        });
    }
</script>
</body>

</html>