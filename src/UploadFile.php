<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\UploadFile as ContractUploadFile;
use think\file\UploadedFile;

class UploadFile implements ContractUploadFile
{
    /**
     * 上传文件
     *
     * @var UploadedFile
     */
    private $upload_file;

    /**
     * 创建上传文件实例
     *
     * @author nece001@163.com
     * @create 2026-06-04 16:54:01
     *
     * @param File $file
     * @return static
     */
    public static function instance($file): static
    {
        return new static($file);
    }

    /**
     * @inheritDoc
     */
    public static function instances(array $files): array
    {
        $instances = [];
        foreach ($files as $field => $file) {
            $instances[$field] = new static($file);
        }
        return $instances;
    }

    public function __construct(UploadedFile $file)
    {
        $this->upload_file = $file;
    }

    /**
     * @inheritDoc
     */
    public function getUploadName(): ?string
    {
        return $this->upload_file->getOriginalName();
    }

    /**
     * @inheritDoc
     */
    public function getUploadMimeType(): ?string
    {
        return $this->upload_file->getOriginalMime();
    }

    /**
     * @inheritDoc
     */
    public function getUploadExtension(): string
    {
        return $this->upload_file->getOriginalExtension();
    }

    /**
     * @inheritDoc
     */
    public function getUploadErrorCode(): ?int
    {
        // UploadedFile 类没有直接暴露 error 属性，这里返回 null
        return null;
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->upload_file->isValid();
    }

    /**
     * @inheritDoc
     */
    public function move(string $destination): \think\File
    {
        $info = pathinfo($destination);
        $path = $info['dirname'];
        $filename = $info['basename'];

        return $this->upload_file->move($path, $filename);
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->upload_file->getPath();
    }

    /**
     * @inheritDoc
     */
    public function getFilename(): string
    {
        return $this->upload_file->getFilename();
    }

    /**
     * @inheritDoc
     */
    public function getPathname(): string
    {
        return $this->upload_file->getPathname();
    }

    /**
     * @inheritDoc
     */
    public function getExtension(): string
    {
        return $this->upload_file->getExtension();
    }

    /**
     * @inheritDoc
     */
    public function getBasename(?string $suffix = null): string
    {
        return $this->upload_file->getBasename($suffix);
    }

    /**
     * @inheritDoc
     */
    public function isFile(): bool
    {
        return $this->upload_file->isFile();
    }

    /**
     * @inheritDoc
     */
    public function isDir(): bool
    {
        return $this->upload_file->isDir();
    }

    /**
     * @inheritDoc
     */
    public function isLink(): bool
    {
        return $this->upload_file->isLink();
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int|false
    {
        return $this->upload_file->getSize();
    }

    /**
     * @inheritDoc
     */
    public function getOwner(): int|false
    {
        return $this->upload_file->getOwner();
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): int|false
    {
        return $this->upload_file->getGroup();
    }

    /**
     * @inheritDoc
     */
    public function getATime(): int|false
    {
        return $this->upload_file->getATime();
    }

    /**
     * @inheritDoc
     */
    public function getMTime(): int|false
    {
        return $this->upload_file->getMTime();
    }

    /**
     * @inheritDoc
     */
    public function getCTime(): int|false
    {
        return $this->upload_file->getCTime();
    }

    /**
     * @inheritDoc
     */
    public function getPerms(): int|false
    {
        return $this->upload_file->getPerms();
    }

    /**
     * @inheritDoc
     */
    public function isReadable(): bool
    {
        return $this->upload_file->isReadable();
    }

    /**
     * @inheritDoc
     */
    public function isWritable(): bool
    {
        return $this->upload_file->isWritable();
    }

    /**
     * @inheritDoc
     */
    public function isExecutable(): bool
    {
        return $this->upload_file->isExecutable();
    }

    /**
     * @inheritDoc
     */
    public function getRealPath(): string|false
    {
        return $this->upload_file->getRealPath();
    }

    /**
     * @inheritDoc
     */
    public function getRealUploadFile(): UploadedFile
    {
        return $this->upload_file;
    }
}
