<?php
namespace App\Traits;
use App\Helpers\ImageUploader;
trait CareerTrait
{
    private function setCareerPdfDoc($request, $careerObj)
    {
        if ($request->hasFile('pdf_doc')) {
            ImageUploader::deleteFile('careers', $careerObj->pdf_doc);
            $pdf_doc = $request->file('pdf_doc');
            $careerPdfDocName = $request->input('title');
            $fileName = ImageUploader::UploadDoc('careers', $pdf_doc, $careerPdfDocName);
            $careerObj->pdf_doc = $fileName;
        }
        return $careerObj;
    }
    private function setCareerValues($request, $careerObj)
    {
        $careerObj->title = $request->input('title');
        $careerObj->description = $request->input('description');
        $careerObj->apply_by_date_time = $request->input('apply_by_date_time');
        $careerObj->location = $request->input('location');
        $careerObj->type = $request->input('type');
        $careerObj = $this->setCareerStatus($request, $careerObj);
        $careerObj = $this->setCareerPdfDoc($request, $careerObj);

        return $careerObj;
    }
    private function setCareerStatus($request, $careerObj)
    {
        $careerObj->status = $request->input('status');
        return $careerObj;
    }
}
