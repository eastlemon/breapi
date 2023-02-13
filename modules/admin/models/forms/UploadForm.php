<?php

namespace app\modules\admin\models\forms;

use app\jobs\PreloaderJob;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

class UploadForm extends Model
{
    public $sheedFiles;
    public $tag;
    public $year;
    public $format;

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
            $target = 'web/uploads';
            $folder = Yii::getAlias('@app') . '/' . $target;

            if (FileHelper::createDirectory($folder)) {
                $keys = [];

                foreach (StringHelper::explode($this->format) as $key => $item) {
                    if ($item == '@') continue;

                    $keys[strtolower($item)] = $key;
                }

                foreach ($this->sheedFiles as $file) {
                    try {
                        $uniq_name = Yii::$app->security->generateRandomString(9);

                        $inputFileName = $folder . '/' . $uniq_name . '.' . $file->extension;

                        $file->saveAs($inputFileName);

                        Yii::$app->preloader->push(new PreloaderJob([
                            'uid' => Yii::$app->user->id,
                            'inputFileName' => $inputFileName,
                            'tag' => $this->tag,
                            'year' => $this->year,
                            'keys' => $keys,
                            'composite' => isset($keys['surname'], $keys['name'], $keys['patronymic']),
                        ]));
                    } catch (Exception $e) {
                        Yii::info($e->getMessage(), 'jobs');
                    }
                }

                return true;
            }
        }

        return false;
    }
}
