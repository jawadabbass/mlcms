<?php

namespace App\Livewire\Back\BannerPopups;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Back\BannerPopup as BannerPopupModel;


class SortBannerPopups extends Component
{

    public $message = '';

    public function render()
    {
        $bannerPopUpsCollection = BannerPopupModel::orderBy('sort_order', 'asc')->get();

        return view('back.banner_popup.sort')
            ->extends('back.layouts.app', ['title' => 'Banner Popups'])
            ->with('bannerPopUpsCollection', $bannerPopUpsCollection);
    }

    #[On('banner-popups-sort-update')]
    public function bannerPopupsSortUpdate($bannerPopupsOrder)
    {
        $bannerPopupsOrderArray = explode(',', $bannerPopupsOrder);
        $count = 1;
        foreach ($bannerPopupsOrderArray as $bannerPopupId) {
            $bannerPopupObj = BannerPopupModel::find($bannerPopupId);
            $bannerPopupObj->sort_order = $count;
            $bannerPopupObj->update();
            $count++;
        }
        $this->message = 'Sorted Successfully!';
    }
}
