<?php
function copyImage1($image_source, $max_width, $max_height, $output_file)
{
    $backup_file = $image_source;
    $image_properties = @getimagesize($backup_file);
    if ($image_properties[2] != 1 and $image_properties[2] != 2 and $image_properties[2] != 3 and $image_properties[2] != 6) {
        //echo "unable to get image properties<br>";
        //echo "Image type = ".$image_properties[2];
        return (0);
    } else {
        $imagetype = getimagesize($image_source);

        //print_r($imagetype);exit;
        //echo $imagetype[2];exit;
        if ($imagetype[2] == 1) {
            $src_image = imagecreatefromgif($backup_file);
        }

        if ($imagetype[2] == 2) {
            $src_image = imagecreatefromjpeg($backup_file);
        }

        if ($imagetype[2] == 3) {
            $src_image = imagecreatefrompng($backup_file);
        }

        if ($imagetype[2] == 4) {
            $src_image = imagecreatefromwbmp($backup_file);
        }

        //$src_image = imagecreatefromjpeg($backup_file);
        $src_x = imagesx($src_image);
        $src_y = imagesy($src_image);
        if ($src_x > $max_width || $src_y > $max_height) {
            if ($src_x > $max_width) {
                $thumb_w = $max_width;
                $thumb_h = $src_y * ($max_width / $src_x);

                if ($thumb_h > $max_height) {
                    $thumb_w = $thumb_w * ($max_height / $thumb_h);
                    $thumb_h = $max_height;
                }
            } else if ($src_y > $max_height) {
                $thumb_w = $src_x * ($max_height / $src_y);
                $thumb_h = $max_height;
            }
            $thumb_x = $thumb_w;
            $thumb_y = $thumb_h;
        } else {
            $flag = 1;
            $thumb_x = $src_x;
            $thumb_y = $src_y;
        }
        $thumb_x = (int)($thumb_x);
        $thumb_y = (int)($thumb_y);
        $dest_image = imagecreatetruecolor($thumb_x, $thumb_y);
        if ($imagetype[2] == "1" or $imagetype[2] == "3") {
            imagecolortransparent($dest_image, imagecolorallocatealpha($dest_image, 0, 0, 0, 127));
            imagealphablending($dest_image, false);
            imagesavealpha($dest_image, true);
            copy($image_source, $output_file);
            imagedestroy($dest_image);
            return (1);
        }
        //echo $dest_image . "-----" .  $src_image;
        //exit;
        if (!imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $thumb_x, $thumb_y, $src_x, $src_y)) {
            copy($image_source, $output_file);
            imagedestroy($src_image);
            imagedestroy($dest_image);
            return (0);
        } else {
            imagedestroy($src_image);
            if ($imagetype[2] == 1) {
                if (imagegif($dest_image, $output_file)) {
                    imagedestroy($dest_image);
                    return (1);
                }
            } else if ($imagetype[2] == 2) {
                if (imagejpeg($dest_image, $output_file)) {
                    imagedestroy($dest_image);
                    return (1);
                }
            } else if ($imagetype[2] == 3) {
                if (imagepng($dest_image, $output_file)) {
                    imagedestroy($dest_image);
                    return (1);
                }
            } else if ($imagetype[2] == 4) {
                if (imagewbmp($dest_image, $output_file)) {
                    imagedestroy($dest_image);
                    return (1);
                }
            }
            imagedestroy($dest_image);
        }
        return (0);
    }
}
function the_icon($icon = 'add')
{
    if ($icon == 'update') {
        $icon = 'edit';
    }
    $arr = array(
        'add' => '<i class="fa-solid fa-plus-circle" aria-hidden="true"></i>',
        'edit' => '<i class="fa-solid fa-pen-to-square"></i>',
        'del' => '<i class="fa-solid fa-minus-circle" aria-hidden="true"></i>',
        'subm' => '<i class="fa-solid fa-paper-plane" aria-hidden="true"></i>',
        'info' => '<i class="fa-solid fa-info-circle" aria-hidden="true"></i>',
        's' => '<i class="fa-solid fa-search" aria-hidden="true"></i>',
    );
    if (isset($arr[$icon])) {
        echo $arr[$icon];
    }
    echo '';
}
function getBC($heading, $parentArr = array())
{
    $tmpStr = '';
    $tmpStr .= '<ol class="breadcrumb"><li><a href="' . admin_url() . '"><i class="fa-solid fa-dashboard"></i> Home</a>
                                    </li>';
    if (!empty($parentArr)) {
        foreach ($parentArr as $key => $val) {
            $tmpStr .= '<li><a href="' . admin_url() . $key . '">' . $val . '</a></li>';
        }
    }
    $tmpStr .= '<li class="active">' . $heading . '</li></ol>';

    return $tmpStr;
}
function crop_image($src, $dst, $data)
{
    if (!empty($src) && !empty($dst) && !empty($data)) {
        $file = new SplFileInfo($src);
        $type = strtolower($file->getExtension());
        switch ($type) {
            case 'gif':
                $src_img = imagecreatefromgif($src);
                break;
            case 'jpg':
                $src_img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $src_img = imagecreatefrompng($src);
                break;
        }
        if (!$src_img) {
            $this->msg = "Failed to read the image file";
            return;
        }
        $size = getimagesize($src);
        $size_w = $size[0]; // natural width
        $size_h = $size[1]; // natural height
        $src_img_w = $size_w;
        $src_img_h = $size_h;
        $dst_img_w = $data['module_width'];
        $dst_img_h = $data['module_height'];
        $degrees = $data['rotate'];
        // Rotate the source image
        if (is_numeric($degrees) && $degrees != 0) {
            // PHP's degrees is opposite to CSS's degrees
            $new_img = imagerotate($src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127));
            imagedestroy($src_img);
            $src_img = $new_img;
            $deg = abs($degrees) % 180;
            $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;
            $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
            $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);
            // Fix rotated image miss 1px issue when degrees < 0
            $src_img_w -= 1;
            $src_img_h -= 1;
        }
        $tmp_img_w = $data['width'];
        $tmp_img_h = $data['height'];
        //        $dst_img_w = 220;
        //        $dst_img_h = 220;
        $src_x = $data['x'];
        $src_y = $data['y'];
        if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
            $src_x = $src_w = $dst_x = $dst_w = 0;
        } else if ($src_x <= 0) {
            $dst_x = -$src_x;
            $src_x = 0;
            $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
        } else if ($src_x <= $src_img_w) {
            $dst_x = 0;
            $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
        }
        if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
            $src_y = $src_h = $dst_y = $dst_h = 0;
        } else if ($src_y <= 0) {
            $dst_y = -$src_y;
            $src_y = 0;
            $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
        } else if ($src_y <= $src_img_h) {
            $dst_y = 0;
            $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
        }
        // Scale to destination position and size
        $ratio = $tmp_img_w / $dst_img_w;
        $dst_x /= $ratio;
        $dst_y /= $ratio;
        $dst_w /= $ratio;
        $dst_h /= $ratio;
        $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);
        // Add transparent background to destination image
        imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
        imagesavealpha($dst_img, true);
        $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        if ($result) {
            if (!imagepng($dst_img, $dst)) {
                $this->msg = "Failed to save the cropped image file";
            }
        } else {
            $this->msg = "Failed to crop the image file";
        }
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }
}
function ChangeTemplateWithValues($templ, $Row)
{
    $arr = array(
        "{USERNAME}" => 'email', "{EMAIL}" => 'email', "{NAME}" => 'name',
        "{PASSWORD}" => 'password',
        "{GENDER}" => 'gender', "{PHONE}" => 'phone', "{CITY}" => 'city',
        "{COMMENTS}" => 'comments', "{PHONE}" => 'phno', "{CITY}" => 'city',
        "{MARTIALSTATUS}" => 'maritalstatus', "{AGE}" => 'age'
    );
    $arrS = array(
        "{SITEURL}" => base_url_main, "{SITENAME}" => 'GetRishta.com',
        '{DATE}' => StdDate(date('Y-m-d H:i:s')),
        "{SITENAMEURL}" => 'GetRishta.com',
        "{AVG RATING}" => 'rateing', "{Reg_DATE}" => date('M. d, Y', strtotime('cdate'))
    );
    foreach ($arr as $keyy => $val) {
        if ($keyy == '{COUNTRY}') {
            if (isset($Row['country'])) {
                $country = getCountry($Row['country']);
                $templ = str_replace($keyy, $country, $templ);
            }
        } else if (isset($Row[$val]))
            $templ = str_replace($keyy, $Row[$val], $templ);
    }
    foreach ($arrS as $keyy => $val) {
        $templ = str_replace($keyy, $val, $templ);
    }
    return $templ;
}
function CurTime()
{
    return date('Y-m-d H:i:s');
}
function CurrentFile()
{
    $currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    return $parts[count($parts) - 1];
}
function StdNumber($number)
{
    return number_format($number, 2);
}
function mediaBasePath()
{
    return 'uploads/editor/images/';
}
function filesBasePath()
{
    return 'uploads/editor/files/';
}
function filesExtsAllowed()
{
    return array(
        'pdf' => '<i class="fa-solid fa-file-pdf"></i>',
        'doc' => '<i class="fa-solid fa-file-word"></i>',
        'docx' => '<i class="fa-solid fa-file-word"></i>',
        'xls' => '<i class="fa-solid fa-file-excel"></i>',
        'xlsx' => '<i class="fa-solid fa-file-excel"></i>',
        'ppt' => '<i class="fa-solid fa-file-powerpoint"></i>',
        'pptx' => '<i class="fa-solid fa-file-powerpoint"></i>',
        'txt' => '<i class="fa-solid fa-file"></i>'
    );
}
function checkAccess($user, $accessType)
{
}
function checkAccessArr($user, $accessTypeArr)
{
}
function adminUserDetails($id)
{
    $user = App\User::find($id);
    return $user->name . ' (' . $user->email . ')';
}
function getClientArr($client_id)
{
    return App\User::find($client_id);
}
function make_arr($arr, $parentKey)
{
    $tmpArr = [];
    foreach ($arr as $key => $value) {
        $tmpArr[$value[$parentKey]] = [];
        foreach ($value as $kk => $vv) {
            if ($kk != $parentKey) {
                $tmpArr[$value[$parentKey]][$kk] = $vv;
            }
        }
    }
    return $tmpArr;
}
function insertHistory($key, $dataArr, $client_id = 0, $u_type = 0, $user_id = 0, $action_user = 0)
{
    $emailTemplate = App\Models\Back\EmailTemplate::where('keyy', $key)->first();
    if (!$emailTemplate) {
        echo 'ERROR:: Template NOT FOUND.';
        exit;
    }
    $varArr = [];
    $templ = $emailTemplate->Body;
    $dataArr['{USER}'] = adminUserDetails($user_id);
    $historyMsg = strtr($templ, $dataArr);

    $history = new App\Models\Back\ClientsHistory;
    $history->u_type = $u_type;
    $history->client_id = $client_id;
    $history->msg = $historyMsg;
    $history->add_by_user_id = $user_id;
    $history->history_id = $emailTemplate->ID;
    $history->save();
    return true;
    if ($emailTemplate->Status == 'Yes') {
        $emailUsers = App\User::where('on_notification_email', 'Yes')->get();
        if ($emailUsers) {
            foreach ($emailUsers as $key => $value) {
                $emails = [$value->email];
                $subject = $emailTemplate->Subject;
            }
        }
    }
    //>>>>>>>>>>>>>>>>> **Start** User Email Section
    if ($emailTemplate->user_email_active == 'Yes' && $emailTemplate->user_status = 'Yes') {
        $adminUser = getClientArr($user_id);
        $emailUser = getClientArr($action_user);
        $subject = $emailTemplate->Subject;
        $body = $emailTemplate->user_body;
        $user_body = strtr($body, $dataArr);
        if ($emailTemplate->user_subject != '') {
            $subject = $emailTemplate->user_subject;
        }
        $Mail->From = $emailTemplate->Sender;
        $Mail->IsHTML(true);
        $Mail->FromName = $emailTemplate->SenderName;
        $Mail->Subject  = $subject;
        $Mail->Body     = stripslashes($body);
        $Mail->Send();
        $historyMsg = $body;
        $emails = [$emailUser->email];
        $subject = $emailTemplate->Subject;
    }
    //<<<<<<<<<<<<<<<<< ***End*** User Email Section
}
