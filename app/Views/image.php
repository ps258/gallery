<script language="javascript" src="/CSS/jquery.min.js"></script>
<script language="javascript" src="/CSS/jquery.dimensions.min.js"></script>
<script language="javascript">
// Floating menu code
// From http://net.tutsplus.com/tutorials/html-css-techniques/creating-a-floating-html-menu-using-jquery-and-css/
var name = "#floating_guide";
var menuYloc = null;
$(document).ready(function(){
        menuYloc = parseInt($(name).css("top").substring(0,$(name).css("top").indexOf("px")))
        $(window).scroll(function () {
            var offset = menuYloc+$(document).scrollTop()+"px";
            $(name).animate({top:offset},{duration:500,queue:false});
            });
        });
</script>

<div id="floating_guide">
 <ul class="menu1">
		<li><a href="<?php /*echo base_url(); */ echo "/"; ?>">Home</a></li>
 </ul>
 <ul class="menu2">
		<li><a href="<?php /*echo site_url("gallery/show_year/$year"); */ echo "/gallery/show_year/$year"; ?>"><?php echo 'Up to: ' . $year?></a></li>
		<li><a href="<?php /* echo site_url("gallery/show_day/$year/$day"); */ echo "/gallery/show_day/$year/$day"; ?>"><?php echo 'Up to: ' . $day?></a></li>
 </ul>
 <ul class="menu3">
 <?php if ($prev_image != $this_image) { ?>
		<li><a href="<?php /* echo site_url("gallery/show_image/$year/$day/$prev_image"); */ echo "/gallery/show_image/$year/$day/$prev_image"; ?>"><?php echo 'Prev: ' .$prev_image?></a></li>
 <?php } ?>
 <?php if ($next_image != $this_image) { ?>
		<li><a href="<?php /* echo site_url("gallery/show_image/$year/$day/$next_image"); */ echo "/gallery/show_image/$year/$day/$next_image"; ?>"><?php echo 'Next: ' .$next_image?></a></li>
 <?php } ?>
 </ul>
</div>
<!--
<h1 id="page_header"><?php echo $title?></h1>
-->

<div id="image_div">
<?php
    switch ($extention)
    {
        case 'jpg':
        case 'JPG':
            try {
              $exif = exif_read_data("/var/www/html/gallery/public/Photos/$year/$day/$image", 'IFD0');
            }
            catch (Exception $exp) {
              $exif = false;
            }
            list($width, $height, $type, $attr) = getimagesize("/var/www/html/gallery/public/Photos/$year/$day/$image");
            $middle_left = ($width/2)-1;
            $middle_right = $middle_left+1;
            print "<img class=\"full_size\" src=\"/Photos/$year/$day/$image\" usemap=\"#nextimage\">\n";
            #print "<img class=\"full_size\" src=\"/Photos/$year/$day/$image\">\n";
            #$next_url=site_url("gallery/show_image/$year/$day/$next_image");
            $next_url="/gallery/show_image/$year/$day/$next_image";
            #$prev_url=site_url("gallery/show_image/$year/$day/$prev_image");
            $prev_url="/gallery/show_image/$year/$day/$prev_image";
            print "<map name=\"nextimage\"><area shape=\"rect\" coords=\"0,0,$middle_left,$height\" href=\"$prev_url\"/><area shape=\"rect\" coords=\"$middle_right,0,$width,$height\" href=\"$next_url\"/></map>\n";
            if ( $exif )
            {
                $exif = exif_read_data("/var/www/html/gallery/public/Photos/$year/$day/$image", 0, true);
                print "<p></p>\n";
                print "<ul>\n";
                print "<li><a href=\"/Photos/$year/$day/$image\">Download $image</a></li>\n";
                if (isset($exif['EXIF']['DateTimeOriginal']))
                {
                    $datetimeoriginal = $exif['EXIF']['DateTimeOriginal'];
                    print "<li>Date: $datetimeoriginal</li>\n";
                }
                if (isset($exif['IFD0']['Make']))
                {
                    $make = $exif['IFD0']['Make'];
                    $model = str_replace($make,'',$exif['IFD0']['Model']);
                    print "<li>$make:- $model</li>\n";
                }
                if (isset($exif['EXIF']['ExposureTime']))
                {
                    $exposure = $exif['EXIF']['ExposureTime'].' sec';
                    print "<li>Exposure: $exposure</li>\n";
                }
                if (isset($exif['COMPUTED']['ApertureFNumber']))
                {
                    $fstop = $exif['COMPUTED']['ApertureFNumber'];
                    print "<li>fstop: $fstop</li>\n";
                }
                if (isset($exif['EXIF']['ISOSpeedRatings']))
                {
                    $iso = $exif['EXIF']['ISOSpeedRatings'];
                    print "<li>ISO: $iso</li>\n";
                }
                if (isset($exif['MAKERNOTE']['UndefinedTag:0x0095']))
                {
                    $lens = $exif['MAKERNOTE']['UndefinedTag:0x0095'];
                    print "<li>Lens: $lens</li>\n";
                }
                if (isset($exif['EXIF']['FocalLength']))
                {
                    $focallength = intval($exif['EXIF']['FocalLength']).'mm';
                    print "<li>Focal Length: $focallength</li>\n";
                }
                print "<li>Height: $height</li><li>Width: $width</li>\n";
                print "</ul>\n";
                //foreach ($exif as $key => $section)
                //{
                //    foreach ($section as $name => $val)
                //    {
                //        echo "$key.$name: $val<br />\n";
                //    }
                //}
            }
            break;
        case 'MP4':
        case 'mp4':
					#print "<embed class=\"thumb\" height=\"264\" width=\"325\" border=\"1\" src=\"/Photos/$year/$day/$image\" name=\"$image\" loop=\"false\" controller=\"true\" autoplay=\"false\">\n";
					print "<video height=\"60%\" width=\"60%\" controls><source src=\"/Photos/$year/$day/$image\"></video>";
					print "<p></p>\n";
					print "<ul>\n";
					print "<li><a href=\"/Photos/$year/$day/$image\">Download $image</a></li>\n";
					print "</ul>\n";
					break;
		}
?>
