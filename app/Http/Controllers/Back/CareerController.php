<?php

namespace App\Http\Controllers\Back;

use stdClass;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Back\CareersApply;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    private $pp_client_id = '78c1bz8h08q7uj';
    private $pp_secret_id = 'iaDdJyWmJrY8HtBN';
    public function shareOnPakPosition($id)
    {

        $record = CmsModuleData::find($id);
        $data = array();
        $data['client_id']  = $this->pp_client_id;
        $data['secret_key']  = $this->pp_secret_id;
        $data['job_title']  = $record->heading;
        $data['industry_ID']  = $record->additional_field_6;
        $data['pay']  = $record->additional_field_1;
        $data['last_date']  = $record->additional_field_7;
        $data['qualification']  = $record->additional_field_2;
        $data['experience']  = $record->additional_field_3;
        $data['city']  = $record->additional_field_5;
        $data['job_mode']  = $record->additional_field_8;
        $data['vacancies']  = $record->additional_field_9;
        $data['job_description']  = $record->content;
        $data['required_skills']  = $record->additional_field_4;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.pakpositions.com/api/post_job");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query($data)
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response2 = json_decode($response);
        if ($response2->success == true) {
            $record->pp_job_id = $response2->data->job_id;
            $record->is_shared_on_pp = 'Yes';
            $record->job_sts_on_pp = 'active';
            $record->save();
            return response()->json(['status' => 'success', 'message' => 'Job Posted on Pak Position Successfully!']);
        } elseif ($response2->success == false) {
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong !']);
        }
        return response()->json(['status' => 'error', 'message' => 'Something Went Wrong !']);
    }
    public function updateJobOnPakPosition($id)
    {
    }
    public function changeStsOnPakPos($id)
    {
        $record = CmsModuleData::find($id);
        $newSts = ($record->job_sts_on_pp == 'active') ? 'inactive' : 'active';
        $data = array();
        return change_job_sts_on_pp($id, $record->pp_job_id, $newSts);
    }
    public function shareJobOnLinkedIn($id)
    {
        $jobData = CmsModuleData::find($id);
        $link = base_url() . $jobData->post_slug;
        $access_token = 'AQWKdphqxShlnZnsd8ck6EATlnx5YsHWqFyM7LcoRsMdAZjPHYJpHG4_D7TzxsTczEXID413ME-uECCgzNg1TnqQ5qAGkP8HUD-ZX3WW3aoiCJ6EjOtv86RaXA9tPjCTHdDNwRZFPqeSfxKtkk8EhQLdWuG_ramVdktQt8a3wqQs6k0Vk0bw04uoY-h81Nj5ne9yrd2Sxq_LxwL0CdrJSR05BUsTQtFoIEVQxXfAQa4CNmTtq-40pKTuVmqmYBGFz5EQU2UrRzv9EAW580HkxRoko1kjAiWf3lNERfxjr0T_RRJRa_Hb4G6E4_aH3ZjckCRJdwaP8ed0NGRh6r50VHOovrcaLg';
        $linkedin_id = 'xp-95jdK4t';
        $body = new \stdClass();
        $body->content = new \stdClass();
        $body->content->contentEntities[0] = new \stdClass();
        $body->text = new \stdClass();
        $body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
        $body->content->contentEntities[0]->entityLocation = $link;
        $body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "THUMBNAIL_URL_TO_POST";
        // $body->content->title = 'Admin Accounts Manager';
        $body->content->title = $jobData->heading;
        $body->owner = 'urn:li:person:' . $linkedin_id;
        // $body->text->text = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishingd software like Aldus PageMaker including versions of Lorem Ipsum.';
        $body->text->text = $jobData->content;
        $body_json = json_encode($body, true);

        try {
            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('POST', '/v2/shares', [
                'headers' => [
                    "Authorization" => "Bearer " . $access_token,
                    "Content-Type"  => "application/json",
                    "x-li-format"   => "json"
                ],
                'body' => $body_json,
            ]);

            if ($response->getStatusCode() !== 201) {
                echo 'Error: ' . $response->getLastBody()->errors[0]->message;
            }
            $jobData->is_shared_on_linkedin = 'Yes';
            $jobData->linkedin_job_id = $response->getHeaders()['X-LinkedIn-Id'][0];
            $jobData->save();
            return response()->json(['status' => 'success', 'message' => 'Job Posted on LinkedIn Successfully !']);

            echo 'Post is shared on LinkedIn successfully.';
        } catch (Exception $e) {
            echo $e->getMessage() . ' for link ' . $link;
        }
    }
    public function deletePostOnLinkedin($id)
    {
        $jobData = CmsModuleData::find($id);
        $id = $jobData->linkedin_job_id;
        $access_token = 'AQWKdphqxShlnZnsd8ck6EATlnx5YsHWqFyM7LcoRsMdAZjPHYJpHG4_D7TzxsTczEXID413ME-uECCgzNg1TnqQ5qAGkP8HUD-ZX3WW3aoiCJ6EjOtv86RaXA9tPjCTHdDNwRZFPqeSfxKtkk8EhQLdWuG_ramVdktQt8a3wqQs6k0Vk0bw04uoY-h81Nj5ne9yrd2Sxq_LxwL0CdrJSR05BUsTQtFoIEVQxXfAQa4CNmTtq-40pKTuVmqmYBGFz5EQU2UrRzv9EAW580HkxRoko1kjAiWf3lNERfxjr0T_RRJRa_Hb4G6E4_aH3ZjckCRJdwaP8ed0NGRh6r50VHOovrcaLg';
        $token1 = 'Bearer ' . $access_token;
        $ch = curl_init();
        $url = 'https://api.linkedin.com/v2/shares/' . $id;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization:' . $token1
            )
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return TRUE;
    }
    public function jobs_applicants()
    {
        $title = config('Constants.SITE_NAME') . ': | Jobs Applicants';
        $data = CareersApply::orderBy('id', 'desc')->with('careers_details')->get();
        return view('back.careers.applicants', compact('title', 'data'));
    }
    public function jobs_applicants_details($id)
    {
        $title = config('Constants.SITE_NAME') . ': | Jobs Applicants';
        $data = CareersApply::where('id', $id)->with('careers_details')->firstOrFail();
        // return $data;
        return view('back.careers.show', compact('title', 'data'));
    }
}
