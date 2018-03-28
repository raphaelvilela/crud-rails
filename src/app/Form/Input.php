<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 26/03/2018
 * Time: 20:55
 */

namespace RaphaelVilela\CrudRails\App\Form;

class Input
{
    protected $name;
    protected $value;
    protected $view_component;

    public function __construct(string $name, ?string $value, string $view_component)
    {
        $this->name = $name;
        $this->value = $value;
        $this->view_component = $view_component;
    }

}