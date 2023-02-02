<?php

namespace App\Model;

class Entry
{

    public string $merchant;

    public string $category;

    public string $sub_category;

    public function __construct(string $merchant, string $category, string $sub_category)
    {
        $this->merchant = $merchant;
        $this->category = $category;
        $this->sub_category = $sub_category;
    }
}