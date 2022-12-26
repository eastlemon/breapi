<?php

namespace app\modules\admin\models\forms;

use app\common\SpreadsheetHandler;
use app\jobs\LoaderJob;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    public $format;
    public $tag;
    public $year;
    public $sheedFiles;
    public $target;
    public $folder;

    public function rules(): array
    {
        return [
            [['sheedFiles', 'tag', 'year', 'format'], 'required'],
            [['sheedFiles'], 'file',
                'extensions' => 'xlsx',
                'skipOnEmpty' => false,
                'maxFiles' => 10,
                'maxSize' => 10 * 1024 * 1024,
            ],
            [['tag'], 'integer'],
            [['year'], 'integer'],
            [['format'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'sheedFiles' => Yii::t('app', 'Select Files'),
            'year' => Yii::t('app', 'Year'),
        ];
    }

    /**
     * @throws Exception|\PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \Throwable
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            $this->target = 'web/uploads';
            $this->folder = Yii::getAlias('@app') . '/' . $this->target;

            if (FileHelper::createDirectory($this->folder)) {
                foreach ($this->sheedFiles as $file) {
                    $uniq_name = Yii::$app->security->generateRandomString(9);

                    $inputFileName = $this->folder . '/' . $uniq_name . '.' . $file->extension;

                    $file->saveAs($inputFileName);

                    try {
                        $sheet = SpreadsheetHandler::import($inputFileName);

                        foreach ($sheet as $item) {
                            $item = array_filter($item);

                            if (!empty($item)) {
                                $loader = static::getLeastBusyQueue();

                                Yii::$app->{$loader}->push(new LoaderJob([
                                    'data' => $item,
                                    'uid' => Yii::$app->user->id,
                                    'tag' => $this->tag,
                                    'year' => $this->year,
                                    'format' => $this->format,
                                ]));
                            }
                        }
                    } catch (Exception $e) {
                        Yii::info($e->getMessage(), 'jobs');
                    }

                    unlink($inputFileName);
                }

                return true;
            }
        }

        return false;
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
