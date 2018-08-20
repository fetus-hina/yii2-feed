<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use Yii;
use Zend\Feed\Writer\Feed as FeedWriter;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\DataProviderInterface;

class Feed extends Widget
{
    use FeedProperties;

    const TYPE_RSS = 'rss';
    const TYPE_ATOM = 'atom';

    public $type = self::TYPE_RSS;
    public $dataProvider; // instanceof \yii\data\DataProviderInterface

    protected $instance;

    public function __construct()
    {
        parent::__construct();
        $this->instance = new FeedWriter();
    }

    public function run()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException(
                'The "dataProvider" property must be set'
            );
        }

        if (!$this->dataProvider instanceof DataProviderInterface) {
            throw new InvalidConfigException(
                'The "dataProvider" property must implement DataProviderInterface'
            );
        }

        //TODO: entries

        return $this->instance->export(
            $this->type === static::TYPE_ATOM
                ? static::TYPE_ATOM
                : static::TYPE_RSS
        );
    }
}
