<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputHidden extends Input
{
    public function __construct(string $name, ?string $value)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputHidden");
    }
}