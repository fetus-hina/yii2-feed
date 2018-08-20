<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use Yii;
use Zend\Feed\Writer\Entry as FeedEntry;
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
    public $entry = [];

    protected $instance;

    public function __construct()
    {
        parent::__construct();
        $this->instance = new FeedWriter();
    }

    public function run()
    {
        $profile = new Profiler("render an widget", __METHOD__);

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

        $this->processEntries();
        return $this->renderFeed();

        return $this->instance->export(
            $this->type === static::TYPE_ATOM
                ? static::TYPE_ATOM
                : static::TYPE_RSS
        );
    }

    protected function processEntries(): void
    {
        $profile = new Profiler("create feed entries", __METHOD__);

        foreach ($this->dataProvider->getModels() as $model) {
            $entry = $this->processEntry(
                $this->instance->createEntry(),
                $model
            );
            if ($entry) {
                $this->instance->addEntry($entry);
            }
        }
    }

    protected function processEntry(FeedEntry $feedEntry, $model): ?FeedEntry
    {
        foreach ($this->entry as $key => $valueOrCallback) {
            $value = is_callable($valueOrCallback)
                ? call_user_func($valueOrCallback, $model, $key, $feedEntry, $this)
                : $value;

            call_user_func([$feedEntry, 'set' . $key], $value);
        }

        return $feedEntry;
    }

    protected function renderFeed(): string
    {
        $profile = new Profiler("render {$this->type} feed", __METHOD__);

        return $this->instance->export(
            $this->type === static::TYPE_ATOM
                ? static::TYPE_ATOM
                : static::TYPE_RSS
        );
    }
}
