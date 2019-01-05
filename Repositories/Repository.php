<?php
/**
 * Repository.php
 * Created by @anonymoussc on 10/22/2017 1:30 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Signature\Repositories\SignatureRepository as BaseRepository;
use App\Components\Signal\Shared\Signal;
use App\Components\Signal\Shared\ErrorLog;

/**
 * Class Repository
 * @package App\Components\Passerby\Repositories
 */
abstract class Repository extends BaseRepository
{
    use Signal, ErrorLog;
}