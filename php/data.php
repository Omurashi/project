<?php
namespace php;
require_once dirname(__FILE__) . '/Bootstrap.class.php';

use php\Bootstrap;
use php\lib\PDODatabase;
use php\lib\Database;

use php\lib\Mail;
use php\lib\Recruit;

use php\lib\Session;
use php\lib\Cart;
use php\lib\Item;
use php\lib\Common;
use php\lib\Member;
use php\master\initMaster;


$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER,
 Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
 $qdb = new Database(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME);


$mem = new Member($db);
$mail = new Mail($db);

$ses = new Session ($db);
$itm = new Item($db);
$common = new Common();

$cart = new Cart($db);
$rec = new Recruit($db);

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
     'cache' => Bootstrap::CACHE_DIR
]);
$context = [];
if(isset($_SESSION)){
  $userData = $_SESSION;
  $hello = 'こんにちは' . $userData['user_id'] . 'さん';
}else{
  $userData = '';
}

$context['hello'] = $hello;
$context['userData'] = $userData;

//性別の設定
$context['sexArr'] = initMaster::getSex();
//交通手段の設定
$context['trafficArr'] = initMaster::getTrafficWay();

//カテゴリーの設定
$context['ctg_id'] = initMaster::getCtgId();

//日付を設定する
list($yearArr, $monthArr, $dayArr) = initMaster::getDate();
$context['yearArr'] = $yearArr;
$context['monthArr'] = $monthArr;
$context['dayArr'] = $dayArr;
?>