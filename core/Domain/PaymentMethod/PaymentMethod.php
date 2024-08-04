<?php

namespace Core\Domain\PaymentMethod;

class PaymentMethod
{
    public $id;
    public $name;
    public $slug;

    public function __construct($id, $name, $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }
}
