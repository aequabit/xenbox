<?php

namespace XenBox;

use XenForo_Application;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\ServiceProvider;

class SeviceProvider extends ServiceProvider
{
    /**
     * Initialize the XenBox database.
     *
     * @return void
     */
    public function register()
    {
        $config = XenForo_Application::getConfig();

        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $config->db->host,
            'database' => $config->db->dbname,
            'username' => $config->db->username,
            'password' => $config->db->password,
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => ''
        ], 'xenbox');

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
