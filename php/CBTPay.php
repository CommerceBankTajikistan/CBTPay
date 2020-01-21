<?php
/**
 * CBTPay
 * Класс для взаимодействия партнера с интернет-эквайрингом
 * @link https://github.com/CommerceBankTajikistan
 * @copyright ОАО «Коммерцбанк Таджикистана»
 * @version 2.4
 * @since 2020/01/20
 */
class CBTPay
{
    private $aqId = 0;
    private $id = "";
    private $idPrefix = "";
    private $amount = 0.0;
    private $currency = "TJS";
    private $orderDescription = "";
    private $returnUrl = "";
    private $failUrl = "";
    private $callbackUrl = "";
    private $login = "";
    private $password = "";
    private $privateSecurityKey = "";
    private $token = "";

    /**
     * @param int $aqId
     */
    public function setAqId($aqId)
    {
        $this->aqId = $aqId;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        if (sizeof($this->idPrefix) === 0) {
            echo "Set id prefix first";
            exit;
        }
        if (strlen($this->idPrefix . $id) > 21) {
            echo "Length of ID is too long";
            exit;
        }
        $this->id = $id;
    }

    /**
     * @param string $idPrefix
     */
    public function setIdPrefix($idPrefix)
    {
        $this->idPrefix = $idPrefix;
    }

    /**
     * @param double $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param string $orderDescription
     */
    public function setOrderDescription($orderDescription)
    {
        $this->orderDescription = $orderDescription;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @param string $failUrl
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $privateSecurityKey
     */
    public function setPrivateSecurityKey($privateSecurityKey)
    {
        $this->privateSecurityKey = $privateSecurityKey;
    }

    /**
     * @param bool $return Возвращать токен или нет
     * @param bool $regenerate Сгенерировать заново
     * @return null|string Токен
     */
    public function getToken($return = true, $regenerate = false) {
        if ($regenerate && (sizeof($this->token) > 0)) return $this->token;
        $this->setToken(
            $this->id .
            $this->orderDescription .
            $this->amount .
            $this->login .
            $this->currency .
            $this->password .
            $this->privateSecurityKey
        );
        return ($return) ? $this->token : null;
    }

    /**
     * @param $data string Token data
     */
    private function setToken($data) {
        $this->token = hash_hmac("sha1", $data, $this->privateSecurityKey, $raw_output = false);
    }

    /**
     * @return int
     */
    public function getAqId()
    {
        return $this->aqId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdPrefix()
    {
        return $this->idPrefix;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getOrderDescription()
    {
        return $this->orderDescription;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPrivateSecurityKey()
    {
        return $this->privateSecurityKey;
    }
}
