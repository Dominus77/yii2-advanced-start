<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator common\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getTraitsNamespace() ?>;

trait ActiveRecordDbConnectionTrait
{
    public static function getDb()
    {
        return \Yii::$app->db;
    }
}
