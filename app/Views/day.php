<div id="static_guide">
 <ul class="menu1">
		<li><a href="<?php 
#echo base_url()
echo "/";
?>">Home</a></li>
 </ul>
 <ul class="menu2">
<?php
foreach ($years as $year_dir)
{
	if ($year != $year_dir)
	{
		print "<li><a href=/gallery/show_year/$year_dir>$year_dir</a></li>\n";
	}
	else
	{
		print "<li class=\"current_year\"><a href=/gallery/show_year/$year_dir>$year_dir</a></li>\n";
	}
}
?>
 </ul>
</div>

<?php
	print "<h1 id=\"gallery_header\">";
	if ($title != $prev_day) {
		print "<a href=\"/gallery/show_day/$year/$prev_day\"><img src=\"/Photos/skip-back-fill.png\" alt=\"Prev Day<<<\"/></a>";
	}
	print "$title";
	if ($title != $next_day) {
		print "<a href=\"/gallery/show_day/$year/$next_day\"><img src=\"/Photos/skip-forward-fill.png\" alt=\">>>Next Day\"/></a>";
	}
	print "</h1>\n";
?>

<div id="day_guide">
<ul class="menu1">
<?php
foreach ($days[$year] as $this_day)
{
	$this_day = basename($this_day);
	if ( ! isset($desc[$this_day]))
	{
		$desc[$this_day] = $this_day;
	}
	if ($this_day == $day)
	{
		print "  <li class=\"current_day\"><a href=\"/gallery/show_day/$year/$this_day\">" . $desc[$this_day] . "</a></li>\n";
	}
	else
	{
		print "  <li><a href=\"/gallery/show_day/$year/$this_day\">" . $desc[$this_day] . "</a></li>\n";
	}
}
?>
</ul>
</div>

<div id="thumb_div">
<?php

foreach ($images as $image)
{
	$image_path = "$photo_root/$year/$day/$image";
	if ( is_file("$image_path.gif") )
	{
		print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$image.gif\" alt=\"$image\" /></a>\n";
	}
	elseif ( is_file("$image_path.png") )
	{
		print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$image.png\" alt=\"$image\" /></a>\n";
	}
	elseif ( is_file("$image_path.mp4") )
	{
		print "<video width=\"320\" controls border=\"10\"><source src=\"/Photos/$year/$day/$image.mp4\" type=\"video/mp4\"></video>\n";
	}
	elseif ( is_file("$image_path.MP4") )
	{
		print "<video width=\"320\" controls border=\"10\"><source src=\"/Photos/$year/$day/$image.MP4\" type=\"video/mp4\"></video>\n";
	}
	elseif ( is_file("$image_path.jpg") )
	{
		print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$image.jpg\" alt=\"$image\" width=\"320\" /></a>\n";
	}
	elseif ( is_file("$image_path.JPG") )
	{
		print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$image.JPG\" alt=\"$image\" width=\"320\" /></a>\n";
	}
}
?>

