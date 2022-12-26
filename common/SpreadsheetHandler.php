<?php

namespace app\common;

use Yii;
use yii\db\ActiveRecord;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class SpreadsheetHandler
{
    /**
     * @throws Exception
     */
    public static function import(string $inputFileName): array
    {
        /**  Identify the type of $inputFileName  **/
        $inputFileType = IOFactory::identify($inputFileName);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = IOFactory::createReader($inputFileType);

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        /**  Convert Spreadsheet Object to an Array for ease of use  **/
        return $spreadsheet->getActiveSheet()->toArray();
    }
}