<?php

$start = "https://www.blocket.se/goteborg?ca=15";

$already_crawled = array();

function follow_links($url) {

  global $already_crawled;

  $doc = new DOMdocument('1.0', 'UTF-8');
  $internalErrors = libxml_use_internal_errors(true);
  $doc->loadHTML(file_get_contents($url));
  libxml_use_internal_errors($internalErrors);

  $linklist = $doc->getElementsByTagName("a");

  foreach ($linklist as $link) {
    $l = $link->getAttribute("href");

    if (!in_array($l, $already_crawled)) {
      $already_crawled[] = $l;
      echo $l."\n";

    }
  }
}

follow_links($start);

print_r($already_crawled);