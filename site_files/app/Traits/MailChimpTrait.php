<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\Metadata;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

trait MailChimpTrait
{
    public function createList()
    {
        $mailChimpListIdMetaDataObj = Metadata::where('data_key', 'like', 'mailchimp_list_id')->first();
        if (null === $mailChimpListIdMetaDataObj) {
            $mailChimpListIdMetaDataObj = new Metadata();
            $mailChimpListIdMetaDataObj->data_key = 'mailchimp_list_id';
            $mailChimpListIdMetaDataObj->val1 = '';
            $mailChimpListIdMetaDataObj->dated = date('Y-m-d h:i:s');
            $mailChimpListIdMetaDataObj->save();
        }
        if (empty($mailChimpListIdMetaDataObj->val1)) {
            $mailchimp = new ApiClient();
            $mailchimp->setConfig([
                'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
                'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
            ]);
            try {
                $response = $mailchimp->lists->createList([
                    "name" => "Hen House Pullets Newsletter",
                    "permission_reminder" => "permission_reminder",
                    "email_type_option" => false,
                    "contact" => [
                        "company" => "Hen House Pullets",
                        "address1" => "Gainesville, GA, United States, Georgia",
                        "city" => "Gainesville",
                        "state" => "GA",
                        "zip" => "30506",
                        "country" => "US",
                    ],
                    "campaign_defaults" => [
                        "from_name" => "Amanda",
                        "from_email" => "sales@henhousepulletsga.com",
                        "subject" => "Hen House Pullets Newsletter",
                        "language" => "EN_US",
                    ],
                ]);
                $mailChimpListIdMetaDataObj->val1 = $response->id;
                $mailChimpListIdMetaDataObj->update();
            } catch (ApiException $e) {
                echo $e->getMessage();
            }
        }
        return $mailChimpListIdMetaDataObj->val1;
    }
    public function updateMailChimpListMembers()
    {
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $membersCollection = Customer::all();
        $membersArray = [];
        foreach ($membersCollection as $memberObj) {
            $newMemberObj = (object) [
                'email_address' => $memberObj->email,
                'status' => 'subscribed',
                'merge_fields' => ['FNAME' => $memberObj->first_name, 'LNAME' => $memberObj->last_name]
            ];
            $membersArray[] = $newMemberObj;
        }
        $response = $mailchimp->lists->batchListMembers($listId, ["members" => $membersArray]);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    public function getMailChimpListMembers()
    {
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $response = $mailchimp->lists->getListMembersInfo($listId, null, null, 1000);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    public function updateMailChimpListMember($memberObj)
    {
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $newMemberObj = [
            'email_address' => $memberObj->email,
            'status' => 'subscribed',
            'merge_fields' => ['FNAME' => $memberObj->first_name, 'LNAME' => $memberObj->last_name]
        ];

        $subscriber_hash = md5(strtolower($memberObj->email));
        $response = $mailchimp->lists->setListMember($listId, $subscriber_hash, $newMemberObj);
        //dd($response);
    }

    public function unsubMailChimpListMember($memberObj)
    {
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);
        $newMemberObj = [
            'email_address' => $memberObj->email,
            'status' => 'unsubscribed'
        ];

        $subscriber_hash = md5(strtolower($memberObj->email));
        $response = $mailchimp->lists->setListMember($listId, $subscriber_hash, $newMemberObj);
        //dd($response);
    }
    public function removeMailChimpListMember($memberObj)
    {
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $subscriber_hash = md5(strtolower($memberObj->email));
        $response = $mailchimp->lists->deleteListMember($listId, $subscriber_hash);
    }

    public function testUpdateMailChimpListMember()
    {
        $memberObj = (object) ['email' => 'jawad@medialinkers.com', 'first_name' => 'Jawad', 'last_name' => 'Abbas'];
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $newMemberObj = [
            'email_address' => $memberObj->email,
            'status_if_new' => 'subscribed',
            'merge_fields' => ['FNAME' => $memberObj->first_name, 'LNAME' => $memberObj->last_name]
        ];

        $subscriber_hash = md5(strtolower($memberObj->email));
        $response = $mailchimp->lists->setListMember($listId, $subscriber_hash, $newMemberObj);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    public function testRemoveMailChimpListMember()
    {
        $memberObj = (object) ['email' => 'jawad@medialinkers.com', 'first_name' => 'Jawad', 'last_name' => 'Abbas'];
        $listId = $this->createList();
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('mailchimp.MAILCHIMP_API_KEY'),
            'server' => config('mailchimp.MAILCHIMP_SERVER_PREFIX')
        ]);

        $subscriber_hash = md5(strtolower($memberObj->email));
        $response = $mailchimp->lists->deleteListMember($listId, $subscriber_hash);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }
}
