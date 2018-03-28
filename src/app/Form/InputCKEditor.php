<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputCKEditor extends Input
{
    public $placeholder;
    public $label;

    public function __construct(
        string $name,
        ?string $value,
        ?string $label,
        string $placeholder = null)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputCKEditor");
        $this->label = $label;
        $this->placeholder = $placeholder;
    }
}