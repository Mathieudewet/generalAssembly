<?php

namespace App\Serializer;

use App\Entity\Remark;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RemarkNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private $ready = true;

    public function normalize($object, $format = null, array $context = []): array
    {
        $this->ready = false;
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['pointOfView'] = [$object::neutral_point_of_view, $object::for_point_of_view, $object::against_point_of_view];
        $this->ready = true;

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Remark && $this->ready;
    }
}
