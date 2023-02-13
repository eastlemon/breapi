<?php

namespace app\jobs;

use app\modules\admin\models\Fio;
use app\modules\admin\models\Inn;
use app\modules\admin\models\Phone;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class LoaderJob extends BaseObject implements JobInterface
{
    public array $data;
    public int $uid;
    public int $tag;
    public int $year;
    public array $keys;
    public bool $composite;

    public function execute($queue): void
    {
        if (isset($this->data[$this->keys['inn']])) {
            if ($this->composite !== true) $fio = $this->data[$this->keys['fio']];
            else $fio = $this->data[$this->keys['surname']] . ' ' .
                $this->data[$this->keys['name']] . ' ' .
                $this->data[$this->keys['patronymic']];

            $inn = (string) $this->data[$this->keys['inn']];

            $phone = (string) $this->data[$this->keys['phone']];

            if (($_inn = Inn::findOne(['inn' => $inn])) === null) {
                $_inn = new Inn();
                $_inn->id_user = $this->uid;
                $_inn->id_tag = $this->tag;
                $_inn->inn = $inn;
                $_inn->save();
            }

            (new Fio($_inn->id, $this->year, $fio))->save();

            (new Phone($_inn->id, $this->year, $phone))->save();
        }
    }
}
