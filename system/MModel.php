<?php

namespace system;

/**
 * System Model
 *
 */
class MModel 
{
    protected $db;
    
    public function __construct(Lazy $lazy) 
    {
        $this->db = $lazy->getDbInstance();
    }
}
