<?php


namespace App\Enums\Approval;
/**
 * Approval Enum class
 *
 * @author Md.Shohag <Shohag.fks@gmail.com>
 */

use App\Enums\Base\BaseEnum;

class StatusEnum extends BaseEnum
{
    private const Pending = 'Pending';
    private const Accepted = 'Accepted';
    private const Rejected = 'Rejected';
}
