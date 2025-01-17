<?php

namespace MLSC\Modules\Effects;

use MLSC\Core\MLSC;
use MLSC\Modules\HTTP\HTTP;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;

class Effects
{
    public $device_id;

    public function __construct($device_id = 0)
    {
        $this->device_id = $device_id;
    }

    private function getCell($text)
    {
        // return $text;
        return new TableCell($text, [
            'style' => new TableCellStyle([
                'align'      => 'left',
                'cellFormat' => '<info>%s</info>',
            ]),
        ]);
    }

    private function getMusicHeader($text)
    {
        return new TableCell($text, [
            'style'   => new TableCellStyle([
                'align'      => 'center',
                'cellFormat' => '<comment>%s</comment>',
            ]),
            'colspan' => 2,
        ]);
    }

    public function getEffect($name)
    {
        $data = [
            'device'      => $this->device_id,
            'effect'      => 'effect_'.$name,
        ];
        $effects = HTTP::getEffect($data);
        utmdd($effects);
    }

    public function getAllEffects()
    {
        $effects = HTTP::getEffects();

        foreach ($effects['non_music'] as $key => $name) {
            $key = str_replace('effect_', '', $key);
            // MLSC::$console->writeln("<effect>"."\t".$name."\t".$key."</effect>");
            $nonMusicArray[] = [$key, $this->getCell($name)];
        }

        foreach ($effects['music'] as $key => $name) {
            $key = str_replace('effect_', '', $key);
            // MLSC::$console->writeln("<effect>"."\t".$name."\t".$key."</effect>");
            $musicArray[] = [$key, $this->getCell($name)];
        }

        $tableRows[] = [$this->getMusicHeader('Music Effects'),
            $this->getMusicHeader('Non Music Effects')];
        $tableRows[] = new TableSeparator();

        foreach ($musicArray as $i => $row) {
            $nmRow = [];
            if (\array_key_exists($i, $nonMusicArray)) {
                $nmRow = $nonMusicArray[$i];

                $row = array_merge($row, $nmRow);
            }
            $tableRows[] = $row;
        }

        $table = new Table(MLSC::$output);
        $table
            ->setHeaders(['Effect Key', 'Effect Name', 'Effect Key', 'Effect Name'])
            ->setRows($tableRows);
        $table->render();
    }
}
