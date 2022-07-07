<?php declare(strict_types=1);namespace Pdp;use Pdp\Exception\SeriouslyMalformedUrlException;use Pdp\Uri\Url;use Pdp\Uri\Url\Host;class Parser{const SCHEME_PATTERN='#^([a-zA-Z][a-zA-Z0-9+\-.]*)://#';const IP_ADDRESS_PATTERN='/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';protected $publicSuffixList;protected $isNormalized=false;private $punycodeWrapper;public function __construct(PublicSuffixList $publicSuffixList){$this->publicSuffixList=$publicSuffixList;$this->punycodeWrapper=new PunycodeWrapper();}public function parseUrl($url):Url{$rawUrl=$url;$elem=['scheme'=>null,'user'=>null,'pass'=>null,'host'=>null,'port'=>null,'path'=>null,'query'=>null,'fragment'=>null,];if(\preg_match(self::SCHEME_PATTERN,$url)===0){$url='php-hack://'.\preg_replace('#^//#','',$url,1);}$parts=pdp_parse_url($url);if($parts===false||!isset($parts['host'])){throw new SeriouslyMalformedUrlException($rawUrl);}if($parts['scheme']==='php-hack'){$parts['scheme']=null;}$elem=(array) $parts+$elem;$host=$this->parseHost($parts['host']);return new Url($elem['scheme'],$elem['user'],$elem['pass'],$host,$elem['port'],$elem['path'],$elem['query'],$elem['fragment']);}public function parseHost(string $host):Host{$host=\voku\helper\UTF8::strtolower($host);return new Host($this->getSubdomain($host),$this->getRegistrableDomain($host),$this->getPublicSuffix($host),$host);}public function getPublicSuffix(string $host){if(\strpos($host,'.')===0){return null;}if(!$this->isMultiLabelDomain($host)){return null;}if($this->isIpv4Address($host)){return null;}$suffix=$this->getRawPublicSuffix($host);if($suffix===false){$parts=\array_reverse(\explode('.',$host));$suffix=\array_shift($parts);}return $suffix;}public function isSuffixValid(string $host):bool{return $this->getRawPublicSuffix($host)!==false;}public function getRegistrableDomain($host){if($host===null||!$this->isMultiLabelDomain($host)){return null;}$publicSuffix=$this->getPublicSuffix($host);if($publicSuffix===null||$host==$publicSuffix){return null;}$publicSuffixParts=\array_reverse(\explode('.',$publicSuffix));$hostParts=\array_reverse(\explode('.',$host));$registrableDomainParts=$publicSuffixParts+\array_slice($hostParts,0,\count($publicSuffixParts)+1);return \implode('.',\array_reverse($registrableDomainParts));}public function getSubdomain(string $host){$registrableDomain=$this->getRegistrableDomain($host);if($registrableDomain===null||$host===$registrableDomain){return null;}$registrableDomainParts=\array_reverse(\explode('.',$registrableDomain));$host=$this->normalize($host);$hostParts=\array_reverse(\explode('.',$host));$subdomainParts=\array_slice($hostParts,\count($registrableDomainParts));$subdomain=\implode('.',\array_reverse($subdomainParts));return $this->denormalize($subdomain);}protected function getRawPublicSuffix(string $host){$host=$this->normalize($host);$parts=\array_reverse(\explode('.',$host));$publicSuffix=\Arrayy\Arrayy::create();$publicSuffixList=clone $this->publicSuffixList;foreach($parts as $part){if($publicSuffixList->keyExists($part)&&($partValue=$publicSuffixList->get($part))){if($partValue->keyExists('!')){break;}$publicSuffix->unshift($part);$publicSuffixList=$partValue;continue;}if($publicSuffixList->keyExists('*')){$publicSuffix->unshift($part);$publicSuffixList=$publicSuffixList->get('*');continue;}break;}if($publicSuffix->isEmpty()){return false;}$suffix=$publicSuffix->filter(static function($value){return \strlen($value);})->implode('.');return $this->denormalize($suffix);}protected function normalize(string $part):string{$punycoded=(\strpos($part,'xn--')!==false);if($punycoded===false){$part=$this->punycodeWrapper->encode($part);$this->isNormalized=true;}return \voku\helper\UTF8::strtolower($part);}protected function denormalize(string $part):string{if($this->isNormalized===true){$part=$this->punycodeWrapper->decode($part);$this->isNormalized=false;}return $part;}protected function isMultiLabelDomain($host):bool{if(!$host){return false;}return \strpos($host,'.')!==false;}protected function isIpv4Address(string $host):bool{return \preg_match(self::IP_ADDRESS_PATTERN,$host)===1;}}