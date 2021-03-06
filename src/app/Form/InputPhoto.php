<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


use RaphaelVilela\CrudRails\App\Photo;

class InputPhoto extends Input
{
    public $label;
    public $photo;

    public function __construct(
        string $name,
        ?string $value,
        string $label,
        ?Photo $photo)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputPhoto");
        $this->label = $label;
        $this->photo = $photo;
    }
}