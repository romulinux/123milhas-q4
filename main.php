<?php

class Flight {
​
​
    private $flightNumber;
    private $cia;
    private $departureAirport;
    private $arrivalAirport;
    private $departureTime;
    private $arrivalTime;
    private $valorTotal;
    private $luggage;
    private $liveLoad;
​
    public function __construct(
        string $flightNumber,
        string $cia,
        string $departureAirport,
        string $arrivalAirport,
        DateTime $departureTime,
        DateTime $arrivalTime,
        float $valorTotal,
        string $luggage = '',
        string $liveLoad = '',
    )
    {
        $this->flightNumber = $flightNumber;
        $this->cia = $cia;
        $this->departureAirport = $departureAirport;
        $this->arrivalAirport = $arrivalAirport;
        $this->departureTime = $departureTime;
        $this->arrivalTime = $arrivalTime;
        $this->valorTotal = $valorTotal;
        $this->luggage = $luggage;
        $this->liveLoad = $liveLoad;
    }
​
​
    public function getFlightNumber()
    {
        return $this->flightNumber;
    }
​
​
    public function getCia()
    {
        return $this->cia;
    }
​
    public function getDepartureAirport()
    {
        return $this->departureAirport;
    }
​
​
    public function getArrivalAirport()
    {
        return $this->arrivalAirport;
    }
​
​
    public function getDepartureTime()
    {
        return $this->departureTime;
    }
​
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }
​
    public function getValorTotal()
    {
        return $this->valorTotal;
    }
​
    public function getLiveLoad()
    {
        return $this->liveLoad;
    }
​
    public function getLuggage()
    {
        return $this->luggage;
    }
}
​
​
class Checkout
{
    private $flightOutbound;
    private $flightInbound;
​
    public function __construct(Flight $flightOutbound, Flight $flightInbound = null)
    {
        $this->flightOutbound = $flightOutbound;
        $this->flightInbound = $flightInbound;
    }
​
    public function generateExtract()
    {
        $valorTotal = $this->flightOutbound->getValorTotal();
        $flightDetailsOutbound = [
            'De' => $this->flightOutbound->getDepartureAirport(),
            'Para' => $this->flightOutbound->getArrivalAirport(),
            'Embarque' => $this->flightOutbound->getDepartureTime()->format('d/m/Y H:i'),
            'Desembarque' => $this->flightOutbound->getArrivalTime()->format('d/m/Y H:i'),
            'Cia' => $this->flightOutbound->getCia(),
            'Valor' => $this->flightOutbound->getValorTotal(),
        ];

        if ($this->flightOutbound->getLuggage() !== '') {
          $flightDetailsOutbound['Bagagem'] = $this->flightOutbound->getLuggage();
        }

        if ($this->flightOutbound->getLiveLoad() !== '') {
          $flightDetailsOutbound['Carga Viva'] = $this->flightOutbound->getLiveLoad();
        }
​
        $flightDetailsInbound = [];
        if (! is_null($this->flightInbound)) {
            $valorTotal += $this->flightInbound->getValorTotal();
            $flightDetailsInbound = [
                'De' => $this->flightInbound->getDepartureAirport(),
                'Para' => $this->flightInbound->getArrivalAirport(),
                'Embarque' => $this->flightInbound->getDepartureTime()->format('d/m/Y H:i'),
                'Desembarque' => $this->flightInbound->getArrivalTime()->format('d/m/Y H:i'),
                'Cia' => $this->flightInbound->getCia(),
                'Valor' => $this->flightInbound->getValorTotal(),
            ];
        }

        if ($this->flightInbound->getLuggage() !== '') {
          $this->flightInbound['Bagagem'] = $this->flightInbound->getLuggage();
        }

        if ($this->flightInbound->getLiveLoad() !== '') {
          $this->flightInbound['Carga Viva'] = $this->flightInbound->getLiveLoad();
        }
​
        return (object) [
            'flightOutbound' => $flightDetailsOutbound,
            'flightInbound' => $flightDetailsInbound,
            'valorTotal' => $valorTotal
        ];
    }
}
