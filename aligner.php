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
			#form-file_chooser {
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
		<div class="container" style="width:1000px;">  
			<h3>Constellation Aligner</h3>   
			<form id="form-file_chooser" class="form-file_chooser" action="" method="post" autocomplete="off">
				<label for="form-imgfile">images/20250124/image-20250125021912.jpg</label>
				<input type="text" id="form-imgfilename" name="form-imgfile" required autofocus value="mages/20250124/image-20250125021912.jpg" size="48">
				<button type="submit" class="cw" role="button">CW</button>
				<button type="submit" class="ccw" role="button">CCW</button>
				<button type="submit" class="up" role="button">U</button>
				<button type="submit" class="down" role="button">D</button>
				<button type="submit" class="left" role="button">L</button>
				<button type="submit" class="right" role="button">R</button>
			</form>
			<script  type="text/javascript">
				$(document).ready(function () {
					var planetarium;
					const imageInput = $("form-imgfilename");
					
					$('#form-file_chooser').submit(function (event) {
						event.preventDefault(); // Prevent default form submission
						var data = $("#form-file_chooser :input").serializeArray();
						console.log(data); //use the console for debugging, F12 in Chrome, not alerts
					});
					
					$('#form-imgfilename').change(function (e) {
						console.log("input changed " + e.target)
						$("#working-image").attr("src", '/images/20250124/image-20250125021912.jpg')
							.attr("height", 760)
							.attr("width", 1014);
					});
					
					planetarium = S.virtualsky({
						id: 'starmap',	// This should match the ID used in the DOM
						transparent: true,
						color:'rgb(0,255,255)',
						scalestars: 5,
						showstarlabels: true,
						constellations: true,
						latitude: 44.803842, 
						longitude: -63.62060,
						clock: new Date("March 05, 2024 03:31:02")
					});
					$("#starmap")
					.css("margin-top", -1000 + "px")
					.css("margin-left", -1000 + "px");
				});
			</script>
			
			<div id="imageContainer" class="image" style="max-width: 2000px">
				<div id="live_container" class="live" style="z-index:1">
					<img title="allsky image" alt="allsky image" id="working-image" class="working-image" src="#"  alt="image" style="margin-right: -100%">
				</div>
				<div id="starmap_container" class="starmap">
					<div id="starmap" style="width:3300px;height:3200px"></div>
				</div>
			</div>
			
		</div>  
	</body>  
</html>  

