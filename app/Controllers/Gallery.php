<?php

namespace App\Controllers;

class Gallery extends BaseController {

  private $photo_root = '/var/www/html/gallery/public/Photos';

  function Gallery()
  {
    parent::Controller();
  }

  private function _load_featured($path)
  {
    // read the directory descriptions
    $data = array();
    $featured_path = $path . '/featured.txt';
    if (is_file($featured_path))
    {
      $images = file($featured_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($images as $line_num => $line)
      {
        $data[] = $line;
      }
      return $data;
    }
    else
    {
      // there isn't a featured.txt file
    }
  }

  private function _load_desc()
  {
    // read the directory descriptions
    $data = array();
    $descriptions = file($this->photo_root.'/dirs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($descriptions as $line_num => $line)
    {
      $desc = explode('%%', $line);
      $data[basename($desc[0])] = $desc[1];
    }
    return $data;
  }

  private function _find_desc($day)
  {
    // read the directory descriptions
    $data = array();
    $descriptions = file($this->photo_root.'/dirs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($descriptions as $line_num => $line)
    {
      $desc = explode('%%', $line);
      $desc_day = basename($desc[0]);
      if ($desc_day == $day)
      {
        return $desc[1];
      }
    }
    return $day;
  }

  function index()
  {
    $data['title'] = 'Welcome to the Stubbs Family Photo Gallery';
    $data['featured'] = $this->_load_featured($this->photo_root);
    foreach (array_reverse(array_filter(glob($this->photo_root.'/*'), 'is_dir')) as $year_dir)
    {
      $year = basename($year_dir);
      break;
    }
    $this->show_year($year);
  }

  function oldindex()
  {
    $data['title'] = 'Welcome to the Stubbs Family Photo Gallery';
    $data['featured'] = $this->_load_featured($this->photo_root);
    foreach (array_reverse(array_filter(glob($this->photo_root.'/*'), 'is_dir')) as $year_dir)
    {
      $year = basename($year_dir);
      $data['years'][$year] = $year_dir;
    }
    #$this->load->view('header', $data);
    #$this->load->view('index', $data);
    #$this->load->view('footer', $data);
    echo view('header', $data);
    echo view('index', $data);
    echo view('footer', $data);

  }

  private function _link_years()
  {
    // created a linked list of years
    $is_first = true;
    $years = array();
    $last_year = '';
    $next_year = '';
    foreach (array_filter(glob($this->photo_root.'/*'), 'is_dir') as $year_dir)
    {
      $year = basename($year_dir);
      if ($is_first)
      {
        $last_year = $year;
        $is_first = false;
      }
      $years[$year]['last'] = $last_year;
      // put in a value for next year in case this is the last in the loop
      $years[$year]['next'] = $year;
      // update last_years next with this year
      $years[$last_year]['next'] = $year;
      $last_year = $year;
    }
    return $years;
  }

  function show_year($year)
  {
    $data['title'] = "Photos for $year";
    $data['year'] = $year;
    $data['featured'] = $this->_load_featured($this->photo_root . "/$year");
    foreach (array_reverse(array_filter(glob($this->photo_root.'/*'), 'is_dir')) as $year_dir)
    {
      $year_dir = basename($year_dir);
      $data['years'][$year_dir] = $year_dir;
    }
    $day_count = 0;
    foreach (array_reverse(array_filter(glob($this->photo_root."/$year/*"), 'is_dir')) as $day_dir)
    {
      $data['days'][$year][] = $day_dir;
      if ($day_count == 0)
      {
        $_first_day = $day_dir;
      }
      ++$day_count;
    }
    if (! isset($data['featured']))
    {
      $this->show_day($year, basename($_first_day));
      return;
    }

    $year_list = $this->_link_years();
    $data['prev_year'] = $year_list[$year]['last'];
    $data['next_year'] = $year_list[$year]['next'];
    $data['desc'] = $this->_load_desc();
    echo view('header', $data);
    echo view('year', $data);
    echo view('footer', $data);
  }

  private function _link_days($year)
  {
    // created a linked list of days within a year
    $is_first = true;
    $years = array();
    $last_day = '';
    $next_day = '';
    foreach (array_filter(glob($this->photo_root."/$year/*"), 'is_dir') as $day_dir)
    {
      $day = basename($day_dir);
      if ($is_first)
      {
        $last_day = $day;
        $is_first = false;
      }
      $days[$day]['last'] = $last_day;
      // put in a value for next day in case this is the last in the loop
      $days[$day]['next'] = $day;
      // update last_day's next with this day
      $days[$last_day]['next'] = $day;
      $last_day = $day;
    }
    return $days;
  }

  function show_day($year, $day)
  {
    $data = array();
    $data['photo_root'] = $this->photo_root;
    $data['year'] = $year;
    $data['day'] = $day;
    $data['title'] = $this->_find_desc($day);
    $top_file = $this->photo_root . "/$year/$day/top.txt";
    // if there is a 'top.txt' in the directory, load it as the page top <h1> text
    if ( is_file($top_file))
    {
      $data['top_text'] = '';
      $top_text = file($top_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($top_text as $line_num => $line)
      {
        $data['top_text'] .= $line;
      }
    }
    else
    {
      $data['top_text'] = $data['title'];
    }
    foreach (array_reverse(array_filter(glob($this->photo_root.'/*'), 'is_dir')) as $year_dir)
    {
      $year_dir = basename($year_dir);
      $data['years'][$year_dir] = $year_dir;
    }
    foreach (array_reverse(array_filter(glob($this->photo_root."/$year/*"), 'is_dir')) as $day_dir)
    {
      $data['days'][$year][] = $day_dir;
    }
    foreach (array_filter(glob($this->photo_root."/$year/$day/*.{jpg,JPG,mp4,MP4}", GLOB_BRACE), 'is_file') as $image)
    {
      $data['images'][]=$this->_strip_extension(basename($image));
    }
    $day_link = $this->_link_days($year);
    $data['next_day'] = $day_link[$day]['next'];
    $data['prev_day'] = $day_link[$day]['last'];
    $data['desc'] = $this->_load_desc();
    echo view('header', $data);
    echo view('day', $data);
    echo view('footer', $data);
  }

  private function _strip_extension($filename)
  {
    // strip the extention of a file name
    return substr($filename, 0, strrpos($filename, '.'));
  }

  private function _get_extension($filename)
  {
    // return the extention of a file name
    return substr(strrchr($filename,'.'),1);
  }

  private function _link_images($year, $day)
  {
    // created a linked list of images within a day
    $is_first = true;
    $images = array();
    $last_image = '';
    $next_image = '';
    foreach (array_filter(glob($this->photo_root."/$year/$day/*.{jpg,JPG,mp4,MP4}", GLOB_BRACE), 'is_file') as $image)
    {
      $image = $this->_strip_extension(basename($image));
      if ($is_first)
      {
        $last_image = $image;
        $is_first = false;
      }
      $images[$image]['last'] = $last_image;
      // put in a value for next image in case this is the last in the loop
      $images[$image]['next'] = $image;
      // update last_image -> next with this image
      $images[$last_image]['next'] = $image;
      $last_image = $image;
    }
    return $images;
  }

  function show_image($year, $day, $image)
  {
    $data = array();
    $found = false;
    $data['year'] = $year;
    $data['day'] = $day;
    $data['title'] = $image;
    foreach (array_filter(glob($this->photo_root."/$year/$day/$image.{jpg,JPG,mp4,MP4}", GLOB_BRACE), 'is_file') as $image_file)
    {
      $image = basename($image_file);
      $data['image'] = $image;
      $found = true;
    }
    if ( ! $found )
    {
      // if the image isn't found, just re-show the current day (hoping that exists!)
      $this->show_day($year, $day);
      return;
    }
    $image_list = $this->_link_images($year, $day);
    $data['prev_image'] = $image_list[$this->_strip_extension($image)]['last'];
    $data['next_image'] = $image_list[$this->_strip_extension($image)]['next'];
    $data['this_image'] = $this->_strip_extension($image);
    $data['extention'] = $this->_get_extension($image);
    echo view('header', $data);
    echo view('image', $data);
    echo view('footer', $data);
  }
}
