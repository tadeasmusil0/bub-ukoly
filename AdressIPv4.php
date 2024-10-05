<?php

class AddressIPv4
{
    private $address;
    private $isValid;

    public function __construct($address)
    {
        $this->set($address);
    }

    public function isValid()
    {
        return filter_var($this->address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public function set($address)
    {
        $this->address = $address;
        $this->isValid = $this->isValid();
    }

    public function getAsString()
    {
        return $this->address;
    }

    public function getAsInt()
    {
        if ($this->isValid) {
            $octets = explode('.', $this->address);
            return ($octets[0] << 24) + ($octets[1] << 16) + ($octets[2] << 8) + $octets[3];
        }
        throw new Exception("Invalid IP address");
    }

    public function getAsBinaryString()
    {
        if ($this->isValid) {
            $octets = explode('.', $this->address);
            $binaryOctets = array(); // Použití starší syntaxy pro pole
            foreach ($octets as $octet) {
                $binaryOctets[] = str_pad(decbin((int)$octet), 8, '0', STR_PAD_LEFT);
            }
            return implode('.', $binaryOctets); // Spojte oktety s tečkami
        }
        throw new Exception("Invalid IP address");
    }

    public function getOctet($number)
    {
        if ($this->isValid) {
            $octets = explode('.', $this->address);
            if ($number < 1 || $number > 4) {
                throw new Exception("Octet number must be between 1 and 4");
            }
            return (int)$octets[$number - 1];
        }
        throw new Exception("Invalid IP address");
    }

    public function getClass()
    {
        if ($this->isValid) {
            $firstOctet = $this->getOctet(1);
            if ($firstOctet >= 1 && $firstOctet <= 126) {
                return 'A';
            } elseif ($firstOctet >= 128 && $firstOctet <= 191) {
                return 'B';
            } elseif ($firstOctet >= 192 && $firstOctet <= 223) {
                return 'C';
            } elseif ($firstOctet >= 224 && $firstOctet <= 239) {
                return 'D';
            } elseif ($firstOctet >= 240 && $firstOctet <= 255) {
                return 'E';
            }
        }
        throw new Exception("Invalid IP address");
    }

    public function isPrivate()
    {
        if ($this->isValid) {
            return preg_match('/^10\./', $this->address) ||
                   preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $this->address) ||
                   preg_match('/^192\.168\./', $this->address);
        }
        throw new Exception("Invalid IP address");
    }
}

// Příklad použití pro jednu IP adresu
try {
    $ip = new AddressIPv4("20.21.1.255");

    echo "IP adresa: " . $ip->getAsString() . PHP_EOL;
    echo "Platná: " . ($ip->isValid() ? "Ano" : "Ne") . PHP_EOL;
    echo "Reprezentace jako celé číslo: " . $ip->getAsInt() . PHP_EOL;
    echo "Binární reprezentace: " . $ip->getAsBinaryString() . PHP_EOL;
    echo "První oktet: " . $ip->getOctet(1) . PHP_EOL;
    echo "Třída adresy: " . $ip->getClass() . PHP_EOL;
    echo "Je privátní: " . ($ip->isPrivate() ? "Ano" : "Ne") . PHP_EOL;

} catch (Exception $e) {
    echo "Chyba: " . $e->getMessage();
}

?>
