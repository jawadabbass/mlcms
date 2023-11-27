<?php

namespace App\Livewire\Back\BannerPopups;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Back\BannerPopup as BannerPopupModel;
use App\Livewire\Back\BannerPopups\BannerPopupForm;


class BannerPopupsList extends Component
{
    use WithPagination;

    public $show_filter = false;
    public $banner_title = '';
    public $sort_by = 'banner_title-asc';
    public $per_page = '10';

    public BannerPopupForm $form;
    public $message = '';

    public function reRender()
    {
        //$this->mount();
        $this->render();
    }

    public function render()
    {
        [$order_by_field, $asc_desc] = explode(
            '-',
            $this->sort_by
        );
        $query = BannerPopupModel::select('*');
        if (!empty($this->banner_title)) {
            $query->where('banner_title', 'like', '%' . $this->banner_title . '%');
        }
        $bannerPopUpsCollection = $query->orderBy($order_by_field, $asc_desc)->paginate($this->per_page);

        return view('back.banner_popup.index')
            ->extends('back.layouts.app', ['title' => 'Banner Popups'])
            ->with('bannerPopUpsCollection', $bannerPopUpsCollection);
    }

    public function showFilters()
    {
        $this->show_filter = true;
    }
    public function hideFilters()
    {
        $this->show_filter = false;
    }
    public function setPerPage()
    {
        $this->resetPage();
    }
    public function setAscDesc()
    {
        $this->resetPage();
    }

    public function showCreateBannerPopupModal()
    {
        $this->dispatch('openBannerPopupFormModal');
    }

    public function store()
    {
        $this->form->store();
        $this->message = 'Banner Popup successfully created.';
        $this->dispatch('closeBannerPopupFormModal');
        $this->reRender();
    }

    public function showEditBannerPopupModal($id)
    {
        $bannerPopUpObj = BannerPopupModel::find($id);
        $this->form->setBannerPopup($bannerPopUpObj, 'edit');
        $this->dispatch('openBannerPopupFormModal');
    }

    public function update()
    {
        $this->form->update();
        $this->message = 'Banner Popup successfully updated.';
        $this->dispatch('closeBannerPopupFormModal');
        $this->reRender();
    }

    public function setActive($id)
    {
        $bannerPopUpObj = BannerPopupModel::find($id);
        $bannerPopUpObj->status = 'active';
        $bannerPopUpObj->update();
        $this->reRender();
    }

    public function setInActive($id)
    {
        $bannerPopUpObj = BannerPopupModel::find($id);
        $bannerPopUpObj->status = 'inactive';
        $bannerPopUpObj->update();
        $this->reRender();
    }

    public function delete($id)
    {
        $bannerPopUpObj = BannerPopupModel::find($id);
        $bannerPopUpObj->delete();
        $this->reRender();
    }
}
