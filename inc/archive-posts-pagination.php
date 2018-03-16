<?php

$feed_posts = new Timber\PostQuery();
$context['posts'] = $feed_posts;

$feed_pagination = $feed_posts->pagination();

foreach( $feed_pagination->pages as $i => $po) {
	$feed_pagination->pages[$i]['state'] = ($po['current']) ? 'active' : 'disabled';
}
$context['page_items'] = $feed_pagination->pages;
