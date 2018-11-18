<?php declare(strict_types=1);

namespace Sventendo\Cryptopals\Set1;

use Sventendo\Cryptopals\Service\ConversionService;

class Challenge1
{

    /**
     * @var ConversionService
     */
    private $conversionService;

    public function __construct(
        ConversionService $conversionService
    ) {
        $this->conversionService = $conversionService;
    }

    public function execute(string $input)
    {
        return $this->conversionService->hexToBase64($input);
    }
}
