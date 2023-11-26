<?php

namespace Smalot\Cups\Model;

use GuzzleHttp\Psr7\MimeType;

/**
 * Class Job
 *
 * @package Smalot\Cups\Model
 */
class Job implements JobInterface
{
    use Traits\AttributeAware;
    use Traits\UriAware;

    const CONTENT_FILE = 'file';

    const CONTENT_TEXT = 'text';

    const SIDES_TWO_SIDED_LONG_EDGE = 'two-sided-long-edge';

    const SIDES_TWO_SIDED_SHORT_EDGE = 'two-sided-short-edge';

    const SIDES_ONE_SIDED = 'one-sided';

    /**
     * @var null|int
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $printer_uri;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $page_ranges = 'all';

    /**
     * @var int
     */
    protected $copies;

    /**
     * @var string
     */
    protected $sides = self::SIDES_ONE_SIDED;

    /**
     * @var int
     */
    protected $fidelity = 0;

    /**
     * @var array
     */
    protected $content = [];

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $state_reason;

    /**
     * Job constructor.
     */
    public function __construct()
    {
        $this->copies = 1;
        $this->sides = self::SIDES_ONE_SIDED;
    }

    /**
     * @return null|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Job
     */
    public function setId(int $id): JobInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrinterUri(): string
    {
        return $this->printer_uri;
    }

    /**
     * @param string $printer_uri
     *
     * @return Job
     */
    public function setPrinterUri(string $printer_uri): JobInterface
    {
        $this->printer_uri = $printer_uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Job
     */
    public function setName(string $name): JobInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return Job
     */
    public function setUsername(string $username): JobInterface
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageRanges(): string
    {
        return $this->page_ranges;
    }

    /**
     * @param string $page_ranges
     *
     * @return Job
     */
    public function setPageRanges(string $page_ranges = 'all'): JobInterface
    {
        $this->page_ranges = $page_ranges;

        return $this;
    }

    /**
     * @return int
     */
    public function getCopies(): int
    {
        return $this->copies;
    }

    /**
     * @param int $copies
     *
     * @return Job
     */
    public function setCopies(int $copies): JobInterface
    {
        $this->copies = $copies;

        return $this;
    }

    /**
     * @return string
     */
    public function getSides(): string
    {
        return $this->sides ?: self::SIDES_ONE_SIDED;
    }

    /**
     * @param string $sides
     *
     * @return Job
     */
    public function setSides(string $sides): JobInterface
    {
        $this->sides = $sides;

        return $this;
    }

    /**
     * @return int
     */
    public function getFidelity(): int
    {
        return $this->fidelity;
    }

    /**
     * @param int $fidelity
     *
     * @return Job
     */
    public function setFidelity(int $fidelity): JobInterface
    {
        $this->fidelity = $fidelity;

        return $this;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Send a file directly to the printer.
     *
     * @param string      $filename
     * @param string      $name
     * @param null|string $mime_type
     *
     * @return Job
     */
    public function addFile(string $filename, string $name = '', string $mime_type = 'application/octet-stream'): JobInterface
    {
        if (empty($name)) {
            $name = basename($filename);
        }

        if ($mime_type === '') {
            $mime_type = MimeType::fromFilename($filename);
        }

        $this->content[] = [
            'type' => self::CONTENT_FILE,
            'name' => $name,
            'mimeType' => $mime_type,
            'binary' => file_get_contents($filename),
        ];

        return $this;
    }

    /**
     * Send text directly to the printer.
     *
     * @param string $text
     * @param string $name
     * @param string $mime_type
     *
     * @return Job
     */
    public function addText(string $text, string $name = '', string $mime_type = 'text/plain'): JobInterface
    {
        $this->content[] = [
            'type' => self::CONTENT_TEXT,
            'name' => $name,
            'mimeType' => $mime_type,
            'text' => $text,
        ];

        return $this;
    }

    /**
     * Send raw file contents to printer.
     *
     * @param string $text
     * @param string $name
     *
     * @return Job
     */
    public function addRaw(string $text, string $name = ''): JobInterface
    {
        $this->content[] = [
            'type' => self::CONTENT_TEXT,
            'name' => $name,
            'mimeType' => 'application/vnd.cups-raw',
            'text' => $text,
        ];

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Job
     */
    public function setState(string $state): JobInterface
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getStateReason(): string
    {
        return $this->state_reason;
    }

    /**
     * @param string $state_reason
     *
     * @return Job
     */
    public function setStateReason(string $state_reason): JobInterface
    {
        $this->state_reason = $state_reason;

        return $this;
    }
}
