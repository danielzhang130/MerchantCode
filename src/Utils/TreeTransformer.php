<?php

namespace App\Utils;

class TreeTransformer
{
    public function toTree($merchants): array
    {
        $categories = [];
        foreach ($merchants as $entry) {
            $subCategory = $entry->subCategory->name;
            $category = $entry->subCategory->category->name;
            if (!isset($categories[$category])) {
                $categories[$category] = [];
            }
            if (!isset($categories[$category][$subCategory])) {
                $categories[$category][$subCategory] = [];
            }
            if (in_array($entry->name, $categories[$category][$subCategory])) {
                continue;
            }
            $categories[$category][$subCategory][] = $entry->name;
        }

        return $categories;
    }
}