<?php

namespace App\Http\Controllers\Back;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* To display all galleries */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Videos Management';
        $msg = '';
        $albumsObj    = array();
        $folodersArr = array();
        $filesBasePath = filesBasePath();
        $folodersArr = array_filter(glob($filesBasePath . '*'), 'is_dir');
        $cnt = 0;
        //>>>>>>>>>>>>>>>>> **Start** Root Files
        $folderName = 'root';
        $filesArr = getFilesListInDir($filesBasePath, filesExtsAllowed());
        $albumsObj[] = array(
            'album_id' => $cnt,
            'album_title' => $folderName,
            'album_path' => $filesBasePath,
            'album_img' => '',
            'all' => $filesArr
        );
        //<<<<<<<<<<<<<<<<< ***End*** Root Files
        foreach ($folodersArr as $key => $folder) {
            $cnt++;
            $folderName = str_replace($filesBasePath, '', $folder);
            $currentFolderpath = $filesBasePath . $folderName . '/';
            $filesArr = getFilesListInDir($currentFolderpath, filesExtsAllowed());
            $albumsObj[] = array(
                'album_id' => $cnt,
                'album_title' => $folderName,
                'album_path' => $currentFolderpath,
                'album_img' => '',
                'all' => $filesArr
            );
        }
        $filesExts = filesExtsAllowed();
        return view('back.files.index', compact('title', 'msg', 'albumsObj', 'filesExts'));
    }
    public function add_album(Request $request)
    {
        $validatord = Validator::make(
            $request->all(),
            [
                'title' => 'required',
            ]
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        // $this->$filesBasePath;
        if (!mkdir(filesBasePath() . $request->title, 0777, true)) {
            die('Failed to create folders...');
        }
        echo json_encode(array('done' => 'ok'));
    }
    public function update_album(Request $request) {}
    public function upload_album_images(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $exts = implode(',', keyArray(filesExtsAllowed()));
        $validator = Validator::make(
            $request->all(),
            [
                'uploadFile.*' => 'required|mimes:' . $exts . '|max:' . $maxImageSize,
                'album' => 'required'
            ],
            [
                'album.required' => 'Please select Folder.',
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        request()->validate([
            'uploadFile' => 'required',
        ]);
        if (!$this->sec_check(filesBasePath(), $request->album)) {
            cp('err');
        }
        $album_name = str_ireplace(storage_uploads(''), '', $request->album);
        foreach ($request->file('uploadFile') as $key => $value) {
            ImageUploader::UploadDoc($album_name, $value);
        }
        return back()->with('success', 'Images Uploaded Successfully.');
    }
    /**
     * Remove the specified images from album.
     */
    public function destroy($id, Request $request)
    {
        $fileWithPath = $request->imgpath;
        if (!$this->sec_check(filesBasePath(), $fileWithPath)) {
            cp('err');
        }
        //>>>>>>>>>>>>>>>>> **Start** Apply Security Filters
        //HERE
        //<<<<<<<<<<<<<<<<< ***End*** Apply Security Filters
        if (file_exists($fileWithPath)) {
            unlink($fileWithPath);
        }
        return json_encode(array("status" => true));
    }
    /**
     * Remove the album.
     */
    public function delete_album($id)
    {
        if (isset($_POST['imgpath'])) {
            if (!$this->sec_check(filesBasePath(), $_POST['imgpath'])) {
                cp('err');
            }
            $this->delete_files($_POST['imgpath']);
        }
        echo json_encode(array('status' => true));
        exit;
    }
    function delete_files($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
            foreach ($files as $file) {
                $this->delete_files($file);
            }
            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }
    function sec_check($basePath, $passedVal)
    {
        $checkResult = true;
        if (!strstr($passedVal, $basePath)) {
            $checkResult = false;
        }
        return $checkResult;
    }
}
