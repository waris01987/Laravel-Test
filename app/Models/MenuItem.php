<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
	/**
     * Get sub menus for the current menu.
     */
	public function subMenus() {
	    return $this->hasMany($this, 'parent_id', 'id');
	}

	/**
     * Get all childrens (recursive call) for the current menu.
     */
	public function children() {
	    return $this->subMenus()->with('children');
	}
}
