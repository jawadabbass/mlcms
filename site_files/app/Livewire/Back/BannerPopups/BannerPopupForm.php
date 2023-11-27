<?php

namespace App\Livewire\Back\BannerPopups;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use App\Models\Back\BannerPopup as BannerPopupModel;

class BannerPopupForm extends Form
{
    public ?BannerPopupModel $bannerPopUpObj;
    public $banner_title = '';
    public $content = '';
    public $status = 'active';
    public $add_or_edit = 'add';

    public function rules()
    {
        $unique = Rule::unique('banner_popups');
        if ($this->add_or_edit == 'edit') {
            $unique = Rule::unique('banner_popups')->ignore($this->bannerPopUpObj);
        }
        return [
            'banner_title' => [
                'required', $unique,
            ],
            'content' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'banner_title.required' => 'Banner title required.',
            'banner_title.unique' => 'Banner title already in use.',
            'content.required' => 'Banner Content required.',
            'status.required' => 'Banner Status required.',
        ];
    }

    public function setBannerPopup(BannerPopupModel $bannerPopUpObj, $add_or_edit = 'add')
    {
        $this->add_or_edit = $add_or_edit;
        $this->bannerPopUpObj = $bannerPopUpObj;
        $this->banner_title = $bannerPopUpObj->banner_title;
        $this->content = $bannerPopUpObj->content;
        $this->status = $bannerPopUpObj->status;
    }

    public function store()
    {
        $this->validate();
        BannerPopupModel::create($this->only(['banner_title', 'content', 'status']));
    }

    public function update()
    {
        $this->validate();
        $this->bannerPopUpObj->update(
            $this->all()
        );
    }
}
