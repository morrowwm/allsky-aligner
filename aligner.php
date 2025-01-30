<!DOCTYPE html>  
<html>  
	<head>  
		<title>Allsky Constellation Aligner</title> 
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> 
		<style>
			.image {
				position: relative;
				top: 0;
				left: 0;
			}
			.live {
				position: relative;
				top: 100;
				left: 100;
				border: 1px solid #000000;
				z-index:1
			}
			.starmap {
				position: absolute;
				top: -1200px;
				left: -300px;
				border: 1px solid #000000;
				z-index:5
			}
			.navigate {
				position:absolute; 
				left: 0;
				display:inline-block;
				z-index:10
			}
		</style>
	</head>  
	<body>  
		<script src="virtualsky/stuquery.js"></script>
		<script src="virtualsky/virtualsky.js"></script>
		<div class="container" id="working-area" style="width:1000px;"> 
				<h3>Constellation Aligner</h3>  
			<div class="navigate">
				<form id="form-file_chooser" class="form-file_chooser" action="" method="post" autocomplete="off">
					<label for="form-imgfile">Image </label>
					<input type="text" id="form-imgfilename" name="form-imgfile" required autofocus value="mages/20250124/image-20250125021912.jpg" size="48">
					<input type="submit" id="loadimage" value="Load">
				</form>
			
				<button type="button" id="cw" value = "CW">CW</button>
				<button type="button" id="ccw" value = "CCW">CCW</button>
				<button type="button" id="up" value = "U">U</button>
				<button type="button" id="down" value = "D">D</button>
				<button type="button" id="left" value = "L">L</button>
				<button type="button" id="right" value = "R">R</button>
			</div>
			<script  type="text/javascript">
				$(document).ready(function () {
					var planetarium;
					var imagefilename;
					
					$(".navigate").on( "click", function (event) {
						event.preventDefault(); // Prevent default form submission
						event.stopPropagation();
						var navElement = event.target.id;
						console.log("input clicked", navElement, " value: ", navElement);
						if(navElement === "up"){
							console.log("y translate");
						}
						if(navElement === "loadimage"){
							var imageSrc = $( "#form-imgfilename" ).val();
							
							console.log("Attempting load of: " + imageSrc);
							$("#working-image").attr("src", imageSrc)
								.attr("height", 760)
								.attr("width", 1014);
						}
					});
					
					planetarium = S.virtualsky({
						id: 'starmap',	// This should match the ID used in the DOM
						transparent: true,
						color:'rgb(0,120,120)',
						scalestars: 5,
						projection: 'allsky_aligner',
						showstarlabels: true,
						constellations: true,
						latitude: 44.803842, 
						longitude: -63.62060,
						clock: new Date("January 05, 2025 02:19:12")
					});
					$("#starmap")
					.css("margin-top", -1000 + "px")
					.css("margin-left", -1000 + "px");
				});
			</script>
			
			<div id="imageContainer" class="image" style="max-width: 2000px">
				<div id="live_container" class="live">
					<img title="allsky image" alt="allsky image" id="working-image" class="working-image" src="#"  alt="image" style="margin-right: -100%">
				</div>
				<div id="starmap_container" class="starmap">
					<div id="starmap" style="width:3300px;height:3200px"></div>
				</div>
			</div>
			
		</div>  
	</body>  
</html>  

