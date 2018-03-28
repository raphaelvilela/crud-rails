<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputText extends Input
{
    public $placeholder;
    public $label;
    public $mask;

    public function __construct(
        string $name,
        ?string $value,
        ?string $label,
        string $placeholder = null,
        string $mask = null)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputText");
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->mask = $mask;
    }
}