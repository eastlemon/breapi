<?php

namespace app\jobs;

use app\modules\admin\models\Fio;
use app\modules\admin\models\Inn;
use app\modules\admin\models\Phone;
use Yii;
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

                if (static::isValidInn($inn)) {
                    $phone = (string) $this->data[$keys['phone']];

                    if (($_inn = Inn::findOne(['inn' => $inn])) !== null) {
                        if ((Fio::findOne(['fio' => $full_name])) === null) {
                            (new Fio($_inn->id, $this->year, $full_name))->save();
                        }
                        if ((Phone::findOne(['phone' => $phone])) === null) {
                            (new Phone($_inn->id, $this->year, $phone))->save();
                        }
                    } else {
                        $_inn = new Inn();
                        $_inn->id_user = $this->uid;
                        $_inn->id_tag = $this->tag;
                        $_inn->inn = $inn;
                        $_inn->save();

                        (new Fio($_inn->id, $this->year, $full_name))->save();

                        (new Phone($_inn->id, $this->year, $phone))->save();
                    }
                }
            }
        }
    }

    public static function isValidInn(string $inn): bool
    {
        if (strlen($inn) == 10) {
            if (preg_match('#([\d]{10})#', $inn, $m)) {
                $inn = $m[0];
                $code10 = (($inn[0] * 2 + $inn[1] * 4 + $inn[2] *10 + $inn[3] * 3 +
                            $inn[4] * 5 + $inn[5] * 9 + $inn[6] * 4 + $inn[7] * 6 +
                            $inn[8] * 8) % 11 ) % 10;
                if ($code10 == $inn[9]) return true;
            }
        } else {
            if (preg_match('#([\d]{12})#', $inn, $m)) {
                $inn = $m[0];
                $code11 = (($inn[0] * 7 + $inn[1] * 2 + $inn[2] * 4 + $inn[3] *10 +
                            $inn[4] * 3 + $inn[5] * 5 + $inn[6] * 9 + $inn[7] * 4 +
                            $inn[8] * 6 + $inn[9] * 8) % 11 ) % 10;
                $code12 = (($inn[0] * 3 + $inn[1] * 7 + $inn[2] * 2 + $inn[3] * 4 +
                            $inn[4] *10 + $inn[5] * 3 + $inn[6] * 5 + $inn[7] * 9 +
                            $inn[8] * 4 + $inn[9] * 6 + $inn[10]* 8) % 11 ) % 10;

                if ($code11 == $inn[10] && $code12 == $inn[11]) return true;
            }
        }

        return false;
    }
}
