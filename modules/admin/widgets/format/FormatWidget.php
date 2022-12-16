<?php

namespace app\modules\admin\widgets\format;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\di\NotInstantiableException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class FormatWidget extends Widget
{
    /**
     * @var Model|null The data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string|null The model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var string|null The input value.
     */
    public $value;

    public $visualOptions = [];

    public $hiddenOptions = [];

    public function translate($model, $attribute): string
    {
        $to_return = '';
        $_a = [];

        if ($format = $model[$attribute]) {
            $_f = StringHelper::explode($format);

            foreach ($_f as $_i) $_a[] = Yii::t('fragments', $_i);

            $to_return = implode(', ', $_a);
        }

        return $to_return;
    }

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->hasModel()) {
            throw new InvalidConfigException("Model must be set!");
        }

        if (!isset($this->visualOptions['id'])) {
            $this->visualOptions['id'] = Html::getInputId($this->model, 'v_' . $this->attribute);
        }

        $this->visualOptions['readonly'] = true;

        $this->visualOptions['value'] = $this->translate($this->model, $this->attribute);

        if (!isset($this->hiddenOptions['id'])) {
            $this->hiddenOptions['id'] = Html::getInputId($this->model, 'h_' . $this->attribute);
        }

        $this->hiddenOptions['value'] = $this->model[$this->attribute];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        $this->registerClientScripts();

        $v_options = ArrayHelper::merge($this->visualOptions, ['class' => 'form-control']);

        $h_options = ArrayHelper::merge($this->hiddenOptions, ['class' => 'form-control']);

        $_input =
            Html::activeTextInput($this->model, '_' . $this->attribute, $v_options) .
            Html::activeHiddenInput($this->model, $this->attribute, $h_options);

        return $this->render('_format', [
            'input' => $_input,
            'fragments' => ['FIO', 'INN', 'Phone', 'Surname', 'Name', 'Patronymic'],
        ]);
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel(): bool
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    /**
     * Register widget asset.
     */
    protected function registerClientScripts()
    {
        $view = $this->getView();

        try {
            $asset = Yii::$container->get(FormatWidgetAsset::class);

            $asset::register($view);
        } catch (NotInstantiableException|InvalidConfigException $e) {

        }
    }
}