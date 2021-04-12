<?php

declare(strict_types = 1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ProductOnSaleStatusEnum extends AbstractConstants
{
    /**
     * @Message("未上架")
     */
    public const NOT_ON_SALE = 0;

    /**
     * @Message("已上架")
     */
    public const IS_ON_SALE = 1;
}
