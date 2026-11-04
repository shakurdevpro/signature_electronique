<?php

namespace App\View\Components;

use App\Support\StatCardsData;
use Illuminate\View\Component;

class StatCards extends Component
{
    public array $cards;
    public array $routesCards;
    public bool $visible;

    public function __construct(public array $stat, public array $info, public string $prefix = 'chart_')
    {
        $data = StatCardsData::build($stat, $prefix);
        $this->cards = $data['cards'];
        $this->routesCards = $data['routesCards'];
        $this->visible = in_array($info['LOGINUSER'] ?? null, ['X505234', 'Z444473', 'T279354']);
    }

    public function render()
    {
        return view('components.stat-cards');
    }
}
