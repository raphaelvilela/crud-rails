<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;


class  InputYesOrNo extends Input
{
    public $label;

    public function __construct(
        string $name,
        ?string $value,
        ?string $label)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.inputYesOrNo");
        $this->label = $label;
    }
}