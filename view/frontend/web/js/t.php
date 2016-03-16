<?php
class Model_GoogleBaseFeed {

function buildAndUploadDolphinFeed() {

    $googlebase = array(
    'protocol'  =>'http',
    'url'       =>'uploads.google.com',
    'port'      =>21,
    'username'  =>'dolphin33',
    'password'  =>'AcHeA4UdGM9c8u2We',
    'filename'  =>'googlebase.xml'
    );

    $filename = "googlebase.dolphinmusic.895623ACZ.xml";

    $googlebase['DOLPHIN_AUTHCODE']='Up1290';

    $this->MINSIZE = 5000000;

// ------------------------------------------

$products = $this->getProductFeed_Dolphin();

$xml = $this->buildDolphinXML($feed,$products);

// ------------------------------------------
// Save XML File
// ------------------------------------------

$result = $this->saveToFile($xml,$filePathname);

$feedSize = ($result ? round(filesize($filePathname)/1000) : 'FAILED');

// ------------------------------------------
// Upload the feed to Google Base server
// ------------------------------------------

if ($result) {

$result = $this->uploadToServer($filePathname,$googlebase);

$feedFile = ($result ? $filePathname : 'FAILED');
}

// ------------------------------------------
// All done
// ------------------------------------------

if ($result) {
$this->logFeed($feed,$products);

DOLPHIN_AUDIT('FEEDS','GOOGLEBASE',"Created feed file: {$feedSize}kb - upload:{$feedFile}");

} else {

DOLPHIN_AUDIT(Dolphin_Audit::EVENT_CRITICAL_ERROR,"GoogleBase feed for Dolphin failed to execute");

}
