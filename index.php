<?php

$start = "https://www.blocket.se/goteborg?ca=15";

function follow_links($url) {

  $doc = new DOMdocument('1.0', 'UTF-8');
  $internalErrors = libxml_use_internal_errors(true);
  $doc->loadHTML(file_get_contents($url));
  libxml_use_internal_errors($internalErrors);

  $linklist = $doc->getElementsByTagName("a");

  foreach ($linklist as $link) {
    echo $link->getAttribute("href")."\n";
  }

}

follow_links($start);