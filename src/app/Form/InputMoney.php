<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class InputMoney extends Input
{
    protected $placeholder;
    protected $label;

    public function __construct(
        string $name,
        ?string $value,
        string $label,
        string $placeholder = null)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputMoney");
        $this->label = $label;
        $this->placeholder = $placeholder;
    }
}