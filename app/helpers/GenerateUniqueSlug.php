<?php
use Illuminate\Support\Str;

function generateUniqueSlug($model, $title, $field = 'slug')
{
    $slug = Str::slug($title);
    $originalSlug = $slug;

    $i = 1;
    while ($model::where($field, $slug)->exists()) {
        $slug = $originalSlug . '-' . $i++;
    }

    return $slug;
}