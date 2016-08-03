<?php

namespace bvanleeuwen\checkColumn;

use Yii;
use yii\base\ErrorException;
use yii\grid\DataColumn;
use yii\helpers\BaseHtml;
use yii\helpers\Url;

class ActiveCheckColumn extends DataColumn
{
    /**
     * The value we expect when the field does not have a value
     * @var mixed
     */
    public $unsetValue = null;

    public $setTemplate = '{check}, {content}';

    public $setCheck = '<i class="fa fa-check-square-o text-success" aria-hidden="true"></i>';

    public $setContent;

    public $setUrl = null;

    public function init()
    {
        // Get the view
        $view = $this->grid->getView();

        // Register the asset bundle
        ActiveCheckColumnAsset::register($view);

        // Set the filter options
        $this->filter = [
            false => 'No value',
            true => 'Has value'
        ];

        // Load custom information for this instance
        parent::init(); // TODO: Change the autogenerated stub

        // Check to make sure that we have a URL set
        if ($this->setUrl === null) {
            throw new ErrorException('URL not set');
        }

        // Translate the URL
        $this->setUrl = Url::to($this->setUrl);
    }

    public function renderDataCellContent($model, $key, $index)
    {
        // Set the attribute in a nice variable that we can use
        $sAttribute = $this->attribute;

        // Does the field have the unset value
        if ($model->$sAttribute == $this->unsetValue) {
            return BaseHtml::checkbox('actionColumChecbox', false, ['data-id' => $model->id, 'class' => 'checkActionColumn', 'data-saveurl' => $this->setUrl]);
        }

        $this->setContent = Yii::$app->formatter->asDatetime($model->$sAttribute, 'medium');

        // Return the set content
        return strtr($this->setTemplate, ['{check}' => $this->setCheck, '{content}' => $this->setContent]);
    }
}