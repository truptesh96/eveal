<?php

class SQ_Models_Ico {

    /**
     * Images in the BMP format.
     *
     * @var array
     * @access private
     */
    var $_images = array();

    /**
     * Add the image to the root path
     *
     * @param array $file
     * @param string $path
     * @return false|array [name (the name of the file), favicon (the path of the ico), message (the returned message)]
     *
     */
    public function addFavicon($file, $path = ABSPATH) {

        /* get the file extension */
        $appleSizes = preg_split('/[,]+/', _SQ_MOBILE_ICON_SIZES);
        $file_name = explode('.', $file['name']);
        $file_type = strtolower($file_name[count((array)$file_name) - 1]);

        $out = array();
        $out['tmp'] = _SQ_CACHE_DIR_ . strtolower(md5($file['name']) . '_tmp.' . $file_type);
        $out['favicon'] = _SQ_CACHE_DIR_ . strtolower(md5($file['name']) . '.' . $file_type);
        foreach ($appleSizes as $size) {
            $out['favicon' . $size] = _SQ_CACHE_DIR_ . strtolower(md5($file['name']) . '.' . $file_type . $size);
        }

        /* if the file has a name */
        if (!empty($file['name'])) {
            /* Check the extension */
            $file_type = strtolower($file_type);
            $files = array('ico', 'jpeg', 'jpg', 'gif', 'png');
            $key = in_array($file_type, $files);

            if (!$key) {
                SQ_Classes_Error::setError(esc_html__("File type error: Only ICO, JPEG, JPG, GIF or PNG files are allowed.", _SQ_PLUGIN_NAME_));
                return false;
            }

            /* Check for error messages */
            if ($this->checkFunctions()) {
                /* Delete the previous file if exists */
                if (is_file($out['favicon'])) {
                    if (!unlink($out['favicon'])) {
                        SQ_Classes_Error::setError(esc_html__("Delete error: Could not delete the old favicon.", _SQ_PLUGIN_NAME_));
                        return false;
                    }
                }

                /* Upload the file */
                if (!move_uploaded_file($file['tmp_name'], $out['tmp'])) {
                    SQ_Classes_Error::setError(esc_html__("Upload error: Could not upload the favicon.", _SQ_PLUGIN_NAME_));
                    return false;
                }

                /* Change the permision */
                if (!chmod($out['tmp'], 0755)) {
                    SQ_Classes_Error::setError(esc_html__("Permission error: Could not change the favicon permissions.", _SQ_PLUGIN_NAME_));
                    return false;
                }

                if ($file_type <> 'ico') {
                    /* Save the file */
                    if ($out['tmp']) {
                        $this->set_image($out['tmp'], array(32, 32));
                        if ($this->save_ico($out['favicon'])) {
                            if (file_exists($path . "/" . 'favicon.ico')) {
                                $this->remove_ico($path . "/" . 'favicon.ico');
                            }
                            if (!is_multisite()) {
                                $this->save_ico($path . "/" . 'favicon.ico');
                            }
                        }
                        foreach ($appleSizes as $size) {
                            $this->set_image($out['tmp'], array($size, $size));
                            $this->save_ico($out['favicon' . $size]);
                        }
                    } else {
                        SQ_Classes_Error::setError(esc_html__("ICO Error: Could not create the ICO from file. Try with another file type.", _SQ_PLUGIN_NAME_));
                    }
                } else {
                    copy($out['tmp'], $out['favicon']);
                    foreach ($appleSizes as $size) {
                        copy($out['tmp'], $out['favicon' . $size]);
                    }

                    unset($out['tmp']);
                    if (file_exists($path . "/" . 'favicon.ico')) {
                        $this->remove_ico($path . "/" . 'favicon.ico');
                    }
                    if (!is_multisite()) {
                        $this->save_ico($path . "/" . 'favicon.ico');
                    }
                }
                unset($out['tmp']);
                SQ_Classes_Error::setMessage(esc_html__("The favicon has been updated.", _SQ_PLUGIN_NAME_));

                return $out;
            }
        }

        return false;
    }

    /**
     * Constructor - Create a new ICO generator.
     *
     * If the constructor is not passed a file, a file will need to be supplied using the {@link PHP_ICO::add_image}
     * function in order to generate an ICO file.
     *
     * @param string $file Optional. Path to the source image file.
     * @param array $sizes Optional. An array of sizes (each size is an array with a width and height) that the source image should be rendered at in the generated ICO file. If sizes are not supplied, the size of the source image will be used.
     */
    function set_image($file = false, $sizes = array()) {
        if (false != $file)
            $this->add_image($file, $sizes);
    }

    /**
     * Add an image to the generator.
     *
     * This function adds a source image to the generator. It serves two main purposes: add a source image if one was
     * not supplied to the constructor and to add additional source images so that different images can be supplied for
     * different sized images in the resulting ICO file. For instance, a small source image can be used for the small
     * resolutions while a larger source image can be used for large resolutions.
     *
     * @param string $file Path to the source image file.
     * @param array $sizes Optional. An array of sizes (each size is an array with a width and height) that the source image should be rendered at in the generated ICO file. If sizes are not supplied, the size of the source image will be used.
     * @return boolean true on success and false on failure.
     */
    function add_image($file, $sizes = array()) {

        if (false === ( $im = $this->_load_image_file($file) ))
            return false;


        if (empty($sizes))
            $sizes = array(imagesx($im), imagesy($im));

        // If just a single size was passed, put it in array.
        if (!is_array($sizes[0]))
            $sizes = array($sizes);

        foreach ((array) $sizes as $size) {
            list( $width, $height ) = $size;

            $new_im = imagecreatetruecolor($width, $height);

            imagecolortransparent($new_im, imagecolorallocatealpha($new_im, 0, 0, 0, 127));
            imagealphablending($new_im, false);
            imagesavealpha($new_im, true);

            $source_width = imagesx($im);
            $source_height = imagesy($im);

            if (false === imagecopyresampled($new_im, $im, 0, 0, 0, 0, $width, $height, $source_width, $source_height))
                continue;

            $this->_add_image_data($new_im);
        }

        return true;
    }

    /**
     * Write the ICO file data to a file path.
     *
     * @param string $file Path to save the ICO file data into.
     * @return boolean true on success and false on failure.
     */
    function save_ico($file) {
        if (false === ( $data = $this->_get_ico_data() ))
            return false;

        if (false === ( $fh = fopen($file, 'w') ))
            return false;

        if (false === ( fwrite($fh, $data) )) {
            fclose($fh);
            return false;
        }

        fclose($fh);

        return true;
    }

    function remove_ico($file) {
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    /**
     * Generate the final ICO data by creating a file header and adding the image data.
     *
     * @access private
     */
    function _get_ico_data() {
        if (!is_array($this->_images) || empty($this->_images))
            return false;


        $data = pack('vvv', 0, 1, count((array)$this->_images));
        $pixel_data = '';

        $icon_dir_entry_size = 16;

        $offset = 6 + ( $icon_dir_entry_size * count((array)$this->_images) );

        foreach ($this->_images as $image) {
            $data .= pack('CCCCvvVV', $image['width'], $image['height'], $image['color_palette_colors'], 0, 1, $image['bits_per_pixel'], $image['size'], $offset);
            $pixel_data .= $image['data'];

            $offset += $image['size'];
        }

        $data .= $pixel_data;
        unset($pixel_data);


        return $data;
    }

    /**
     * Take a GD image resource and change it into a raw BMP format.
     *
     * @access private
     */
    function _add_image_data($im) {
        $width = imagesx($im);
        $height = imagesy($im);


        $pixel_data = array();

        $opacity_data = array();
        $current_opacity_val = 0;

        for ($y = $height - 1; $y >= 0; $y--) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($im, $x, $y);

                $alpha = ( $color & 0x7F000000 ) >> 24;
                $alpha = ( 1 - ( $alpha / 127 ) ) * 255;

                $color &= 0xFFFFFF;
                $color |= 0xFF000000 & ( $alpha << 24 );

                $pixel_data[] = $color;


                $opacity = ( $alpha <= 127 ) ? 1 : 0;

                $current_opacity_val = ( $current_opacity_val << 1 ) | $opacity;

                if (( ( $x + 1 ) % 32 ) == 0) {
                    $opacity_data[] = $current_opacity_val;
                    $current_opacity_val = 0;
                }
            }

            if (( $x % 32 ) > 0) {
                while (( $x++ % 32 ) > 0)
                    $current_opacity_val = $current_opacity_val << 1;

                $opacity_data[] = $current_opacity_val;
                $current_opacity_val = 0;
            }
        }

        $image_header_size = 40;
        $color_mask_size = $width * $height * 4;
        $opacity_mask_size = ( ceil($width / 32) * 4 ) * $height;


        $data = pack('VVVvvVVVVVV', 40, $width, ( $height * 2), 1, 32, 0, 0, 0, 0, 0, 0);

        foreach ($pixel_data as $color)
            $data .= pack('V', $color);

        foreach ($opacity_data as $opacity)
            $data .= pack('N', $opacity);


        $image = array(
            'width' => $width,
            'height' => $height,
            'color_palette_colors' => 0,
            'bits_per_pixel' => 32,
            'size' => $image_header_size + $color_mask_size + $opacity_mask_size,
            'data' => $data,
        );

        $this->_images[] = $image;
    }

    /**
     * Read in the source image file and convert it into a GD image resource.
     *
     * @access private
     */
    function _load_image_file($file) {
        $wp_filesystem = SQ_Classes_Helpers_Tools::initFilesystem();

        //initiate image as false
        $im = false;

        // Run a cheap check to verify that it is an image file.
        if (function_exists('getimagesize') && !getimagesize($file)) {
            return false;
        }

        if (!$file_data = $wp_filesystem->get_contents($file)) {
            return false;
        }

        if (function_exists('imagecreatefromstring') && !$im = imagecreatefromstring($file_data)) {
            return false;
        }

        return $im;

    }



    private function checkFunctions() {
        $required_functions = array('getimagesize', 'imagecreatefromstring', 'imagecreatetruecolor', 'imagecolortransparent', 'imagecolorallocatealpha', 'imagealphablending', 'imagesavealpha', 'imagesx', 'imagesy', 'imagecopyresampled',);

        foreach ($required_functions as $function) {
            if (!function_exists($function)) {
                SQ_Classes_Error::clearErrors();
                SQ_Classes_Error::setError("The PHP_ICO class was unable to find the $function function, which is part of the GD library. Ensure that the system has the GD library installed and that PHP has access to it through a PHP interface, such as PHP's GD module. Since this function was not found, the library will be unable to create ICO files.");
                return false;
            }
        }

        return true;
    }

}
