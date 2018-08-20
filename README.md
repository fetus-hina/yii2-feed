jp3cki/yii2-feed
================

This is zend feed writer wrapper for Yii 2.

License
-------

[MIT License](LICENSE.md).  
Copyright © 2018 AIZAWA Hina


Requirements
------------

- PHP 7.1+


Install
-------

`composer.phar install jp3cki/yii2-feed`


Example
-------

```php
namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

use jp3cki\yii2\feed\Feed;

class FeedController extends Controller
{
    public function actionRss()
    {
        return $this->feedResponse(
            Feed::TYPE_RSS,
            'application/rss+xml'
        );
    }

    public function actionAtom()
    {
        return $this->feedResponse(
            Feed::TYPE_ATOM,
            'application/atom+xml'
        );
    }

    private function feedResponse(string $type, string $contentType)
    {
        Yii::$app->timeZone = 'Etc/UTC'; // recommended

        $resp = Yii::$app->response;
        $resp->format = Response::FORMAT_XML;
        $resp->formatters[Response::FORMAT_XML]['contentType'] = $contentType;
        $resp->data = Feed::widget([
            // feed type.
            'type' => $type, // Feed::TYPE_RSS or Feed::TYPE_ATOM

            // main data.
            'dataProvider' => new ActiveDataProvider([
                'query' => Article::find()->orderBy(['id' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),

            // channel data.
            'title' => Yii::$app->name,
            'description' => 'Bla bra bla...',
            'copyright' => 'Copyright (C) 2018 AIZAWA Hina',
            'link' => Url::home(true),
            'rssLink' => Url::to(['feed/rss'], true),
            'atomLink' => Url::to(['feed/atom'], true),
            'author' => [
                'name' => 'AIZAWA Hina',
                'email' => 'hina@bouhime.com',
                'uri' => 'https://fetus.jp/',
            ],
            'generator' => [
                'name' => Yii::$app->name,
                'version' => Yii::$app->version,
                'uri' => Url::home(true),
            ],
            'dateCreated' => null, // null means "now"
            'dateModified' => null,
            'lastBuildDate' => null,

            // entry formatters. (like GridView::$columns)
            'entry' => [
                // 'attrName' => 'value' or
                // 'attrName' => callback function
                //
                // all callback prototype:
                //   function ($model, $key, $feedEntry, $widget): <value> { }
                'title' => function ($model): string {
                    return $model['title'];
                },
                'link' => function ($model): string {
                    return $model['link'];
                },
                'dateModified' => function ($model) {
                    return $model['dateModified'] ?? null;
                },
                'dateCreated' => function ($model) {
                    return $model['dateCreated'] ?? null;
                },
                'description' => function ($model): string {
                    return $model['description'];
                },
                'content' => function ($model): string {
                    return $model['content'];
                },
            ],
        ]);
        return $resp;
    }
}
```
