<!DOCTYPE html>  
<html>  
	<head>  
		<title>Allsky Constellation Aligner</title> 
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> 
		<style>
			.image {
				position: absolute;
				top: 80px;
				left: 40px;
				//border: 1px solid #000000;
				z-index:1
			}
			.starmap {
				position: absolute;
				top: 80px;
				left: 40px;
				border: 1px solid #000000;
				z-index:5
			}
			.navigate {
				position:absolute; 
				top: 0px
				left: 200px;
				z-index:10
			}
		</style>
	</head>  
	<body>  
		<script src="virtualsky/stuquery.js"></script>
		<script src="virtualsky/virtualsky.js"></script>
		
		<div class="container" id="working-area" style="width:1000px;"> 
			<div class="navigate">
				<form action="aligner.php" method="post">
					<label for="imgfilename">Image</label>
					<input type="text" id="imgfilename" name="imgfilename" value = "http://192.168.0.167/test-20250126001520.jpg">
					<input type="submit" id="loadimage" name="loadimage" value="Load">
					<button type="button" id="origin" title="Set rotation origin">&#128907;</button>
					<button type="button" id="cw">&#8635;</button>
					<button type="button" id="ccw">&#8634;</button>
					<button type="button" id="bigger">&#43;</button>
					<button type="button" id="smaller">&#8722;</button>
					<button type="button" id="togglestars" title="Toggle skymap">&#9733;</button>
					<button type="button" id="left">&#129052;</button>
					<button type="button" id="right">&#129054;</button>
					<button type="button" id="up">&#129053;</button>
					<button type="button" id="down">&#129055;</button>
					<button type="button" id="slower" title="Decrease step">&#129052;&#129052;</button>
					<button type="button" id="faster" title="Increase step">&#129054;&#129054;</button>
					<br>
					<label for="xorigin">Origin X</label>
					<input type="text" id="xorigin" name="xorigin" value="0.0" size="6">
					<label for="yorigin">Y</label>
					<input type="text" id="yorigin" name="yorigin" value="0.0" size="6">
					<label for="theta">Rotation</label>
					<input type="text" id="theta" name="theta" value="0.0" size="6">
					<label for="scale_factor">Scale</label>
					<input type="text" id="scale_factor" name="scale_factor" value="1.0" size="6">
					<label for="xoffset">Offset X</label>
					<input type="text" id="xoffset" name="xoffset" value="0.0" size="6">
					<label for="yoffset">Y</label>
					<input type="text" id="yoffset" name="yoffset" value="0.0" size="6">
					<label for="step_size">              Step size</label>
					<input type="text" id="step_size" name="step_size" value="1.0" size="6">
					
				</form>

			</div>
			
			<script type="text/javascript">
			
				$(document).ready(function () {
					
					let virtualSkyData = null; 
					let planetarium = null;		
					
					var aligner = {};
					aligner.theta = 0.0;
					aligner.phi = 0.0; //TODO this is unused?
					aligner.scale_factor=1.0;
					aligner.xoffset = 0.0; 
					aligner.yoffset = 0.0; 
					aligner.xorigin = 0.0; 
					aligner.yorigin = 0.0;

					var step_size = 5.0;
					var origin_mode = false;
					var file_datetime = new Date();
				
					var imagefilename;
					var configData = "configuration.json"
	
					$.ajax({
						// No need for ?_ts=   since $.ajax adds one
						url: configData,
						cache: false,
						dataType: 'json',
						error: function(jqXHR, textStatus, errorThrown) {
							// console.log("jqXHR=", jqXHR);
							// console.log("textStatus=" + textStatus + ", errorThrown=" + errorThrown);
							// TODO: Display the message on the screen.
							if (jqXHR.status == 404) {
								console.log(configData + " not found!");
							} else {
								console.log("Error reading '" + configData + "': " + errorThrown);
							}
						},
						success: function (data) {
							var c = data.config;
							virtualSkyData = c;
							virtualSkyData.width = virtualSkyData.overlayWidth;
							virtualSkyData.height = virtualSkyData.overlayHeight;

							virtualSkyData.id = 'starmap';	// This should match the ID used in the DOM
							virtualSkyData.transparent = true;
							//virtualSkyData.projection = "gnomic";
							virtualSkyData.color = 'rgb(0,120,120)';
							virtualSkyData.scalestars = 1;
							virtualSkyData.magnitude = 4.0;
							virtualSkyData.constellations = true;
							virtualSkyData.showstars = true;
							virtualSkyData.showstarlabels = true;
							virtualSkyData.showplanets = true;
							virtualSkyData.showplanetlabels  = true;
							virtualSkyData.latitude = 44.803842; 
							virtualSkyData.longitude = -63.62060;
							virtualSkyData.opacity = 0.5;
							//virtualSkyData.fov = 45;
							virtualSkyData.gridlines_eq = true;
							virtualSkyData.gridstep = 10.0;
							virtualSkyData.atmosphere = false;
							virtualSkyData.keyboard = false;
							virtualSkyData.mouse = false;
							virtualSkyData.live = false;  // don't move while working on alignment
							
							planetarium = S.virtualsky(virtualSkyData);
							planetarium.updateOrientation(aligner, file_datetime);
							
							console.log("Success reading " + configData + " for example theta: " + virtualSkyData.theta);
						}
					});
					
					$(".starmap").on( "click", function (event) {
						event.preventDefault(); // Prevent default form submission except file chooser
						event.stopPropagation();

						if(origin_mode){
							origin_mode = false;
							$('html,body').css('cursor','default');
							
							aligner.xorigin = event.pageX - this.offsetLeft;
							aligner.yorigin = event.pageY - this.offsetTop;
							
							$('#xorigin').val(aligner.xorigin);
							$('#yorigin').val(aligner.yorigin);
						}
					});
					
					$(".navigate").on( "click", function (event) {
						event.preventDefault(); // Prevent default form submission except file chooser
						event.stopPropagation();
						
						var navElement = event.target.id;

						if(navElement === "origin") {
							if(origin_mode){
								origin_mode = false;
								$('html,body').css('cursor','default');
							}
							else {
								origin_mode = true;
								$('html,body').css('cursor','crosshair');
							}
						}
						else if(navElement === "cw") {
							aligner.theta -= 0.1 * step_size;
						}
						else if(navElement === "ccw") {
							aligner.theta += 0.1 * step_size;
						}
						else if(navElement === "bigger") {
							aligner.scale_factor += 0.02;
						}
						else if(navElement === "smaller") {
							aligner.scale_factor -= 0.02;
						}
						else if(navElement === "left") {
							aligner.xoffset -= 1 * step_size;
						}
						else if(navElement === "right") {
							aligner.xoffset += 1 * step_size;
						}
						else if(navElement === "up") {
							aligner.yoffset -= 1 * step_size;
						}
						else if(navElement === "down") {
							aligner.yoffset += 1 * step_size;
						}
						else if(navElement === "togglestars") {
							planetarium.toggleStars(); 
							planetarium.toggleStarLabels(); 
							planetarium.toggleConstellationLines();
							planetarium.togglePlanetLabels();
						}	
						else if(navElement === "faster") {
							step_size = (1.2 * step_size).toFixed(3);
						}	
						else if(navElement === "slower") {
							step_size = (0.86 * step_size).toFixed(3);
							if(step_size < 1.0) step_size = 1.0;
						}	
						else if(navElement === "loadimage") {
							var imageSrc = $( "#imgfilename" ).val();
							// file names end in 20250126001520.jpg
							let s = imageSrc.substring(imageSrc.length-18, imageSrc.length-4);
							// convert to javascript preferred YYYY-MM-DDTHH:mm:ss
							// this will be interpreted as local time, not UTC
							// apparently using Date.parse is a bad idea. Use integer datetime parts
							
							let img_year = Number(s.substr(0,4));
							let img_month = Number(s.substr(4,2)) - 1; // indexed from 0
							let img_day = Number(s.substr(6,2));
							let img_hour = Number(s.substr(8,2));
							let img_minute = Number(s.substr(10,2));
							let img_second = Number(s.substr(12,2));
							
							file_datetime = new Date(img_year, img_month, img_day, img_hour, img_minute, img_second);

							console.log("Attempting load of: " + imageSrc);
							$("#working-image").attr("src", imageSrc)
								.attr("height", 760)
								.attr("width", 1014);		
						}
						console.log("Updating sky because of " + navElement, aligner, file_datetime);
						planetarium.updateOrientation(aligner, file_datetime);
						
						//update displayed orientation parameters 
						$('#theta').val(aligner.theta.toFixed(2));
						$('#scale_factor').val(aligner.scale_factor.toFixed(2));
						$('#xoffset').val(aligner.xoffset.toFixed(0));
						$('#yoffset').val(aligner.yoffset.toFixed(0));
						
						$('#step_size').val(step_size);
					});
				});
			</script>
			
			<div id="image_container" class="image">
				<img title="allsky image" alt="allsky image" id="working-image" class="working-image" src="#" alt="image">
			</div>
			<div id="starmap_container" class="starmap">
				<div id="starmap" style="width:3000px;height:3000px"></div>
			</div>			
		</div>
	</body>  
</html>  

