<?php

namespace app\jobs;

use app\models\Inn;
use app\modules\admin\models\Filler;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\helpers\Json;
use yii\queue\JobInterface;

/**
 * @throws Exception
 */
class FillerJob extends BaseObject implements JobInterface
{
    public array $data;
    public array $keys;
    public int $fid;

    public function execute($queue): void
    {
        if (isset($this->data[$this->keys['inn']])) {
            Yii::error($this->keys['inn']);
            Yii::error($this->data[$this->keys['inn']]);

            $_j = Inn::findOne(['inn' => $this->data[$this->keys['inn']]]);
            Yii::error(Json::encode($_j));
            Yii::error(Json::encode($_j->fios));
//            if ($_inn = Inn::findOne(['inn' => $this->data[$this->keys['inn']]])) {
//                Yii::error($_inn);
//                    $fios = end($_inn->fios);
//                    Yii::error($fios->fio);
//                    $phones = end($_inn->phones);
//                    Yii::error($phones->phone);
//
//                    $filler = new Filler();
//                    $filler->id_file = $this->fid;
//                    $filler->fio = end($_inn->fios)->fio;
//                    $filler->inn = $_inn->inn;
//                    $filler->phone = (string) $this->data[$this->keys['phone']] ?: end($_inn->phones)->phone;
//                    $filler->save();
//            }
        }
    }
}
