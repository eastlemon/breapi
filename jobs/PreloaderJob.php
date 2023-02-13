<?php

namespace app\jobs;

use app\common\SpreadsheetHandler;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\db\Query;
use yii\queue\JobInterface;

class PreloaderJob extends BaseObject implements JobInterface
{
    public int $uid;
    public string $inputFileName;
    public string $tag;
    public int $year;
    public array $keys;
    public bool $composite;

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function execute($queue): void
    {
        try {
            $sheet = SpreadsheetHandler::import($this->inputFileName);

            foreach ($sheet as $item) {
                $loader = static::getLeastBusyQueue();

                Yii::$app->{$loader}->push(new LoaderJob([
                    'data' => $item,
                    'uid' => $this->uid,
                    'tag' => $this->tag,
                    'year' => $this->year,
                    'keys' => $this->keys,
                    'composite' => $this->composite,
                ]));
            }

            unlink($this->inputFileName);
        } catch (Exception $e) {
            Yii::info($e->getMessage(), 'jobs');
        }
    }

    public static function getLeastBusyQueue(): string
    {
        $selected = 'loader1';
        $_count = 0;

        foreach (range(1, 2) as $channel) {
            $count = (new Query())
                ->from('queue')
                ->where(['channel' => "channel{$channel}"])
                ->count();

            if ($count < $_count) {
                $selected = "loader{$channel}";
            }

            $_count = $count;
        }

        return $selected;
    }
}
