<?php

/**
 * CWP Media tool
 */

namespace MLSC\Traits;

use Symfony\Component\Process\Process;

trait Callables
{
    public function ProcessOutput($type, $buffer)
    {
        if (Process::ERR === $type)
        {
            echo 'ERR > '.$buffer;
        } else
        {
            echo 'OUT > '.$buffer;
        }
    }

    public function getIpfromNeighbor($type, $buffer)
    {
        $regex   = '/(\d+.\d+.\d+.\d+).*('.$this->macid.').*/';
        $matched = preg_match($regex, $buffer, $output_array);
        if ($matched == true)
        {
            $this->ip = $output_array[1];
        }
    }
}
