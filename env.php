<?php

use Dotenv\Dotenv as BaseDotenv;

class Dotenv
{
    /**
     * BaseDotenvクラスを格納
     *
     * @var BaseDotenv
     */
    protected $dotenv;

    /**
     * envのパスを保存
     *
     * @var string
     */
    protected $env_path = null;

    /**
     * envの必須項目を格納
     *
     * @var array
     */
    protected $env_required = [
        'MYSQL_HOST',
        'MYSQL_DATABASE',
        'MYSQL_USER',
        'MYSQL_PASSWORD'
    ];

    public function __construct($env_required = null, $env_path = null)
    {
        $this->setEnvDir($env_path);
        $this->initialize();
        $this->setEnvRequired($env_required);
        $this->dotenv->load();
        $this->envRequired();
    }

    /**
     * クラスをロードするメソッド
     *
     * @return void
     */
    protected function initialize(): void
    {
        $this->dotenv = BaseDotenv::createMutable($this->getEnvDir());
    }

    /**
     * envのパスを返す関数
     *
     * @return string
     */
    public function getEnvDir(): string
    {
        return __DIR__;
    }

    /**
     * envのパスをセットするメソッド
     *
     * @param string $env_path
     * @return string
     */
    public function setEnvDir(?string $env_path): void
    {
        if (!is_null($env_path)) {
            $this->env_path = $env_path;
        }
    }

    /**
     * envの必須項目をセットする
     *
     * @param string|array|null $env_required
     * @return void
     */
    public function setEnvRequired($env_required): void
    {
        if (!is_null($env_required)) {
            if (is_array($env_required)) {
                $this->env_required = array_merge($this->env_required, $env_required);
            }

            if (is_string($env_required)) {
                $this->env_required[] = $env_required;
            }
        }
    }

    /**
     * envの必須項目が存在するかチェックする
     *
     * @return void
     */
    public function envRequired(): void
    {
        $this->dotenv->required($this->env_required);
    }

    /**
     * 環境変数を取得するメソッド
     *
     * @param string $varname
     * @return string|array|bool
     */
    public function getenv(string $varname)
    {
        $value = $_ENV[$varname];

        if (is_array($value) || is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {

            if (strcasecmp($value, 'true') === 0) {
                return true;
            }

            if (strcasecmp($value, 'false') === 0) {
                return false;
            }
        }

        return $value;
    }

    /**
     * 環境変数を取得するメソッド
     *
     * @param string $varname
     * @return string|array|bool
     */
    public function env(string $varname)
    {
        return $this->getenv($varname);
    }
}
