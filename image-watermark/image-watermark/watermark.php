<?php
if (isset($_GET['file'])) {
    $filename = urldecode($_GET['file']);
    $filepath = 'uploads/' . $filename;

    if (file_exists($filepath)) {
        
        $image = imagecreatefromstring(file_get_contents($filepath));
        
        $watermark = imagecreatefrompng('watermark.png');
        
        $watermark_width = 100; 
        $watermark_height = 100; 
        $resized_watermark = imagecreatetruecolor($watermark_width, $watermark_height);
        imagealphablending($resized_watermark, false);
        imagesavealpha($resized_watermark, true);

        $transparent = imagecolorallocatealpha($resized_watermark, 0, 0, 0, 127);
        imagefilledrectangle($resized_watermark, 0, 0, $watermark_width, $watermark_height, $transparent);

        imagecopyresampled(
            $resized_watermark,
            $watermark,
            0, 0, 0, 0,
            $watermark_width, $watermark_height,
            imagesx($watermark), imagesy($watermark)
        );
        
        $image_width = imagesx($image);
        $image_height = imagesy($image);
        
        $x = $image_width - $watermark_width - 10; 
        $y = $image_height - $watermark_height - 10; 
        
        imagecopy($image, $resized_watermark, $x, $y, 0, 0, $watermark_width, $watermark_height);
        
        header('Content-Type: image/png');
        imagepng($image);

        imagedestroy($image);
        imagedestroy($watermark);
        imagedestroy($resized_watermark);
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>