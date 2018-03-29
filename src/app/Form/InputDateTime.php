<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputDateTime extends Input
{
    public $placeholder;
    public $label;

    public function __construct(
        string $date_field_name,
        ?string $date_field_value,
        string $time_field_name,
        ?string $time_field_value,
        string $label)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputDate");
        $this->label = $label;
    }
}