<div
style='
color: #ffffff; 
background-color: rgba(158, 158, 158, 0.37); 
border: solid 2px rgba(0, 0, 0, 0.07); 
width: 100%; 
height: 600px; 
overflow: scroll;
overflow_x: hidden; 
scrollbar-face-color: #889B9F;
scrollbar-shadow-color: #3D5054;
scrollbar-highlight-color: #C3D6DA;
scrollbar-3dlight-color: #3D5054;
scrollbar-darkshadow-color: #85989C;
scrollbar-track-color: #95A6AA;
scrollbar-arrow-color: #FFD6DA;
'>	
<?php
		foreach($log as $row)
		{
			echo "<p>"
				 . date("[Y-m-d H:i:s] ",$row['time'])
			     . $row['user']
				 . "："
				 . $row['log']
				 . "</p>";
		}
	?>
</div>