<?php
class urlPreviewDetails {
    
    private $dom="";
    public $websiteDetails=array();
    private $imageArr=array();
    
    public function __construct($url) {
        $this->initializeDom($url);
    }
    
    private function initializeDom($url){
        if($url!=""){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $this->dom= new DOMDocument();
        @$this->dom->loadHTML($data);
        $this->websiteDetails["Url"]=$url;
        return $this->dom;
        }
        else
        {
            echo "Url is empty";
        }
    }
    
    function listWebsiteDetails(){
        $this->websiteDetails["Title"]=$this->getWebsiteTitle();
        $this->websiteDetails["Description"]=$this->getWebsiteDescription();
        $this->websiteDetails["Keywords"]=$this->getWebsiteKeyword();
        $this->websiteDetails["Image"]=$this->getWebsiteImages();
        return json_encode($this->websiteDetails);
    }
    
    function getWebsiteTitle(){
        $titleNode=$this->dom->getElementsByTagName("title");
        $titleValue=$titleNode->item(0)->nodeValue;
        return $titleValue;
    }
    
    function getWebsiteDescription(){
        $descriptionNode=$this->dom->getElementsByTagName("meta");
        for ($i=0; $i < $descriptionNode->length; $i++) {
             $descriptionItem=$descriptionNode->item($i);
             if($descriptionItem->getAttribute('name')=="description"){
                return $descriptionItem->getAttribute('content');
             }
        }
    }
    
    function getWebsiteKeyword(){
        $keywordNode=$this->dom->getElementsByTagName("meta");
        for ($i=0; $i < $keywordNode->length; $i++) {
             $keywordItem=$keywordNode->item($i);
             if($keywordItem->getAttribute('name')=="keywords"){
                return $keywordItem->getAttribute('content');
             }
        }
    }
    
    function getWebsiteImages(){
        $imageNode=$this->dom->getElementsByTagName("img");
        for ($i=0; $i < $imageNode->length; $i++) {
             $imageItem=$imageNode->item($i);
                $this->imageArr[].=$imageItem->getAttribute('src');
        }
        return $this->imageArr;
    }
    
    function getWebsiteOgImage(){
        $descriptionNode=$this->dom->getElementsByTagName("meta");
        for ($i=0; $i < $descriptionNode->length; $i++) {
             $descriptionItem=$descriptionNode->item($i);
             if($descriptionItem->getAttribute('property')=="og:image"){
                return $descriptionItem->getAttribute('content');
             }
        }
    }
}

$url=$_POST["url"];
$urlPreview=new urlPreviewDetails($url);
echo $urlPreview->listWebsiteDetails();