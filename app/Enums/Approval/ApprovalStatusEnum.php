<?php


namespace App\Enums\Approval;
/**
 * Approval Enum class
 *
 * @author Md.Shohag <Shohag.fks@gmail.com>
 */

use App\Enums\Base\BaseEnum;

class ApprovalStatusEnum extends BaseEnum
{
    private const Pending = 0;
    private const Accepted = 1;
    private const Rejected = 2;
}
