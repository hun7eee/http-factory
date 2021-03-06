<?php

declare(strict_types=1);

namespace Tebe\HttpFactory\Factory;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

class NyholmFactory implements FactoryInterface
{

    /** @var Psr17Factory */
    private $factory;

    /**
     * NyholmFactory constructor.
     */
    public function __construct()
    {
        $this->factory = new Psr17Factory();
    }

    /**
     * Check whether Nyholm PSR-7 is available
     */
    public static function isInstalled(): bool
    {
        return class_exists('Nyholm\\Psr7\\Factory\\Psr17Factory')
            && class_exists('Nyholm\\Psr7Server\\ServerRequestCreator');
    }

    /**
     * @inheritdoc
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->factory->createResponse($code, $reasonPhrase);
    }

    /**
     * @inheritdoc
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return $this->factory->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * @inheritdoc
     */
    public function createServerRequestFromGlobals(): ServerRequestInterface
    {
        $psr17Factory = new Psr17Factory();

        $creator = new ServerRequestCreator(
            $psr17Factory, // ServerRequestFactory
            $psr17Factory, // UriFactory
            $psr17Factory, // UploadedFileFactory
            $psr17Factory  // StreamFactory
        );

        return $creator->fromGlobals();
    }

    /**
     * @inheritdoc
     */
    public function createStream(string $content = ''): StreamInterface
    {
        return $this->factory->createStream($content);
    }

    /**
     * @inheritdoc
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return $this->factory->createStreamFromFile($filename, $mode);
    }

    /**
     * @inheritdoc
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return $this->factory->createStreamFromResource($resource);
    }

    /**
     * @inheritdoc
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return $this->factory->createUri($uri);
    }

    /**
     * @inheritdoc
     */
    public function createUploadedFile(
        StreamInterface $stream,
        int $size = null,
        int $error = \UPLOAD_ERR_OK,
        string $clientFilename = null,
        string $clientMediaType = null
    ): UploadedFileInterface {
        return $this->factory->createUploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
    }
}
