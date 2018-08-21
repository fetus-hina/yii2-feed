<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use DateTimeImmutable;
use DateTimeInterface;
use Yii;
use Zend\Feed\Writer\Entry as ZendEntry;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class Entry extends Component
{
    use TimestampBehavior;

    protected $instance;

    public function __construct(ZendEntry $instance)
    {
        parent::__construct();
        $this->instance = $instance;
    }

    // should not access yourself. this method only available for jp3cki\yii2\feed\Feed class.
    public function getZendInstance(): ZendEntry
    {
        return $this->instance;
    }

    public function getAuthors(): array
    {
        return $this->instance->getAuthors() ?? [];
    }

    public function setAuthors(array $list): self
    {
        $this->instance->remove('authors');
        return $this->addAuthors($list);
    }

    public function addAuthors(array $list): self
    {
        $this->instance->addAuthors($list);
        return $this;
    }

    public function getAuthor(): ?array
    {
        return $this->instance->getAuthor();
    }

    public function setAuthor(array $data): self
    {
        return $this->setAuthors([$data]);
    }

    public function getCategories(): array
    {
        return $this->instance->getCategories() ?? [];
    }

    public function setCategories(array $data): self
    {
        $this->instance->remove('categories');
        return $this->addCategories($data);
    }

    public function addCategories(array $data): self
    {
        $this->instance->addCategories($data);
        return $this;
    }

    public function addCategory(string $term, ?string $scheme): self
    {
        return $this->addCategories([[
            'term' => $term,
            'scheme' => $scheme,
        ]]);
    }

    public function getCommentCount(): ?int
    {
        return $this->instance->getCommentCount();
    }

    public function setCommentCount(int $count): self
    {
        $this->instance->setCommentCount($count);
        return $this;
    }

    public function getCommentAtomFeedLink(): ?string
    {
        return $this->getCommentFeedLink('atom');
    }

    public function setCommentAtomFeedLink(string $uri): self
    {
        return $this->setCommentFeedLink([
            'type' => 'atom',
            'uri' => $uri,
        ]);
    }

    public function getCommentRdfFeedLink(): ?string
    {
        return $this->getCommentFeedLink('rdf');
    }

    public function setCommentRdfFeedLink(string $uri): self
    {
        return $this->setCommentFeedLink([
            'type' => 'rdf',
            'uri' => $uri,
        ]);
    }

    public function getCommentRssFeedLink(): ?string
    {
        return $this->getCommentFeedLink('rss');
    }

    public function setCommentRssFeedLink(string $uri): self
    {
        return $this->setCommentFeedLink([
            'type' => 'rss',
            'uri' => $uri,
        ]);
    }

    public function getCommentFeedLink(string $type): ?string
    {
        $data = ArrayHelper::getValue($this->getCommentFeedLinks(), $type);
        return $data['uri'] ?? null;
    }

    public function setCommentFeedLink(array $data): self
    {
        $this->instance->setCommentFeedLink($data);
        return $this;
    }

    public function getCommentFeedLinks(): array
    {
        return $this->instance->getCommentFeedLinks() ?? [];
    }

    public function getCommentLink(): ?string
    {
        return $this->instance->getCommentLink();
    }

    public function setCommentLink(string $url): self
    {
        $this->instance->setCommentLink($url);
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->instance->getContent();
    }

    public function setContent(string $html): self
    {
        $this->instance->setContent($html);
        return $this;
    }

    public function getCopyright(): ?string
    {
        return $this->instance->getCopyright();
    }

    public function setCopyright(string $copyright): self
    {
        $this->instance->setCopyright($copyright);
        return $this;
    }

    public function getDateCreated(): ?DateTimeImmutable
    {
        return static::normalizeDateTimeForGet($this->instance->getDateCreated());
    }

    public function setDateCreated(?DateTimeInterface $at = null): self
    {
        $this->instance->setDateCreated(static::normalizeDateTimeForSet($at));
        return $this;
    }

    public function getDateModified(): ?DateTimeImmutable
    {
        return static::normalizeDateTimeForGet($this->instance->getDateModified());
    }

    public function setDateModified(?DateTimeInterface $at = null): self
    {
        $this->instance->setDateModified(static::normalizeDateTimeForSet($at));
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->instance->getDescription();
    }

    public function setDescription(string $text): self
    {
        $this->instance->setDescription($text);
        return $this;
    }

    public function getEncoding(): ?string
    {
        return $this->instance->getEncoding();
    }

    public function setEncoding(string $encoding): self
    {
        $this->instance->setEncoding($encoding);
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->instance->getLink();
    }

    public function setLink(string $url): self
    {
        $this->instance->setLink($url);
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->instance->getTitle();
    }

    public function setTitle(string $title): self
    {
        $this->instance->setTitle($title);
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->instance->getId();
    }

    public function setUuid(string $uuid): self
    {
        $this->instance->setId($uuid);
        return $this;
    }

    public function getId(): ?string
    {
        return $this->getUuid();
    }

    public function setId(string $uuid): self
    {
        return $this->setUuid($uuid);
    }
}
