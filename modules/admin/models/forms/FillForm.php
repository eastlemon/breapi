<?php

namespace app\modules\admin\models\forms;

use app\common\SpreadsheetHandler;
use app\jobs\FillerJob;
use app\modules\admin\models\File;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

class FillForm extends Model
{
    public $format;
    public $sheedFile;
    public $target;
    public $folder;

    public function rules(): array
    {
        return [
            [['sheedFile', 'format'], 'required'],
            [['sheedFile'], 'file',
                'extensions' => 'xlsx',
                'skipOnEmpty' => false,
                'maxSize' => 10 * 1024 * 1024,
            ],
            [['format'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'sheedFiles' => Yii::t('app', 'Select Files'),
            'format' => Yii::t('app', 'Format'),
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
                $uniq_name = Yii::$app->security->generateRandomString(9);

                $inputFileName = $this->folder . '/' . $uniq_name . '.' . $this->sheedFile->extension;

                $this->sheedFile->saveAs($inputFileName);

                $file = new File();
                $file->id_user = Yii::$app->user->id;
                $file->name = $this->sheedFile->name;
                $file->uniq_name = $uniq_name;
                $file->target = $this->target;
                $file->ext = $this->sheedFile->extension;
                $file->save();

                $keys = [];

                foreach (StringHelper::explode($this->format) as $key => $item) {
                    if ($item == '@') continue;

                    $keys[strtolower($item)] = $key;
                }

                foreach (SpreadsheetHandler::import($inputFileName) as $item) {
//                        Yii::error([
//                            'data' => $item,
//                            'keys' => $keys,
//                            'fid' => $file->id,
//                        ]);
                    Yii::$app->filler->push(new FillerJob([
                        'data' => $item,
                        'keys' => $keys,
                        'fid' => $file->id,
                    ]));
                }

                return true;
            }
        }

        return false;
    }
}
