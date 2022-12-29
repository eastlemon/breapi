<?php

namespace app\jobs;

use app\modules\admin\models\Fio;
use app\modules\admin\models\Inn;
use app\modules\admin\models\Phone;
use yii\base\BaseObject;
use yii\helpers\StringHelper;
use yii\queue\JobInterface;

class LoaderJob extends BaseObject implements JobInterface
{
    public array $data;
    public int $uid;
    public int $tag;
    public int $year;
    public string $format;

    public function execute($queue): void
    {
        $keys = [];

        $composite = false;

        foreach (StringHelper::explode($this->format) as $key => $item) {
            if ($item == '@') continue;

            if ($item == 'FIO') $keys['fio'] = $key;
            if ($item == 'INN') $keys['inn'] = $key;
            if ($item == 'Phone') $keys['phone'] = $key;
            if ($item == 'Surname') $keys['surname'] = $key;
            if ($item == 'Name') $keys['name'] = $key;
            if ($item == 'Patronymic') $keys['patronymic'] = $key;

            if (isset($keys['surname']) && isset($keys['name']) && isset($keys['patronymic'])) $composite = true;
        }

        if ((isset($keys['surname']) && isset($keys['name']) && isset($keys['patronymic'])) || isset($keys['fio'])) {
            if (isset($keys['inn'])) {
                if ($composite !== true) $full_name = $this->data[$keys['fio']];
                else $full_name = $this->data[$keys['surname']] . ' ' .
                    $this->data[$keys['name']] . ' ' .
                    $this->data[$keys['patronymic']];

                $inn = (string) $this->data[$keys['inn']];

                $phone = (string) $this->data[$keys['phone']];

                if (($_inn = Inn::findOne(['inn' => $inn])) === null) {
                    $_inn = new Inn();
                    $_inn->id_user = $this->uid;
                    $_inn->id_tag = $this->tag;
                    $_inn->inn = $inn;
                    $_inn->save();
                }

                (new Fio($_inn->id, $this->year, $full_name))->save();
                (new Phone($_inn->id, $this->year, $phone))->save();
            }
        }
    }
}
