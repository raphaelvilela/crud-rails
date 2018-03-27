<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputPhoto extends Input
{
    protected $label;

    public function __construct(
        string $name,
        string $value,
        string $label)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputPhoto");
        $this->label = $label;
    }
}