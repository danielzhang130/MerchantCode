<?php

namespace App\Utils;

class TreeTransformer
{
    public function toTree($merchants): array
    {
        $category_map = [];
        $sub_category_map = [];
        $categories = [];

        foreach ($merchants as $entry) {
            $subCategory = $entry->subCategory->name;
            $category = $entry->subCategory->category->name;

            if (!isset($category_map[$category])) {
                $new_category = [
                    "name" => $category,
                    "subcategories" => []
                ];
                $category_map[$category] = sizeof($categories);
                $categories[] = $new_category;
            }

            if (!isset($sub_category_map[$subCategory])) {
                $new_sub_category = [
                    "name" => $subCategory,
                    "merchants" => []
                ];
                $sub_category_map[$subCategory] = sizeof($categories[$category_map[$category]]["subcategories"]);
                $categories[$category_map[$category]]["subcategories"][] = $new_sub_category;
            }

            if (in_array($entry->name, $categories[$category_map[$category]]["subcategories"][$sub_category_map[$subCategory]]["merchants"])) {
                continue;
            }
            $categories[$category_map[$category]]["subcategories"][$sub_category_map[$subCategory]]["merchants"][] = $entry->name;
        }

        return $categories;
    }
}