<?php

use App\Models\Back\Metadata;

function get_meta_val($key)
{
    return Metadata::where('data_key', $key)->first()->val1;
}

function getMetaData()
{
    $metaDatas = Metadata::get();
    $metaArray = new stdClass();
    foreach ($metaDatas as $metaData) {
        $key = $metaData->data_key;
        $value = $metaData->val1;
        $metaArray->$key = $value;
    }

    return $metaArray;
}

function getMetaKeyValue($key)
{
    $metaDataObj = Metadata::Where('data_key', 'like', $key)->first();

    return $metaDataObj->val1;
}

function updateMetaKeyValue($key, $value)
{
    $metaDataObj = Metadata::where('data_key', 'like', $key)->first();
    $metaDataObj->val1 = $value;
    $metaDataObj->update();
}
