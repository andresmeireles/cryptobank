<?php

namespace Cryptocli\Repository;

use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
}