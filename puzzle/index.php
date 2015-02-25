<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="pragma" content="no-cache" />
	<title>15 Puzzle</title>
	<style>
		div.main{
			margin-top:1%;
		}
		div.row{
			white-space: nowrap;
			
		}
		div.box{
			display: inline-block;
			width: 20vh;
	    	height: 20vh;
			border:1px solid #CECECE;
			margin:2px;
			cursor:pointer;
		}
		div.box>div{
			position: relative;
			top: 50%;
			transform: translateY(-50%);
			font-size:10vh;
			text-align:center;
		}
		fieldset{
			display: inline-block;
			text-align:center;
		}
		div.clear{
			clear:both;
		}
		/*disablke highlight during drag*/
		body{
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			-o-user-select: none;
			user-select: none;
		}
		
		button#history{
			display:block;
			margin-top:1em;
		}
		#historycontent{
			display:none;
			margin-top:1em;
		}
		table,th,td{
			border:1px solid #CECECE;
			text-align:center;
		}
	</style>
	<script>
		function Puzzle(){
			this.status='stop'; 
			this.buttonlabel='start'; //if buttonlabel is stop, button click should start.
			this.duration='00:00';
			this.stepcounter=0;
			this.emploc=16;
			this.movables=new Array();
			this.pickupid;
			this.orderedarr=new Array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
			this.showhistory=true;
			this.buttonhistory='Show History';
			this.historyarr=new Array();
			
			this.showbuttonlabel=function(){
				document.getElementById('startstop').innerHTML=this.buttonlabel;
			};
			this.showbuttonhistory=function(){
				document.getElementById('history').innerHTML=this.buttonhistory;
			};			
			this.showTime=function(){
				document.getElementById('time').innerHTML=this.duration;
			};
			this.showStepcounter=function(){
				document.getElementById('stepcounter').innerHTML=this.stepcounter;
			};
			this.init=function(){
					clearInterval(stopwatch); 
	    			document.getElementById('time').innerHTML='00:00'; 
	    			this.stepcounter=0;
	    			this.showStepcounter();
	    			this.status='stop';  
	    			this.buttonlabel='start';	
	    			this.orderboxes();
	    			this.showbuttonlabel();
			}
			this.timer=function(){
				if(this.status=='stop')
				{
					starttime=Date.now();
					stopwatch = setInterval(function () {calcduration(starttime)}, 1000);	
	    			this.status='start'; 
	    			this.buttonlabel='stop';
	    			this.shuffleboxes();
	    		}
	    		else{  
					this.init();
	    		}		
	    		this.showbuttonlabel();			
			};
			this.getMovable=function(id){
				this.movables[0]=parseInt(id)-1;
				this.movables[1]=parseInt(id)+1;
				this.movables[2]=parseInt(id)-4;
				this.movables[3]=parseInt(id)+4;
			}
			this.boxpickup=function(id){
				if(!this.validateBoxPickup(id))
				{
					alert('The selected box cannot be moved.');
				}
			}
			this.boxdrop=function(id){
				if(this.validateBoxDrop(id))
				{
					document.getElementById(id).innerHTML=document.getElementById(this.pickupid).innerHTML;
					document.getElementById(this.pickupid).innerHTML="<div>&nbsp;</div>";
					this.emploc=this.pickupid;
					this.getMovable(this.pickupid);
					this.stepcounter++;
					this.showStepcounter();
					//check if it's all ordered
					if(this.chkComplete())
					{
						this.save();
						alert('Congratulations!  You completed the puzzle.')
						//initialize
						this.init();
						
					}
				}
				else
				{
					alert('The box cannot be dropped there.');
				}
			}
			this.validateBoxPickup=function(id){
				var match=this.movables.indexOf(parseInt(id));
				if (match>=0)
				{
					this.pickupid=id;
					return true;
				}
				else
				{
					return false;
				}
			}
			this.validateBoxDrop=function(id){
				if(parseInt(id)==parseInt(this.emploc))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			this.getBoxes=function(){
				return boxes=document.getElementsByClassName("box");
			}
			this.orderboxes=function(){
				boxes=this.getBoxes();
				for(i=0;i<boxes.length;i++)
				{
					if(i==15)
					{
						boxes[i].innerHTML="<div>&nbsp;</div>";
						this.emploc=i+1;
						this.getMovable(this.emploc);
					}
					else
					{
						index=i+1;
						boxes[i].innerHTML="<div>"+index+"</div>";
					}
				}				
			}
			this.shuffleboxes=function(){
				randomarr=shuffle(this.orderedarr);
				boxes=this.getBoxes();
				for(i=0;i<boxes.length;i++)
				{
					if(randomarr[i]==16)
					{
						boxes[i].innerHTML="<div>&nbsp;</div>";
						this.emploc=i+1;
						this.getMovable(this.emploc);
					}
					else
					{
						boxes[i].innerHTML="<div>"+randomarr[i]+"</div>";
					}
				}
			}
			this.chkComplete=function(){
				boxes=this.getBoxes();
				for(i=0;i<boxes.length;i++)
				{
					
					index=i+1;
					if(i==15)
					{
						if(boxes[i].innerHTML!="<div>&nbsp;</div>")
						{
							return false;
						}
					}
					else
					{
						if(boxes[i].innerHTML!="<div>"+index+"</div>")
						{
							return false;
						}						
					}
				}
				return true;
			}
			this.save=function(){
				
				if(lsTest() === true){
					this.getHistory();
					var tosave={"duration":document.getElementById('time').innerHTML,"stepcounter":this.stepcounter};
					this.historyarr.push(tosave);
					var savejson=JSON.stringify(this.historyarr);
					localStorage.setItem('history', savejson);
				}else{
					alert('Local storage is not supported.');
				}				
			}
			this.history=function(){
				if(this.showhistory) //history content is not being shown, so show it.
				{
					document.getElementById('historycontent').style.display='block';
					this.showhistory=false;
					this.buttonhistory='Close History';
					this.showHistory();
				}
				else
				{
					document.getElementById('historycontent').style.display='none';
					this.showhistory=true;
					this.buttonhistory='Show History';					
				}
				this.showbuttonhistory();
			}
			this.getHistory=function(){
				historycontent=localStorage.getItem('history');
				histobj = JSON.parse(historycontent);
				if(histobj!=null)
				{
					for(i=0;i<histobj.length;i++)
					{
						this.historyarr[i]=histobj[i];
					}
				}
			}	
			this.showHistory=function(){
				this.getHistory();
				
				if(this.historyarr!=null&&this.historyarr.length>0)
				{
					output="<table><th>Time</th><th>Step Count</th>";
					index=this.historyarr.length-1;
					for(i=index;i>=0;i--)
					{
						output+="<tr><td>"+this.historyarr[i].duration+"</td><td>"+this.historyarr[i].stepcounter+"</td></tr>";
					}	
					output+="</table>";
					}
				else
				{
					output="No success history.";
				}
				document.getElementById('historycontent').innerHTML=output;		
					
			}	

			this.showbuttonlabel();
			this.showbuttonhistory();
			this.showTime();
			this.showStepcounter();
			this.getMovable(this.emploc);
		}

		function calcduration(starttime){
			duration=Date.now()-starttime; 
			seconds=duration/1000;
			mins=Math.floor(seconds/60);
			secremainder=seconds-(mins*60); 
			mm=addZero(Math.floor(mins));
			ss=addZero(Math.floor(secremainder));
			document.getElementById('time').innerHTML=mm+':'+ss; 
		}

		function addZero(i) {
		    if (i < 10) {
		        i = "0" + i;
		    }
		    return i;
		}
		
		function shuffle(array) {
		  var currentIndex = array.length, temporaryValue, randomIndex ;
		
		  while (0 !== currentIndex) {
		    randomIndex = Math.floor(Math.random() * currentIndex);
		    currentIndex -= 1;
		    temporaryValue = array[currentIndex];
		    array[currentIndex] = array[randomIndex];
		    array[randomIndex] = temporaryValue;
		  }
		
		  return array;
		}
		
		function lsTest(){
		    var test = 'test';
		    try {
		        localStorage.setItem(test, test);
		        localStorage.removeItem(test);
		        return true;
		    } catch(e) {
		        return false;
		    }
		}		
				
	</script>
</head>
<body>
	<button id='startstop'></button>
	<fieldset>
		<legend>Timer</legend>
		<div id='time'></div>
	</fieldset>
	<fieldset>
		<legend>Step Counter</legend>
		<div id='stepcounter'></div>
	</fieldset>
	<button id='history'></button>
	<!--<button id='forcesave'>Force Save</button>-->
	<div id='historycontent'></div>
	<div class='main'>
		<div class='row'>
		<div class='box' id='1'><div>1</div></div>
		<div class='box' id='2'><div>2</div></div>
		<div class='box' id='3'><div>3</div></div>
		<div class='box' id='4'><div>4</div></div>
		</div>
		<div class='row'>
		<div class='box' id='5'><div>5</div></div>
		<div class='box' id='6'><div>6</div></div>
		<div class='box' id='7'><div>7</div></div>
		<div class='box' id='8'><div>8</div></div>	
		</div>
		<div class='row'>
		<div class='box' id='9'><div>9</div></div>
		<div class='box' id='10'><div>10</div></div>		
		<div class='box' id='11'><div>11</div></div>	
		<div class='box' id='12'><div>12</div></div>	
		</div>
		<div class='row'>
		<div class='box' id='13'><div>13</div></div>	
		<div class='box' id='14'><div>14</div></div>	
		<div class='box' id='15'><div>15</div></div>	
		<div class='box' id='16'><div>&nbsp;</div></div>	
		</div>																											
	</div>
	<script>	
		//localStorage.removeItem('history');
		puzzle=new Puzzle();
		
		var startstop = document.getElementById("startstop");
		startstop.addEventListener("click", function(){puzzle.timer()},false);		
		
		var box=document.getElementsByClassName("box");
		for(i=0;i<box.length;i++){
			box[i].addEventListener("mousedown", function(){puzzle.boxpickup(this.id)},false);	
			box[i].addEventListener("mouseup", function(){puzzle.boxdrop(this.id)},false);	
		}
		
		var hist = document.getElementById("history");
		hist.addEventListener("click", function(){puzzle.history()},false);	
		
		/* for debugging save 
		var forcesave = document.getElementById("forcesave");
		forcesave.addEventListener("click", function(){puzzle.save()},false);	
		*/
					
	</script>
</body>
</html>