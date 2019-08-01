<?php

$start = "https://www.blocket.se/goteborg?ca=15";

$already_crawled = array();

function get_details($url)  {
  $options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: maedayBot/0.1\n"));

  $context = stream_context_create($options);

  $doc = new DOMdocument('1.0', 'UTF-8');
  $internalErrors = libxml_use_internal_errors(true);
  @$doc->loadHTML(@file_get_contents($url, false, $context));
  libxml_use_internal_errors($internalErrors);

  $title = $doc->getElementsByTagName("title");
  $title = $title->item(0)->nodeValue;

  // $price = $doc->getElementsByTagName("vi_price");
  // $price = $price->item(0)->nodeValue;

  $description = "";
  // $keywords = "";
  $price = "";
  $photos = "";

  $metas = $doc->getElementsByTagName("meta");

  for ($i = 0; $i < $metas->length; $i++) {
    $meta = $metas->item($i);

    if ($meta->getAttribute("name") == ("description"))
    $description = $meta->getAttribute("content");
    // if ($meta->getAttribute("name") == ("keywords"))
    // $keywords = $meta->getAttribute("content");
  }

  $divs = $doc->getElementsByTagName("div");

  for ($i = 0; $i < $divs->length; $i++) {
    $div = $divs->item($i);

    if ($div->getAttribute("id") == ("vi_price"))
    $price = $div->getAttribute(".innertext");

  }

  echo $price."\n"."\n";

}

function follow_links($url) {
  global $already_crawled;

  $options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: amandaBot/0.1\n"));

  $context = stream_context_create($options);

  $doc = new DOMdocument('1.0', 'UTF-8');
  $internalErrors = libxml_use_internal_errors(true);
  @$doc->loadHTML(@file_get_contents($url, false, $context));
  libxml_use_internal_errors($internalErrors);

  $linklist = $doc->getElementsByTagName("a");

  foreach ($linklist as $link) {
    if ($link->getAttribute("class") == ("item_link"))
    $l = $link->getAttribute("href");

    if (!in_array($l, $already_crawled)) {
      $already_crawled[] = $l;
      echo get_details($l);
      //echo $l."\n";

    }
  }
}

follow_links($start);

print_r($already_crawled);