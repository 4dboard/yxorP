<?php namespace yxorP\Build;use yxorP\Build\Exceptions\IOException;use Psr\Cache\CacheItemInterface;abstract class Minify{protected $data=array();protected $patterns=array();public $extracted=array();public function __construct(){if(func_num_args()){call_user_func_array(array($this,'add'),func_get_args());}}public function add($data){$args=array($data)+func_get_args();foreach($args as $data){if(is_array($data)){call_user_func_array(array($this,'add'),$data);continue;}$data=(string) $data;$value=$this->load($data);$key=($data!=$value)?$data:count($this->data);$value=str_replace(array("\r\n","\r"),"\n",$value);$this->data[$key]=$value;}return $this;}public function addFile($data){$args=array($data)+func_get_args();foreach($args as $path){if(is_array($path)){call_user_func_array(array($this,'addFile'),$path);continue;}$path=(string) $path;if(!$this->canImportFile($path)){throw new IOException('The file "'.$path.'" could not be opened for reading. Check if PHP has enough permissions.');}$this->add($path);}return $this;}public function minify($path=null){$content=$this->execute($path);if($path!==null){$this->save($content,$path);}return $content;}public function gzip($path=null,$level=9){$content=$this->execute($path);$content=gzencode($content,$level,FORCE_GZIP);if($path!==null){$this->save($content,$path);}return $content;}public function cache(CacheItemInterface $item){$content=$this->execute();$item->set($content);return $item;}abstract public function execute($path=null);protected function load($data){if($this->canImportFile($data)){$data=file_get_contents($data);if(substr($data,0,3)=="\xef\xbb\xbf"){$data=substr($data,3);}}return $data;}protected function save($content,$path){$handler=$this->openFileForWriting($path);$this->writeToFile($handler,$content);@fclose($handler);}protected function registerPattern($pattern,$replacement=''){$pattern.='S';$this->patterns[]=array($pattern,$replacement);}protected function replace($content){$contentLength=strlen($content);$output='';$processedOffset=0;$positions=array_fill(0,count($this->patterns),-1);$matches=array();while($processedOffset<$contentLength){foreach($this->patterns as $i=>$pattern){list($pattern,$replacement)=$pattern;if(array_key_exists($i,$positions)==false){continue;}if($positions[$i]>=$processedOffset){continue;}$match=null;if(preg_match($pattern,$content,$match,PREG_OFFSET_CAPTURE,$processedOffset)){$matches[$i]=$match;$positions[$i]=$match[0][1];}else{unset($matches[$i],$positions[$i]);}}if(!$matches){$output.=substr($content,$processedOffset);break;}$matchOffset=min($positions);$firstPattern=array_search($matchOffset,$positions);$match=$matches[$firstPattern];list(,$replacement)=$this->patterns[$firstPattern];$output.=substr($content,$processedOffset,$matchOffset-$processedOffset);$output.=$this->executeReplacement($replacement,$match);$processedOffset=$matchOffset+strlen($match[0][0]);}return $output;}protected function executeReplacement($replacement,$match){if(!is_callable($replacement)){return $replacement;}foreach($match as&$matchItem){$matchItem=$matchItem[0];}return $replacement($match);}protected function extractStrings($chars='\'"',$placeholderPrefix=''){$minifier=$this;$callback=function($match)use($minifier,$placeholderPrefix){if($match[2]===''){return $match[0];}$count=count($minifier->extracted);$placeholder=$match[1].$placeholderPrefix.$count.$match[1];$minifier->extracted[$placeholder]=$match[1].$match[2].$match[1];return $placeholder;};$this->registerPattern('/(['.$chars.'])(.*?(?<!\\\\)(\\\\\\\\)*+)\\1/s',$callback);}protected function restoreExtractedData($content){if(!$this->extracted){return $content;}$content=strtr($content,$this->extracted);$this->extracted=array();return $content;}protected function canImportFile($path){$parsed=parse_url($path);if(isset($parsed['host'])||isset($parsed['query'])){return false;}return strlen($path)<PHP_MAXPATHLEN&&@is_file($path)&&is_readable($path);}protected function openFileForWriting($path){if($path===''||($handler=@fopen($path,'w'))===false){throw new IOException('The file "'.$path.'" could not be opened for writing. Check if PHP has enough permissions.');}return $handler;}protected function writeToFile($handler,$content,$path=''){if(!is_resource($handler)||($result=@fwrite($handler,$content))===false||($result<strlen($content))){throw new IOException('The file "'.$path.'" could not be written to. Check your disk space and file permissions.');}}}