<?php

namespace Encore\Admin;

/**
 * Trait ModelForm
 * @package Encore\Admin
 */
/**
 * Trait ModelForm
 * @package Encore\Admin
 */
trait ModelForm
{

    /**
     * @return mixed
     */
    public function show()
    {
        return $this->edit($_REQUEST["id"]);
    }


    /**
     * @return mixed
     */
    public function update()
    {
        return $this->form($_REQUEST["id"])->update($_REQUEST["id"]);
    }


    /**
     *
     */
    public function destroy()
    {

        if ($this->form($_REQUEST["id"])->destroy($_REQUEST["id"])) {
            exit(json_encode([
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ]));
        } else {
            exit(json_encode([
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ]));
        }
    }


    /**
     * @return mixed
     */
    public function store()
    {
        return $this->form($_REQUEST["id"])->store();
    }
}
