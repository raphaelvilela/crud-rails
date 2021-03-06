<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:59
 */

namespace RaphaelVilela\CrudRails\App\Form;
use Illuminate\Support\Collection;

class InputSelect extends Input
{
    public $label;
    public $options;

    public function __construct(
        string $name,
        ?string $value,
        string $label,
        Collection $options = null)
    {
        parent::__construct($name, $value, "crud-rails::forms.components.select");
        $this->label = $label;
        $this->options = $options;
    }
}