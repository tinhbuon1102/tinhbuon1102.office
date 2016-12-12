<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});


// Home > Help
Breadcrumbs::register('help', function($breadcrumbs)
{
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Help', route('help'));
});


// Home > Help > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('help');
    $breadcrumbs->push($category['title'], $category['url']);
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page['category']);
    $breadcrumbs->push($page['title'], $page['url']);
});