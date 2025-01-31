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
			var [az, el, w, h] = [0.0, 0.0, 0.0, 0.0];
		</script>
		
		<div class="container" id="working-area" style="width:1000px;"> 
			<div class="navigate">
				<form id="form-file_chooser" class="form-file_chooser" action="" method="post" autocomplete="off">
					<label for="form-imgfilename">Image</label>
					<input type="text" id="form-imgfilename" name="form-imgfile" required autofocus value="mages/20250124/image-20250125021912.jpg" size="32">
					<input type="submit" id="loadimage" value="Load">
					<button type="button" id="cw" value = "CW">&#8635;</button>
					<button type="button" id="ccw" value = "CCW">&#8634;</button>
					<button type="button" id="up" value = "U">&#11014;</button>
					<button type="button" id="down" value = "D">&#11015;</button>
					<button type="button" id="left" value = "L">&#11013;</button>
					<button type="button" id="right" value = "R">&#10145;</button>
					<button type="button" id="bigger" value = "R">&#10133;</button>
					<button type="button" id="smaller" value = "R">&#10134;</button>
				</form>

			</div>
			<script  type="text/javascript">				
				$(document).ready(function () {
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

							virtualSkyData.id = 'starmap',	// This should match the ID used in the DOM
							virtualSkyData.transparent = true,
							virtualSkyData.color = 'rgb(0,120,120)',
							virtualSkyData.scalestars = 3,
							virtualSkyData.showstarlabels = true,
							virtualSkyData.constellations = true,
							virtualSkyData.latitude = 44.803842, 
							virtualSkyData.longitude = -63.62060,
							virtualSkyData.opacity = 0.5,
							virtualSkyData.atmosphere = false,
							virtualSkyData.keyboard = false,
							virtualSkyData.mouse = false,
							virtualSkyData.live = false,  // don't move while working on alignment
							virtualSkyData.clock = new Date("January 05, 2025 02:19:12")

							planetarium = S.virtualsky(virtualSkyData);
							[az, el, w, h] = planetarium.getOrientation();
							console.log("Success reading " + configData + " for example az: " + virtualSkyData.az);
						}
					});
					
					$(".navigate").on( "click", function (event) {
						event.preventDefault(); // Prevent default form submission
						event.stopPropagation();
						var navElement = event.target.id;
						console.log("input clicked", navElement, " value: ", navElement);
						if(navElement === "up") {
							console.log("y translate");
							virtualSkyData.overlayOffsetTop = virtualSkyData.overlayOffsetTop - 10;
						}
						else if(navElement === "down") {}
						else if(navElement === "left") {}
						else if(navElement === "right") {}
						else if(navElement === "cw") {
							az = az + 0.1; // to do
						}
						else if(navElement === "ccw") {
							az = az - 0.1;
						}
						else if(navElement === "bigger") {
							w = w + 50;
							virtualSkyData.wide = virtualSkyData.wide + 50;
						}
						else if(navElement === "smaller") {
							w = w - 50;
							virtualSkyData.wide = virtualSkyData.wide - 50;
						}
						
						else if(navElement === "loadimage") {
							var imageSrc = $( "#form-imgfilename" ).val();
							
							
							console.log("Attempting load of: " + imageSrc);
							$("#working-image").attr("src", imageSrc)
								.attr("height", 760)
								.attr("width", 1014);
							
						}
						console.log("Updating sky because of " + navElement);
						planetarium.updateOrientation(az,el,w,h);
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

