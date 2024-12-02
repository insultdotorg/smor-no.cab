<?php

namespace App\View\Components;

use App\Models\Download as DL;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stats extends Component
{
    public int $downloads;
    public string $name;
    public string $stats;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $system,
        public string $filename
    )
    {
        $filepath = sprintf('%s/%s', $system, $filename);

        $downloads = DL::where('file', '=', $filepath)->get();

        $this->downloads = $downloads->count();

        $this->name = pathinfo(pathinfo($filename, PATHINFO_FILENAME), PATHINFO_FILENAME);

        $this->stats = implode(', ', $downloads->pluck('stats')->toArray());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stats');
    }
}
