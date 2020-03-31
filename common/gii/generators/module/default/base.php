<?php
/* @var $generator common\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);
$path = str_replace('\\', '/', $ns);
$pos = strrpos($path, '/');
$moduleName = substr($ns, $pos + 1);
