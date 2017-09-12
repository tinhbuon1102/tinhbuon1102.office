<?php
namespace App\Http\Controllers;

use Sitemap;
use Cache;

class SitemapsController extends Controller
{
	public function index()
	{
		// You can use the route helpers too.
		Sitemap::addSitemap(route('sitemaps.pages'));
	
		// Return the sitemap to the client.
		return Sitemap::index();
	}
	
	public function pages()
	{
		$posts = array(
			'/',
			'/RentUser/Dashboard/SearchSpaces',
			'/how-it-works',
			'/how-it-works/find-space',
			'/how-it-works/list-space',
			'/how-it-works/manage-booking',
			'/help/shareuser/listspace',
			'/help/shareuser/add-schedule',
			'/help/shareuser/check-booking',
			'/help/shareuser/review',
		);

		foreach ($posts as $post) {
			Sitemap::addTag(url($post), '2017-09-12', 'monthly', '0.8');
		}

		return Sitemap::render();
	}
	
	public function clearSiteMapCache()
	{
		Cache::flush();
	}
	
}