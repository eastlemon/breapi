<?php

namespace app\jobs;

use app\models\Inn;
use app\modules\admin\models\Filler;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class FillerJob extends BaseObject implements JobInterface
{
    public array $data;
    public array $keys;
    public int $fid;

    public function execute($queue): void
    {
        if (isset($this->data[$this->keys['inn']])) {
            if ($_inn = Inn::findOne(['inn' => $this->data[$this->keys['inn']]])) {
                \Yii::error($_inn);
                \Yii::error(end($_inn->fios)->fio);
                \Yii::error(end($_inn->phones)->phone);

                $filler = new Filler();
                $filler->id_file = $this->fid;
                $filler->fio = end($_inn->fios)->fio;
                $filler->inn = $_inn->inn;
                $filler->phone = (string) $this->data[$this->keys['phone']] ?: end($_inn->phones)->phone;
                $filler->save();
            }
        }
    }
}
