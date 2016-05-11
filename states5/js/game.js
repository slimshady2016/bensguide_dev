
function loadImages()	
	{
		var svgInWidth = $('#svgMap').attr('width');
		  svgInWidth = svgInWidth.replace('px','');
		  var svgWidth = $('#svgMap').width();
		  var perc = (svgWidth * 100)/svgInWidth;
		  perc = Math.round(perc);
		  
		$.each($(".fill"),function(){
			
			// Get on screen image
			var screenImage = $(this);

			// Create new offscreen image to test
			var theImage = new Image();
			theImage.src = screenImage.attr("src");

			// Get accurate measurements from that.
			var imageWidth = theImage.width;
			
			var imgWidth = $(this).width();
			var newImgWidth = imageWidth*perc/100;
			$(this).attr('width', newImgWidth);
			
			var parent = $(this).parent();
			var parentOffset = $(parent).offset();
			
			var maxXOffset = parentOffset.left + $(parent).width() - newImgWidth;
			var xOffset = getRandomInt(parentOffset.left,maxXOffset);

			var maxYOffset = parentOffset.top + $(parent).height() - $(this).height();
			var yOffset = getRandomInt(parentOffset.top,maxYOffset);
			
			
			$(this).offset({left:xOffset,top:yOffset});
			var time = getRandomInt(10,200);
			
			var state = this;
			setTimeout(function(){
				$(state).animate({opacity: 1});
		   }, time,state);			
		})	
	}
	function getRandomInt(min, max) {
	    return Math.floor(Math.random() * (max - min + 1)) + min;
	}

var imagesLoaded = 0;
var svgLoaded = false;

function imgLoaded()
	{
		imagesLoaded++;
		if(imagesLoaded==50&&svgLoaded){
			loadImages();
		}
	}

$(function () {
	FastClick.attach(document.body);

	
	$("#game-map").load('svg/map.svg', function() {

		svgLoaded = true;
		if(imagesLoaded==50){
			loadImages();
		}
		var IEversion = detectIE();

		if (IEversion !== false) {
			$(".gameStates").load('gameStatesIE.html',bindDroppable);
		}else{
			$(".gameStates").load('gameStates.html',bindDroppable);
		}
		
		
		  
	});
	function bindDroppable()
	{
		$.each($(".gameStates img"),function(){

			var overlap = 0.25

			interact('#'+$(this).attr('state')).dropzone({
			  accept: '.'+$(this).attr('state')+'.draggable',
			  overlap: overlap,
			  ondropactivate: function (event) {
			  },
			  ondragenter: function (event) {
				  var target = event.target;
				  var draggable = event.relatedTarget;
				  var target = event.target;
				  $(target).attr("fill","#AADDAA");
			  },
			  ondragleave: function (event) {
				  var target = event.target;
				  $(target).attr("fill","#FFFFFF") ; 
			  },
			  ondrop: function (event) {
				  /*show starts aniamtion over ben's map*/
    			  	if($(".draggable").size()==1)
				  	{
					  $("#win-audio")[0].play();
				  	}
				  	else
				  	{
				  		$("#placed-state-audio")[0].currentTime = 0;;
						$("#placed-state-audio")[0].play();
				  	}

				  $( "#snapGreat" ).fadeIn( "100" ).addClass( "animate bounceIn" );
				  $( "#snapStars01" ).delay(50).fadeIn( "100" ).addClass( "animate bounceIn" );
				  $( "#snapStars02" ).delay(70).fadeIn( "100" ).addClass( "animate bounceIn" );
				  $( "#snapStars03" ).delay(100).fadeIn( "100" ).addClass( "animate bounceIn" );
				  $( "#snapStars01" ).delay(50).fadeOut( "100" );
				  $( "#snapStars02" ).delay(70).fadeOut( "100" );
				  $( "#snapStars03" ).delay(100).fadeOut( "100" );
				  $( "#snapGreat" ).delay(500).fadeOut( "100" );
				  
				  var target = event.target;
				  var draggable = event.relatedTarget;
				  var X = $(target).offset().left - $(draggable).offset().left;
				  var Y = $(target).offset().top - $(draggable).offset().top;
				  $(draggable).animate({left:'+='+X,top:'+='+Y},250,function(){
							$(target).attr("fill",$(draggable).attr('color'));
						  	$(draggable).remove();
						  	if($(".draggable").size()==0)
						  	{
							  $( "#modalWin" ).fadeIn( "200" );
							  $( "#modalWin" ).addClass('animated  bounceIn');
							  $('#btReplay').delay(2000).fadeIn(500);
						  	}
					  });		  		  		  
				  
			  },
			  ondropdeactivate: function (event) {
			  }
			});
			
		})
	}
	function detectIE() {
		  var ua = window.navigator.userAgent;
		
		  // test values
		  // IE 10
		  //ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
		  // IE 11
		  //ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
		  // IE 12 / Spartan
		  //ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';
		
		  var msie = ua.indexOf('MSIE ');
		  if (msie > 0) {
		    // IE 10 or older => return version number
		return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		  }
		
		  var trident = ua.indexOf('Trident/');
		  if (trident > 0) {
		    // IE 11 => return version number
		var rv = ua.indexOf('rv:');
		return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
		  }
		
		  var edge = ua.indexOf('Edge/');
		  if (edge > 0) {
		    // IE 12 => return version number
		return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
		  }
		
		  // other browser
		  return false;
		}


	var capitals = {wyoming:{capital:'Cheyenne',state:'Wyoming'},colorado:{state:'Colorado',capital:'Denver'},newmexico:{capital:'Santa Fe',state:'New Mexico'},alaska:{capital:'Juneau',state:'Alaska'},montana:{capital:'Helena',state:'Montana'},arizona:{capital:'Phoenix',state:'Arizona'},utah:{capital:'Salt Lake City',state:'Utah'},idaho:{capital:'Boise',state:'Idaho'},nevada:{capital:'Carson City',state:'Nevada'},california:{capital:'Sacramento',state:'California'},maine:{capital:'Augusta',state:'Maine'},newhampshire:{capital:'Concord',state:'New Hampshire'},vermont:{capital:'Montpelier',state:'Vermont'},massachusetts:{capital:'Boston',state:'Massachusetts'},rhodeisland:{capital:'Providence',state:'Rhode Island'},connecticut:{capital:'Hartford',state:'Connecticut'},newyork:{capital:'Albany',state:'New York'},newjersey:{capital:'Trenton',state:'New Jersey'},delaware:{capital:'Dover',state:'Delaware'},pennsylvania:{capital:'Harrisburg',state:'Pennsylvania'},maryland:{capital:'Annapolis',state:'Maryland'},westvirginia:{capital:'Charleston',state:'West Virginia'},virginia:{capital:'Richmond',state:'Virginia'},northcarolina:{capital:'Raleigh',state:'North Carolina'},southcarolina:{capital:'Columbia',state:'South Carolina'},georgia:{capital:'Atlanta',state:'Georgia'},florida:{capital:'Tallahassee',state:'Florida'},ohio:{capital:'Columbus',state:'Ohio'},alabama:{capital:'Montgomery',state:'Alabama'},tennessee:{capital:'Nashville',state:'Tennessee'},kentucky:{capital:'Frankfort',state:'Kentucky'},indiana:{capital:'Indianapolis',state:'Indiana'},michigan:{capital:'Lansing',state:'Michigan'},mississippi:{capital:'Jackson',state:'Mississippi'},illinois:{capital:'Springfield',state:'Illinois'},wisconsin:{capital:'Madison',state:'Wisconsin'},louisiana:{capital:'Baton Rouge',state:'Louisiana'},arkansas:{capital:'Little Rock',state:'Arkansas'},missouri:{capital:'Jefferson City',state:'Missouri'},iowa:{capital:'Des Moines',state:'Iowa'},minnesota:{capital:'Saint Paul',state:'Minnesota'},texas:{capital:'Austin',state:'Texas'},oklahoma:{capital:'Oklahoma City',state:'Oklahoma'},kansas:{capital:'Topeka',state:'Kansas'},nebraska:{capital:'Lincoln',state:'Nebraska'},southdakota:{capital:'Pierre',state:'South Dakota'},hawaii:{capital:'Honolulu',state:'Hawaii'},northdakota:{capital:'Bismarck',state:'North Dakota'},oregon:{capital:'Salem',state:'Oregon'},washington:{capital:'Olympia',state:'Washington'}};
	interact('.draggable')
	.draggable({
	  inertia: true,
	  restrict: {
	    endOnly: true,
	    elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
	  },
	  autoScroll: false,
	  onstart: function (event){
		  var target = event.target;
		  var state=$(target).attr('state');
		  $("#stateName").html('<span> '+ capitals[state].state +' </span><div id="stateCapitol">Capital: <span> '+capitals[state].capital+'</span></div>');
	  },
	  onmove: dragMoveListener,
	  onend: function (event) {
		  $("#stateName").html("");
	     }
	});
	function dragMoveListener (event) {
	  var target = event.target,
	      x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
	      y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
	  target.style.webkitTransform =
	  target.style.transform =
	    'translate(' + x + 'px, ' + y + 'px)';
	  target.setAttribute('data-x', x);
	  target.setAttribute('data-y', y);
	}
	
	var orientation = window.orientation != undefined;
	var origingMode = "none";

	$( window ).resize(function() {
		var currMode =  "landscape";
		 
	      switch(window.orientation){
	 
	           case 0:
	           currMode = "portrait";
	           break;
	 
	           case -90:
	           currMode = "landscape";
	           break;
	 
	           case 90:
	           currMode = "landscape";
	           break;
	 
	           case 180:
	           currMode = "portrait";
	           break;
	     }
	      if(!orientation||currMode!=origingMode)
	    	 {
			  var svgInWidth = $('#svgMap').attr('width');
			  svgInWidth = svgInWidth.replace('px','');
			  var svgWidth = $('#svgMap').width();
			  var perc = (svgWidth * 100)/svgInWidth;
			  perc = Math.round(perc);

			$.each($(".fill"),function(){
				
				var screenImage = $(this);

				var theImage = new Image();
				theImage.src = screenImage.attr("src");

				var imageWidth = theImage.width;
				
				var imgWidth = $(this).width();
				var newImgWidth = imageWidth*perc/100;
				$(this).attr('width', newImgWidth);
				
				var parent = $(this).parent();
				var parentOffset = $(parent).offset();
				
				var maxXOffset = parentOffset.left + $(parent).width() - newImgWidth;
				var xOffset = getRandomInt(parentOffset.left,maxXOffset);

				var maxYOffset = parentOffset.top + $(parent).height() - $(this).height();
				var yOffset = getRandomInt(parentOffset.top,maxYOffset);
				
				
				$(this).offset({left:xOffset,top:yOffset});
				
			});
			
	    }

	      origingMode = currMode;
		
	});

	$(document).ready(function(){
				  		
		$("#btLines").click(function(){
					if($("#inlineStates").attr("class")=="showLines")
					{
						$("#btLines").removeClass('active');
						$("#inlineStates").attr("class", "noLines");
					}
				else if($("#inlineStates").attr("class")=="noLines")
					{
						$("#btLines").addClass('active');
						$("#inlineStates").attr("class", "showLines");
					}
					return false;
		});
			
		});
		$("#stateName").fitText(0.8);
		
		$("#btBack").click(function(){
			$( "#modalHelp" ).removeClass('animated  bounceIn');
			$( "#modalHelp" ).addClass('animated  bounceOutDown');
			return false;
		
		});
		$("#btHelp").click(function(){
			$( "#modalHelp" ).removeClass('animated  bounceOutDown');
			$( "#modalHelp" ).fadeIn( "200" );
			$( "#modalHelp" ).addClass('animated  bounceIn');
			return false;
		});
});
