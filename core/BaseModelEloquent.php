<?php
namespace Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

$conf = require_once __DIR__ . "/../app/database.php";

$capsule = new Capsule;

if($conf['driver'] == 'mysql'){
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $conf['mysql']['host'],
        'database'  => $conf['mysql']['database'],
        'username'  => $conf['mysql']['username'],
        'password'  => $conf['mysql']['password'],
        'charset'   => $conf['mysql']['charset'],
        'collation' => $conf['mysql']['collation'],
        'prefix'    => ''
    ]);
}
$capsule->setAsGlobal();
$capsule->bootEloquent();

abstract class BaseModelEloquent extends Model {

}
