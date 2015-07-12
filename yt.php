<?php
$id = 'UCBR8-60-B28hp2BmDPdntcQ';
if (isset($_GET['user'])) {$user = $_GET['user'];}
if (isset($_GET['id'])) {$id = $_GET['id'];}
$base_url = 'https://www.youtube.com/feeds/videos.xml?';
if (isset($_GET['user'])) { $url = $base_url . 'user=' . $user;} else  { $url = $base_url . 'channel_id=' . $id;}
$html = file_get_contents($url);
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
libxml_use_internal_errors(false);
$xpath = new DOMXpath($doc);
$mainTitle = $xpath->query('//title')->item(0)->nodeValue;
$items = $xpath->query('//entry');

header('Content-type: text/xml; charset=utf-8');

echo('<?xml version="1.0" encoding="utf-8"?>
	<rss>
		<channel>
			<title>' . $mainTitle . '</title>
				');
				if (!is_null($items)) {
	foreach ($items as $item) {
    $title = $item->getElementsByTagName('title')->item(0)->nodeValue;
	$href = $item->getElementsByTagName('link')->item(0)->getAttribute('href');
	$pub = $item->getElementsByTagName('published')->item(0)->nodeValue;
	$date = date(DateTime::RSS, strtotime($pub));

echo('<item>
		<title>' . $title . '</title>
		<link>' . $href . '</link>
		<pubDate>' . $date . '</pubDate>
</item>');		
	}
}
echo('
		</channel>
	</rss>');
	?>
