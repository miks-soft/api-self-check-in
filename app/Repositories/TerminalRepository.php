<?php

namespace App\Repositories;

use App\DTO\Terminal\TerminalBaseDto;
use App\Models\Terminal;
use App\Repositories\Interfaces\TerminalRepositoryInterface;

class TerminalRepository extends BaseEloquentRepository implements TerminalRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Terminal::class, TerminalBaseDto::class);
    }
}
