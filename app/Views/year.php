<div id="static_guide">
 <ul class="menu1">
		<li><a href="<?php /*echo base_url(); */ echo "/";?>">Home</a></li>
 </ul>
 <ul class="menu2">
<?php
    foreach ($years as $year_dir)
    {
        if ($year != $year_dir)
        {
            #print "<li><a href=" . site_url("gallery/show_year/$year_dir") . ">$year_dir</a></li>\n";
            print "<li><a href=/gallery/show_year/$year_dir>$year_dir</a></li>\n";
        }
        else
        {
            #print "<li class=\"current_year\"><a href=" . site_url("gallery/show_year/$year_dir") . ">$year_dir</a></li>\n";
            print "<li class=\"current_year\"><a href=/gallery/show_year/$year_dir>$year_dir</a></li>\n";
        }
    }
?>
 </ul>
</div>

<h1 id="gallery_header"><?php echo $title?></h1>

<div id="day_guide">
<ul class="menu1">
<?php
    foreach ($days[$year] as $day)
    {
        $day = basename($day);
        if (isset($desc[$day]))
        {
            print "  <li><a href=\"/gallery/show_day/$year/$day\">" . $desc[$day] . "</a></li>\n";
        }
        else
        {
            print "  <li><a href=\"/gallery/show_day/$year/$day\">$day</a></li>\n";
        }
    }
?>
</ul>
</div>

<div id="thumb_div">
<?php
if (isset($featured))
{
    foreach ($featured as $image)
    {
        $path = explode('/', $image);
        $year = $path[1];
        $day = $path[2];
        $image = $path[3];
        $gif = "$image.gif";
        print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$gif\" alt=\"$image\" /></a>\n";
    }
}
?>

