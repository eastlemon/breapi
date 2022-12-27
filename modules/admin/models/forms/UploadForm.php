<?php

namespace app\modules\admin\models\forms;

use app\jobs\PreloaderJob;
use Yii;
use yii\base\Exception;
use yii\base\Model;
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

                    Yii::$app->preloader->push(new PreloaderJob([
                        'inputFileName' => $inputFileName,
                        'tag' => $this->tag,
                        'year' => $this->year,
                        'format' => $this->format,
                    ]));
                }

                return true;
            }
        }

        return false;
    }
}
