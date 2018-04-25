<?php

namespace App\Serializer;

use App\Entity\Decision;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DecisionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private $ready = true;

    public function normalize($object, $format = null, array $context = []): array
    {
        $this->ready = false;
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['generalAssembly'] = $data['generalAssembly']['@id'];
        $this->ready = true;

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Decision && $this->ready;
    }
}
