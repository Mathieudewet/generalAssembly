<?php

namespace App\Serializer;

use App\Entity\GeneralAssembly;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class GeneralAssemblyNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private $ready = true;

    public function normalize($object, $format = null, array $context = []): array
    {
        $this->ready = false;
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['name'] = 'Assemblée générale du '.$data['date'];
        $this->ready = true;

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof GeneralAssembly && $this->ready;
    }
}
