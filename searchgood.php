<?php
$url = $_GET['goodid'];
class PddGoodGen{
public $type="pdd.ddk.goods.promotion.url.generate";
public $customParameters;
public $pid;
public $sourceUrl;
public $apiParas=array();
public function __construct($type=""){
$this->apiParas["type"]=$this->type;
}
public function setPid($pid)
{
$this->pid = $pid;
$this->apiParas["p_id"]=$pid;
}
public function setgoods_sign_list($goods_sign_list)
{
$this->goods_sign_list = $goods_sign_list;
$this->apiParas["goods_sign_list"]=$goods_sign_list;
}
}
class TopClient{ 
public $client_id;
public $client_secret;
public $access_token; 
public $data_type="JSON";
public $url="https://gw-api.pinduoduo.com/api/router";
public function execute($req){ 
$param=$req->apiParas; 
$param["client_id"]=$this->client_id; 
$param["data_type"]=$this->data_type; 
$param["timestamp"]=time(); 
if(isset($this->access_token)) $param["access_token"]=$this->access_token;
ksort($param);
$str = '';
foreach ($param as $k => $v) $str .= $k . $v;
$sign = strtoupper(md5($this->client_secret. $str . $this->client_secret));
$param["sign"] = $sign;
$url=$this->url;
return $this->curl_post($url, $param);
}
function curl_post($url, $postdata){ 
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url); 
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_TIMEOUT, 60); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_POST, 1); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
$data = curl_exec($curl); 
curl_close($curl); 
return $data;
}
}
$c=new TopClient;
$c->client_id="";
$c->client_secret="";
$req=new PddGoodGen;
$req->setPid("23759023_216008895");
$req->setgoods_sign_list($url);
print_r($c->execute($req))
?>