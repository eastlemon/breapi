<?php

namespace app\jobs;

use app\models\Inn;
use app\modules\admin\models\Filler;
use yii\base\BaseObject;
use yii\base\Exception;
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
            if ($_inn = Inn::findOne(['inn' => $this->data[$this->keys['inn']]])) {
                $filler = new Filler();
                $filler->id_file = $this->fid;
                $filler->fio = $_inn->fios[array_key_last($_inn->fios)]['fio'];
                $filler->inn = $_inn->inn;
                $filler->phone = (string) $this->data[$this->keys['phone']] ?:
                    $_inn->phones[array_key_last($_inn->phones)]['phone'];
                $filler->save();
            }
        }
    }
}
