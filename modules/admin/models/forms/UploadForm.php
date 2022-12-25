<?php

namespace app\modules\admin\models\forms;

use app\common\SpreadsheetHandler;
use app\jobs\LoaderJob;
use app\modules\admin\models\File;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    public $format;
    public $year;
    public $sheedFiles;
    public $target;
    public $folder;

    public function rules(): array
    {
        return [
            [['sheedFiles', 'year', 'format'], 'required'],
            [['sheedFiles'], 'file',
                'extensions' => 'xlsx',
                'skipOnEmpty' => false,
                'maxFiles' => 10,
                'maxSize' => 10 * 1024 * 1024,
            ],
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
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            $this->target = 'web/uploads/u_' . Yii::$app->user->id;
            $this->folder = Yii::getAlias('@app') . '/' . $this->target;

            if (FileHelper::createDirectory($this->folder)) {
                foreach ($this->sheedFiles as $file) {
                    $uniq_name = Yii::$app->security->generateRandomString(9);

                    $file->saveAs($this->folder . '/' . $uniq_name . '.' . $file->extension);

                    $model = new File();
                    $model->name = $file->name;
                    $model->uniq_name = $uniq_name;
                    $model->target = $this->target;
                    $model->ext = $file->extension;
                    $model->save();

                    try {
                        $sheet = SpreadsheetHandler::import($model);

                        foreach ($sheet as $item) {
                            $item = array_filter($item);

                            if (!empty($item)) {
                                Yii::$app->loader->push(new LoaderJob([
                                    'data' => $item,
                                    'uid' => Yii::$app->user->id,
                                    'year' => $this->year,
                                    'format' => $this->format,
                                ]));
                            }
                        }
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
