<?php

function hasError($errors, $field)
{
    return ($errors->first($field) != '') ? 'is-invalid msg_cls_for_focus' : '';
}

function showErrors($errors, $field)
{
    $html = '';
    if ($errors->first($field) != '') {
        foreach ($errors->get($field) as $message) {
            $html .= '<span class="invalid-feedback" role="alert"><strong>' . $message . '</strong></span>';
        }
    }

    return $html;
}

function showErrorsNotice($errors)
{
    $html = '';
    if (count($errors) > 0) {
        $html .= '<div class="alert alert-danger">You have some form errors. Please check below.<ul>';
        foreach ($errors->all() as $message) {
            $html .= '<li><span class="invalid-feedback" role="alert"><strong>' . $message . '</strong></span></li>';
        }
        $html .= '</ul></div>';
    }

    return $html;
}

function showOnlyErrorsNotice($errors)
{
    $html = '';
    if (count($errors) > 0) {
        $html = '<div class="alert alert-danger">You have some form errors. Please check below.</div>';
    }

    return $html;
}
