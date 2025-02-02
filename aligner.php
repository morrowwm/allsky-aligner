<!DOCTYPE html>  
<html>  
	<head>  
		<title>Allsky Constellation Aligner</title> 
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> 
		<style>
			.image {
				position: absolute;
				top: 40px;
				left: 40px;
				//border: 1px solid #000000;
				z-index:1
			}
			.starmap {
				position: absolute;
				top: 40px;
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
		<script  type="text/javascript">
			let virtualSkyData = null; 
			let planetarium = null;
			var [theta, phi, scale_factor, xoffset, yoffset] = [0.0, 0.0, 1.0, 0.0, 0.0];
		</script>
		
		<div class="container" id="working-area" style="width:1000px;"> 
			<div class="navigate">
				<form id="form-file_chooser" class="form-file_chooser" action="" method="post" autocomplete="off">
					<label for="form-imgfilename">Image</label>
					<input type="text" id="form-imgfilename" name="form-imgfile" required autofocus value="test-20250126001520.jpg" size="40">
					<input type="submit" id="loadimage" value="Load">
					<button type="button" id="cw">&#8635;</button>
					<button type="button" id="ccw">&#8634;</button>
					<button type="button" id="bigger">&#10133;</button>
					<button type="button" id="smaller">&#10134;</button>
					<button type="button" id="togglestars">&#9733;</button>
					<button type="button" id="left">&#129052;</button>
					<button type="button" id="right">&#129054;</button>
					<button type="button" id="up">&#129053;</button>
					<button type="button" id="down">&#129055;</button>
				</form>

			</div>
			<script  type="text/javascript">				
				$(document).ready(function () {
					var imagefilename;
					var configData = "configuration.json"
					var ra=0.0; var dec=0.0; var fov=45.0;
					
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
							virtualSkyData.magnitude = 3.0;
							virtualSkyData.showstarlabels = true;
							virtualSkyData.constellations = true;
							virtualSkyData.latitude = 44.803842; 
							virtualSkyData.longitude = -63.62060;
							virtualSkyData.opacity = 0.2;
							//virtualSkyData.fov = 45;
							virtualSkyData.gridlines_eq = true;
							virtualSkyData.gridstep = 10.0;
							virtualSkyData.atmosphere = false;
							virtualSkyData.keyboard = false;
							virtualSkyData.mouse = false;
							virtualSkyData.live = false;  // don't move while working on alignment
							virtualSkyData.clock = new Date("January 26, 2025 00:15:20");

							planetarium = S.virtualsky(virtualSkyData);
							planetarium.updateOrientation(theta,phi, scale_factor, xoffset, yoffset);
							
							console.log("Success reading " + configData + " for example theta: " + virtualSkyData.theta);
						}
					});
					
					$(".navigate").on( "click", function (event) {
						event.preventDefault(); // Prevent default form submission
						event.stopPropagation();
						var navElement = event.target.id;
						
						if(navElement === "cw") {
							theta -= 0.5;
						}
						else if(navElement === "ccw") {
							theta += 0.5;
						}
						else if(navElement === "bigger") {
							scale_factor += 0.02;
						}
						else if(navElement === "smaller") {
							scale_factor -= 0.02;
						}
						else if(navElement === "left") {
							xoffset -= 5;
						}
						else if(navElement === "right") {
							xoffset += 5;
						}
						else if(navElement === "up") {
							yoffset -= 5;
						}
						else if(navElement === "down") {
							yoffset += 5;
						}
						else if(navElement === "togglestars") {
							planetarium.toggleStars();
						}	
						else if(navElement === "loadimage") {
							var imageSrc = $( "#form-imgfilename" ).val();

							console.log("Attempting load of: " + imageSrc);
							$("#working-image").attr("src", imageSrc)
								.attr("height", 760)
								.attr("width", 1014);							
						}
						console.log("Updating sky because of " + navElement, theta, phi, scale_factor);
						planetarium.updateOrientation(theta, phi, scale_factor, xoffset, yoffset);
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

