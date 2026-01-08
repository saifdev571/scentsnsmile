<?php
use App\Models\ScentFamily;

$families = ScentFamily::all(['id', 'name', 'slug']);
foreach ($families as $f) {
    echo "ID: {$f->id} | Name: {$f->name} | Slug: {$f->slug}\n";
}
