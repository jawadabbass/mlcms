<?php
if (!function_exists('is_php')) {
    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param    string
     * @return    bool    TRUE if the current version is $version or higher
     */
    function is_php($version)
    {
        static $_is_php;
        $version = (string)$version;
        if (!isset($_is_php[$version])) {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }
        return $_is_php[$version];
    }
}
if (!function_exists('is_really_writable')) {
    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @link    https://bugs.php.net/bug.php?id=54709
     * @param    string
     * @return    bool
     */
    function is_really_writable($file)
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or !ini_get('safe_mode'))) {
            return is_writable($file);
        }
        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === FALSE) {
                return FALSE;
            }
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return TRUE;
        } elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }
        fclose($fp);
        return TRUE;
    }
}
if (!function_exists('create_captcha')) {
    /**
     * Create CAPTCHA
     *
     * @param    array $data data for the CAPTCHA
     * @param    string $img_path path to create the image in
     * @param    string $img_url URL to the CAPTCHA image folder
     * @param    string $font_path server path to font
     * @return    array
     */
    function create_captcha($data = '', $img_path = '', $img_url = '', $font_path = '')
    {
        $defaults = array(
            'word' => '',
            'img_path' => '',
            'img_url' => '',
            'img_width' => '150',
            'img_height' => '50',
            'font_path' => '',
            'expiration' => 7200,
            'word_length' => 8,
            'font_size' => 16,
            'img_id' => '',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(153, 102, 102),
                'text' => array(204, 153, 153),
                'grid' => array(255, 182, 182)
            )
        );
        foreach ($defaults as $key => $val) {
            if (!is_array($data) && empty($$key)) {
                $$key = $val;
            } else {
                $$key = isset($data[$key]) ? $data[$key] : $val;
            }
        }
        if (
            $img_path === '' or $img_url === ''
            or !is_dir($img_path) or !is_really_writable($img_path)
            or !extension_loaded('gd')
        ) {
            //echo "Returning";
            //echo $img_path;
            return FALSE;
        }
        // -----------------------------------
        // Remove old images
        // -----------------------------------
        $now = microtime(TRUE);
        $current_dir = @opendir($img_path);
        while ($filename = @readdir($current_dir)) {
            if (substr($filename, -4) === '.jpg' && (str_replace('.jpg', '', $filename) + $expiration) < $now) {
                @unlink($img_path . $filename);
            }
        }
        @closedir($current_dir);
        // -----------------------------------
        // Do we have a "word" yet?
        // -----------------------------------
        if (empty($word)) {
            $word = '';
            for ($i = 0, $mt_rand_max = strlen($pool) - 1; $i < $word_length; $i++) {
                $word .= $pool[mt_rand(0, $mt_rand_max)];
            }
        } elseif (!is_string($word)) {
            $word = (string)$word;
        }
        // -----------------------------------
        // Determine angle and position
        // -----------------------------------
        $length = strlen($word);
        $angle = ($length >= 6) ? mt_rand(- ($length - 6), ($length - 6)) : 0;
        $x_axis = mt_rand(6, (360 / $length) - 16);
        $y_axis = ($angle >= 0) ? mt_rand($img_height, $img_width) : mt_rand(6, $img_height);
        // Create image
        // PHP.net recommends imagecreatetruecolor(), but it isn't always available
        $im = function_exists('imagecreatetruecolor')
            ? imagecreatetruecolor($img_width, $img_height)
            : imagecreate($img_width, $img_height);
        // -----------------------------------
        //  Assign colors
        // ----------------------------------
        is_array($colors) or $colors = $defaults['colors'];
        foreach (array_keys($defaults['colors']) as $key) {
            // Check for a possible missing value
            is_array($colors[$key]) or $colors[$key] = $defaults['colors'][$key];
            $colors[$key] = imagecolorallocate($im, $colors[$key][0], $colors[$key][1], $colors[$key][2]);
        }
        // Create the rectangle
        ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $colors['background']);
        // -----------------------------------
        //  Create the spiral pattern
        // -----------------------------------
        $theta = 1;
        $thetac = 7;
        $radius = 16;
        $circles = 20;
        $points = 32;
        for ($i = 0, $cp = ($circles * $points) - 1; $i < $cp; $i++) {
            $theta += $thetac;
            $rad = $radius * ($i / $points);
            $x = ($rad * cos($theta)) + $x_axis;
            $y = ($rad * sin($theta)) + $y_axis;
            $theta += $thetac;
            $rad1 = $radius * (($i + 1) / $points);
            $x1 = ($rad1 * cos($theta)) + $x_axis;
            $y1 = ($rad1 * sin($theta)) + $y_axis;
            imageline($im, $x, $y, $x1, $y1, $colors['grid']);
            $theta -= $thetac;
        }
        // -----------------------------------
        //  Write the text
        // -----------------------------------
        $use_font = ($font_path !== '' && file_exists($font_path) && function_exists('imagettftext'));
        if ($use_font === FALSE) {
            ($font_size > 5) && $font_size = 5;
            $x = mt_rand(0, $img_width / ($length / 3));
            $y = 0;
        } else {
            ($font_size > 30) && $font_size = 30;
            $x = mt_rand(0, $img_width / ($length / 1.5));
            $y = $font_size + 2;
        }
        for ($i = 0; $i < $length; $i++) {
            if ($use_font === FALSE) {
                $y = mt_rand(0, $img_height / 2);
                imagestring($im, $font_size, $x, $y, $word[$i], $colors['text']);
                $x += ($font_size * 2);
            } else {
                $y = mt_rand($img_height / 2, $img_height - 3);
                imagettftext($im, $font_size, $angle, $x, $y, $colors['text'], $font_path, $word[$i]);
                $x += $font_size;
            }
        }
        // Create the border
        imagerectangle($im, 0, 0, $img_width - 1, $img_height - 1, $colors['border']);
        // -----------------------------------
        //  Generate the image
        // -----------------------------------
        $img_url = rtrim($img_url, '/') . '/';
        if (function_exists('imagejpeg')) {
            $img_filename = $now . '.jpg';
            imagejpeg($im, $img_path . $img_filename);
        } elseif (function_exists('imagepng')) {
            $img_filename = $now . '.png';
            imagepng($im, $img_path . $img_filename);
        } else {
            return FALSE;
        }
        $img = '<img ' . ($img_id === '' ? '' : 'id="' . $img_id . '"') . ' src="' . $img_url . $img_filename . '" style="width: ' . $img_width . '; height: ' . $img_height . '; border: 0;" alt=" " />';
        ImageDestroy($im);
        return array('word' => $word, 'time' => $now, 'image' => $img, 'filename' => $img_filename);
    }
}
if (!function_exists('create_ml_captcha')) {
    function create_ml_captcha($type = 1)
    {
        // Captcha configuration
        $config = array(
            'img_path' => public_path() . '/captcha/images/',
            'img_url' => base_url() . 'captcha/images',
            'font_path' => public_path() . '/captcha/font/captcha_font.ttf',
            'img_width' => '150',
            'img_height' => '50',
            'expiration' => 7200,
            'word_length' => 4,
            'font_size' => 20,
            'img_id' => 'Imageid',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 152, 31),
                'text' => array(242, 98, 34),
                'grid' => array(255, 152, 31)
            )
        );
        $captcha = create_captcha($config);
        \Illuminate\Support\Facades\Session::put('cptcode', $captcha['word']);
        if ($type == 2)
            return $captcha['filename'];
        return $captcha['image'];
    }
}
