<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class ResponseFactory
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * Build response based on accept header
     */
    public function build(object|array $content, int $status, array $headers, string $acceptHeader): Response
    {
        switch ($acceptHeader) {
            case 'application/xml':
                $formattedContent = $this->formatXml($content);
                break;
            default:
                $formattedContent = $this->formatJson($content);
                $acceptHeader = 'application/json';
        }

        $headers['content-type'] = $acceptHeader;

        return new Response($formattedContent, $status, $headers);
    }

    /**
     * Format response content to xml
     */
    private function formatXml(object|array $content): string
    {
        return $this->serializer->serialize($content, 'xml', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s.v\Z',
            'xml_root_node_name' => 'Secret',
            'xml_encoding' => 'UTF-8',
        ]);
    }

    /**
     * Format response content to json
     */
    private function formatJson(object|array $content): string
    {
        return $this->serializer->serialize($content, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s.v\Z',
        ]);
    }
}
