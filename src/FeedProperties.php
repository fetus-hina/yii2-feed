<?php
declare(strict_types=1);

namespace jp3cki\yii2\feed;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use yii\helpers\ArrayHelper;

trait FeedProperties
{
    use TimestampBehavior;

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

    public function getLastBuildDate(): ?DateTimeImmutable
    {
        return static::normalizeDateTimeForGet($this->instance->getLastBuildDate());
    }

    public function setLastBuildDate(?DateTimeInterface $at = null): self
    {
        $this->instance->setLastBuildDate(static::normalizeDateTimeForSet($at));
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

    public function getGenerator(): ?array
    {
        return $this->instance->getGenerator();
    }

    public function setGenerator(array $data): self
    {
        $this->instance->setGenerator(
            $data['name'],
            $data['version'] ?? null,
            $data['uri'] ?? null
        );
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->instance->getId();
    }

    public function setUuid(string $id): self
    {
        $this->instance->setId($id);
        return $this;
    }

    public function getImage(): ?array
    {
        return $this->instance->getImage();
    }

    public function setImage(array $data): self
    {
        $this->instance->setImage($data);
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->instance->getLink();
    }

    public function setLink(string $link): self
    {
        $this->instance->setLink($link);
        return $this;
    }

    public function getFeedLinks(): array
    {
        return $this->instance->getFeedLinks() ?? [];
    }

    public function getRssLink(): ?string
    {
        return ArrayHelper::getValue($this->getFeedLinks(), 'rss', null);
    }

    public function setRssLink(string $url): self
    {
        $this->instance->setFeedLink($url, 'rss');
        return $this;
    }

    public function getRdfLink(): ?string
    {
        return ArrayHelper::getValue($this->getFeedLinks(), 'rdf', null);
    }

    public function setRdfLink(string $url): self
    {
        $this->instance->setFeedLink($url, 'rdf');
        return $this;
    }

    public function getAtomLink(): ?string
    {
        return ArrayHelper::getValue($this->getFeedLinks(), 'atom', null);
    }

    public function setAtomLink(string $url): self
    {
        $this->instance->setFeedLink($url, 'atom');
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

    public function getEncoding(): ?string
    {
        return $this->instance->getEncoding();
    }

    public function setEncoding(string $encoding): self
    {
        $this->instance->setEncoding($encoding);
        return $this;
    }

    public function getBaseUrl(): ?string
    {
        return $this->instance->getBaseUrl();
    }

    public function setBaseUrl(string $url): self
    {
        $this->instance->setBaseUrl($url);
        return $this;
    }

    public function getHubs(): array
    {
        return $this->instance->getHubs() ?? [];
    }

    public function setHubs(array $hubs): self
    {
        $this->instance->remove('hubs');
        return $this->addHubs($data);
    }

    public function addHub(string $url): self
    {
        return $this->addHubs([$url]);
    }

    public function addHubs(array $hubs): self
    {
        $this->instance->addHubs($hubs);
        return $this;
    }

    public function getHub(): ?string
    {
        if ($hubs = $this->getHubs()) {
            return array_shift($hubs);
        }

        return null;
    }

    public function setHub(string $url): self
    {
        return $this->setHubs([$url]);
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
}
