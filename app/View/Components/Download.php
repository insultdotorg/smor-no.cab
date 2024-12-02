<?php

namespace App\View\Components;

use App\Models\Download as DL;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Download extends Component
{
    public int $downloads;
    public string $name;
    public string $size;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $system,
        public string $filename
    ) {
        $filepath = sprintf('%s/%s', $system, $filename);

        $this->downloads = DL::where('file', '=', $filepath)->count();

        $this->name = pathinfo(pathinfo($filename, PATHINFO_FILENAME), PATHINFO_FILENAME);

        $filesize = Storage::size($filepath);
        $units = ['b', 'Kb', 'Mb', 'Gb', 'Tb'];
        $bytes = max($filesize, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        $this->size = sprintf(
            '%s%s',
            round($bytes, 2),
            $units[$pow]
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string
    {
        return view('components.download');
    }
}
