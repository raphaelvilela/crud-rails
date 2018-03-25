<?php

namespace RaphaelVilela\CrudRails\App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $guarded = [];
    public $rules = array(
        'title' => 'max:255',
        'photo' => 'required_without:url|mimes:jpg,jpeg,bmp,png',
        'ong_id' => 'required'
    );
}
