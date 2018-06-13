<?php

namespace XenBox\Database;

use XenForo_Application;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\MySqlConnection;

class Db
{
    /**
     * Eloquent capsule instance.
     *
     * @var Illuminate\Database\Capsule\Manager
     */
    private static $_capsule = null;

    /**
     * Initializes the capsule.
     *
     * @return void
     */
    public static function init(): void
    {
        $config = XenForo_Application::getConfig();

        self::$_capsule = new Capsule();
        self::$_capsule->addConnection([
            'driver' => 'mysql',
            'host' => $config->db->host,
            'database' => $config->db->dbname,
            'username' => $config->db->username,
            'password' => $config->db->password,
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => ''
        ], 'xenbox');

        self::$_capsule->setAsGlobal();
        
        self::$_capsule->bootEloquent();
    }

    /**
     * Gets the eloquent capsule connection.
     *
     * @return Illuminate\Database\MySqlConnection|null
     */
    public static function get(): ?MySqlConnection
    {
        return self::$_capsule->getConnection('xenbox');
    }
}
