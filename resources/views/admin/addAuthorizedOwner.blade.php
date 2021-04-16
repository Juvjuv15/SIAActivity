@extends('header')
@section('styles')
.button{
  border: 1px;
  border-radius: 5px;
  background-color: #2f4454;
  color:white;
  }
.button:hover{
  opacity: 0.8;

    <!-- background: #9ecdd5;     -->
    <!-- background: red;     -->

}

* {
  box-sizing: border-box;
}


#addowner {
  background-color: white;
  margin: 50px auto;
  border-radius: 10px;
  font-family: arial,bold;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

h1 {
  font-family: raleway,bold;
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: arial,bold;
  border: 1px solid gray;
  border-radius: 10px;
  color: #2f4454;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #fed0d0;
}

/* Hide all steps by default: */
.label {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: arial,bold;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  border: 1px;
  border-radius: 5px;
  background-color: #2f4454;
}
#nextBtn{
  border: 1px;
  border-radius: 5px;
  background-color: teal;
}
/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: gray;
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
  background-color: #2f4454;
}

#lnumber{
  margin-bottom: 20px;
}
@stop
@section('body')
<div body>

<form id="addowner" action="{{url('/saveOwner')}}" method="post">
@if (session('status'))
    <div align="center" class="alert alert-success">
        <h5>{{ session('status') }}</h5>
    </div>
@endif

@csrf
  <!-- <h1>Confirm Lot Property Ownership</h1> -->
  <br>
  <!-- One "tab" for each step in the form: -->
  <div class="label">E-mail Address
  <p><input type="email" placeholder="E-mail . . . . ." oninput="this.className = ''" name="email"></p>
  </div>
  <div class="label">Lot Number
  <p id="addOwner">
  <input type="text" placeholder="Lot number..." oninput="this.className = ''" name="lnumber[]" id="lnumber">
  </p>
 
  <center>
  <input type="button" value="Add" onclick="addLot()" class="button">
  </center>
  </div>

  <div style="overflow:auto;">
    <div style="float:right;">
    <br>
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>&nbsp;&nbsp;
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
<center>
  <a href="/adminLanding">Cancel</a>
</center>


                        <!-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="button">
                                    {{ __('SAVE') }}
                                </button>

                                <input type="button" onclick="location.href='{{url('/home')}}'" class="button" value="CANCEL">
                            </div>
                        </div> -->


  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <!-- <span class="step"></span>
    <span class="step"></span> -->
  </div>
  <br>
</form>
</div>
<script>
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

</script>
<!-- <script>
function addLot()
{
  var field=document.getElementsByClassName("lnumber");
  field=field.length+1;
  document.getElementById("lotnumberfield").innerHTML=document.getElementById("lotnumberfield").innerHTML+
  "<p id='lnumber"+field+"_wrapper'><input type='text' class='lnumber' name='lnumber[]' id='lnumber"+field+"' placeholder='Lot number' value=''><input type='button' class='btn btn-success' value='Remove' onclick=remove_field('lnumber"+field+"');></p>";
}
function remove_field(id)
{
  document.getElementById(id+"_wrapper").innerHTML="";
}
</script> -->
@stop
