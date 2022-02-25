<?php namespace Models\Brokers;

class LogBroker extends Broker
{
    public function logFbi($ip, $method, $da = "unknown")
    {
        $sql = "insert into codewars.log(date, ip, method, action, da) values(now(), ?, ?, ?, ?)";
        $this->query($sql, [$ip, $method, "Intrusion détecté, redirection vers fbi", $da]);
    }
}
