<?php

namespace XenBox\Models;

use XenForo_Application;
use XenForo_Authentication_Abstract;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use XenBox\Database\Db;

class User extends Model
{
    protected $table = 'xf_user';

    /**
     * Authenticates the user's password.
     *
     * @param string $password
     * @return bool
     */
    public function authenticate(string $password): bool
    {
        $result = Capsule::connection('xenbox')
            ->table('xf_user_authenticate')
            ->select('data')
            ->where('user_id', '=', $this->user_id)
            ->first();

        if ($result === null) {
            return false;
        }

        $provider = XenForo_Authentication_Abstract::createDefault();
        $provider->setData($result->data);

        return $provider->authenticate($this->user_id, $password);
    }

    /**
     * Gets the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        if ($this->avatar_date === 0) {
            return null;
        }

        $boardUrl = XenForo_Application::getOptions()->boardUrl;

        return $boardUrl
            . '/data/avatars/l/'
            . floor($this->user_id / 1000)
            . '/'
            . $this->user_id
            . 'jpg';
    }

    /**
     * Gets the user's gender.
     *
     * @return null|string
     */
    public function getGender(): ?string
    {
        if (empty($this->gender)) {
            return null;
        }

        return $this->gender;
    }

    /**
     * Gets the user's secondary groups as an array.
     *
     * @return array
     */
    public function getSecondaryGroups(): array
    {
        return explode(',', $this->secondary_group_ids);
    }
}
