<?php

require plugin_dir_path(__FILE__) . 'class.FPDF.php';

class PDF extends FPDF {
  const DPI = 96;
  const MM_IN_INCH = 25.4;
  const A4_HEIGHT = 297;
  const A4_WIDTH = 210;
  const MAX_WIDTH = 1920;
  const MAX_HEIGHT = 8000;

  function centreImage($img) {
    list($width, $height) = $this->resizeToFit($img);

    $this->SetSize(($width / 2) + 110, ($height * 57 / 100));

    $this->Image(
      $img,
      (self::A4_HEIGHT - $width) / 2,
      (self::A4_WIDTH - $height) / 2,
      $width,
      $height
    );
  }

  function resizeToFit($imgFilename) {
    list($width, $height) = getimagesize($imgFilename);

    $widthScale = self::MAX_WIDTH / $width;
    $heightScale = self::MAX_HEIGHT / $height;

    $scale = min($widthScale, $heightScale);

    return [
      round($this->pixelsToMM($scale * $width)),
      round($this->pixelsToMM($scale * $height))
    ];
  }

  function pixelsToMM($val) {
    return $val * self::MM_IN_INCH / self::DPI;
  }

  function SetSize($width, $height) {
    $this->StdPageSizes['custom'] = [ $width, $height ];
  }
}