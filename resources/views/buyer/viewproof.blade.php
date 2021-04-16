@extends('header')
@section('styles')
<link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">  
<!-- .carousel{
        overflow:hidden;
        white-space:nowrap;
      }
      .img{
        max-width:900px;
        height:auto;
      }
      #images{
        position: relative;
      } -->
      .backbutton{
          position: absolute;
          margin-left:20px;
          top: 40%;
          margin-top: -40;
      }
@stop
@section('body')
<br/>
<center>
<div class="carousel">
    <div id="images">
        @foreach($listall as $document)
        <img class="img" src="{{ $document->fileExt }}" height="500px" width="512px">
        @endforeach
    </div>
</div>
</center>
<br/>		
<a class="backbutton" href="{{ url()->previous() }}"><i class="fa fa-chevron-circle-left" style="font-size:48px; color:teal;"></i></a>



<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  
<script>

    //   function slide(){
    //     var currImage = $('.img').first(),
    //         currImageWidth = currImage.width();			
        
    //     $imageContainer.animate({right: currImageWidth}, function(){
    //       setTimeout(function(){
    //         $imageContainer.append(currImage.clone());
    //         currImage.remove();
    //         $imageContainer.css("right", 0);
    //       }, 500);
    //     });
    //   }
    
    //   setInterval(function() {
    //     slide();
    //   }, 20000);
      
      // Strip out text nodes otherwise there is a jump when the initial slides are removed.
      // This is UGLY. Head over to the CSS forum and ask someone who knows what they're doing, how to do this properly
      //
    //   var holder = document.getElementById("images");
    //   for (var i =0; i < holder.childNodes.length; i++){
    //     if(holder.childNodes[i].nodeType === 3){
    //       holder.removeChild(holder.childNodes[i])
    //     }
    //   }
      
    //   var $imageContainer = $("#images");
    </script>
<script type="text/javascript">
	$(document).ready(function () {
			// None of the options are set
			$("div#makeMeScrollable").smoothDivScroll({
				manualContinuousScrolling: true,
				autoScrollingMode: "onStart",
				hotSpotScrolling: false,
				touchScrolling: true
			});
		});

  </script>
@stop